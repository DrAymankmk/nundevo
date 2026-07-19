<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\ModuleMenuItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ModuleService
{
    public function allModuleKeys(): array
    {
        return array_keys(config('modules_management.modules', []));
    }

    public function moduleDefinitions(): array
    {
        return config('modules_management.modules', []);
    }

    public function moduleLabel(string $moduleKey, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $definition = $this->moduleDefinitions()[$moduleKey] ?? [];

        if ($locale === 'ar') {
            return $definition['label_ar'] ?? $definition['label_en'] ?? $moduleKey;
        }

        return $definition['label_en'] ?? $definition['label_ar'] ?? $moduleKey;
    }

    /**
     * Active menu items for a module, filtered by app type when provided.
     *
     * @return Collection<int, ModuleMenuItem>
     */
    public function menuItemsForModule(string $moduleKey, ?int $appType = null): Collection
    {
        if (! $this->menuItemsTableExists()) {
            return collect();
        }

        return ModuleMenuItem::query()
            ->active()
            ->forModule($moduleKey)
            ->ordered()
            ->get()
            ->filter(fn (ModuleMenuItem $item) => $item->matchesAppType($appType))
            ->values();
    }

    /**
     * Menu items the current clinic user may see (module enabled + app type).
     *
     * @return Collection<int, ModuleMenuItem>
     */
    public function visibleMenuItemsForClinic(Clinic $clinic, ?string $moduleKey = null): Collection
    {
        $query = ModuleMenuItem::query()->active()->ordered();

        if ($moduleKey) {
            if (! $this->hasModule($clinic, $moduleKey)) {
                return collect();
            }
            $query->forModule($moduleKey);
        } else {
            $enabled = $this->getEnabledModules($clinic);
            if ($enabled === []) {
                return collect();
            }
            $query->whereIn('module_key', $enabled);
        }

        $appType = (int) $clinic->app_type;

        return $query->get()
            ->filter(function (ModuleMenuItem $item) use ($clinic, $appType) {
                if (! $this->hasModule($clinic, $item->module_key)) {
                    return false;
                }

                return $item->matchesAppType($appType);
            })
            ->values();
    }

    public function organizationFor(Clinic $clinic): ?Clinic
    {
        $organizationId = Clinic::resolveOrganizationId($clinic->id);

        return $organizationId ? Clinic::find($organizationId) : null;
    }

    /**
     * Effective modules used for access checks.
     *
     * @return array<int, string>
     */
    public function getEnabledModules(Clinic $clinic): array
    {
        if ((int) $clinic->app_type === 6) {
            return $this->allModuleKeys();
        }

        $organization = $this->organizationFor($clinic);

        if (! $organization) {
            return $this->allModuleKeys();
        }

        $stored = $organization->enabled_modules;

        if ($stored === null) {
            return $this->allModuleKeys();
        }

        $valid = array_values(array_intersect(
            array_map('strval', (array) $stored),
            $this->allModuleKeys()
        ));

        return $valid;
    }

    /**
     * Modules explicitly stored on the organization (for forms/display).
     *
     * @return array<int, string>
     */
    public function getStoredModules(Clinic $organization): array
    {
        if ($organization->enabled_modules === null) {
            return [];
        }

        return array_values(array_intersect(
            array_map('strval', (array) $organization->enabled_modules),
            $this->allModuleKeys()
        ));
    }

    public function hasModule(Clinic $clinic, string $module): bool
    {
        if ((int) $clinic->app_type === 6) {
            return true;
        }

        if ($module === 'points' && ! $this->isPointsFeatureEnabled($clinic)) {
            return false;
        }

        return in_array($module, $this->getEnabledModules($clinic), true);
    }

    public function isPointsFeatureEnabled(Clinic $clinic): bool
    {
        if ((int) $clinic->app_type === 6) {
            return true;
        }

        $organization = $this->organizationFor($clinic);

        return $organization ? (bool) $organization->points_enabled : false;
    }

    public function hasRestrictedModules(Clinic $clinic): bool
    {
        if ((int) $clinic->app_type === 6) {
            return false;
        }

        $organization = $this->organizationFor($clinic);

        return $organization !== null && $organization->enabled_modules !== null;
    }

    public function loginRedirectRoute(Clinic $clinic): string
    {
        if ($this->hasModule($clinic, 'clinic_admin')) {
            return 'admin.dashboard';
        }

        if ($this->hasModule($clinic, 'points')) {
            $routes = config('modules_management.modules.points.login_route_by_app_type', []);
            $appType = (int) $clinic->app_type;

            if (! empty($routes[$appType])) {
                return $routes[$appType];
            }

            return 'loyalty.dashboard';
        }

        return 'profile';
    }

    public function requiredModuleForRoute(?string $routeName): ?string
    {
        if (! $routeName) {
            return null;
        }

        $menuItem = $this->menuItemForRoute($routeName);

        if ($menuItem) {
            if (! $menuItem->is_active || $menuItem->module_key === 'platform') {
                return null;
            }

            return $menuItem->module_key;
        }

        foreach ($this->moduleDefinitions() as $key => $definition) {
            if ($key === 'platform') {
                continue;
            }

            foreach ($definition['route_patterns'] ?? [] as $pattern) {
                if ($this->routeMatchesPattern($routeName, $pattern)) {
                    return $key;
                }
            }
        }

        return null;
    }

    public function isAlwaysAllowedRoute(?string $routeName): bool
    {
        if (! $routeName) {
            return true;
        }

        foreach (config('modules_management.always_allowed_route_patterns', []) as $pattern) {
            if ($this->routeMatchesPattern($routeName, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public function canAccessRoute(Clinic $clinic, ?string $routeName): bool
    {
        if ((int) $clinic->app_type === 6) {
            return true;
        }

        if ($this->isAlwaysAllowedRoute($routeName)) {
            return true;
        }

        $menuItem = $this->menuItemForRoute($routeName);

        // Deactivated menu item → forbidden for all clinic organizations.
        if ($menuItem && ! $menuItem->is_active) {
            return false;
        }

        if ($menuItem && $menuItem->module_key !== 'platform') {
            if (! $menuItem->matchesAppType((int) $clinic->app_type)) {
                return false;
            }

            return $this->hasModule($clinic, $menuItem->module_key);
        }

        if ($routeName === 'admin.dashboard') {
            return $this->hasModule($clinic, 'clinic_admin');
        }

        $required = $this->requiredModuleForRoute($routeName);

        if ($required === null) {
            // Restricted orgs may only use routes belonging to their enabled modules.
            return ! $this->hasRestrictedModules($clinic);
        }

        return $this->hasModule($clinic, $required);
    }

    protected function menuItemForRoute(?string $routeName): ?ModuleMenuItem
    {
        if (! $routeName || ! $this->menuItemsTableExists()) {
            return null;
        }

        return ModuleMenuItem::query()
            ->where('route_name', $routeName)
            ->first();
    }

    protected function menuItemsTableExists(): bool
    {
        return \Illuminate\Support\Facades\Schema::hasTable('module_menu_items')
            || \Illuminate\Support\Facades\Schema::hasTable('clinic_module_menu_items');
    }

    /**
     * @param  array<int, string>  $modules
     * @return array<int, string>
     */
    public function sanitizeEnabledModules(array $modules): array
    {
        return array_values(array_unique(array_intersect(
            array_map('strval', $modules),
            $this->allModuleKeys()
        )));
    }

    /**
     * @param  array<int, string>  $modules
     */
    public function syncOrganizationModules(Clinic $organization, array $modules, ?bool $pointsEnabled = null): void
    {
        $sanitized = $this->sanitizeEnabledModules($modules);

        if ($pointsEnabled === null) {
            $pointsEnabled = in_array('points', $sanitized, true);
        }

        if ($pointsEnabled && ! in_array('points', $sanitized, true)) {
            $sanitized[] = 'points';
            $sanitized = array_values(array_unique($sanitized));
        }

        if (! $pointsEnabled) {
            $sanitized = array_values(array_filter($sanitized, fn ($key) => $key !== 'points'));
        }

        $organization->update([
            'points_enabled' => (int) $pointsEnabled,
            'enabled_modules' => $sanitized,
        ]);
    }

    public function togglePointsEnabled(Clinic $organization, bool $pointsEnabled): void
    {
        $current = $organization->enabled_modules;

        if ($current === null) {
            if ($pointsEnabled) {
                $organization->update(['points_enabled' => 1]);

                return;
            }

            $modules = array_values(array_filter(
                $this->allModuleKeys(),
                fn ($key) => $key !== 'points'
            ));
            $this->syncOrganizationModules($organization, $modules, false);

            return;
        }

        $modules = array_values(array_unique(array_map('strval', (array) $current)));

        if ($pointsEnabled) {
            $modules[] = 'points';
        } else {
            $modules = array_values(array_filter($modules, fn ($key) => $key !== 'points'));
        }

        $this->syncOrganizationModules($organization, $modules, $pointsEnabled);
    }

    protected function routeMatchesPattern(string $routeName, string $pattern): bool
    {
        if ($pattern === $routeName) {
            return true;
        }

        if (Str::endsWith($pattern, '.*')) {
            $prefix = Str::beforeLast($pattern, '.*');

            return Str::startsWith($routeName, $prefix);
        }

        return false;
    }
}
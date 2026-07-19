<?php

namespace App\Http\Controllers\AdminPanel\MainAdmin;

use App\Http\Controllers\Controller;
use App\Models\AppType;
use App\Models\ModuleMenuItem;
use App\Services\ClinicModuleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ModulesController extends Controller
{
    public function __construct(protected ClinicModuleService $modules)
    {
    }

    public function index()
    {
        $definitions = collect($this->modules->moduleDefinitions())
            ->except(['platform'])
            ->all();
        $counts = ModuleMenuItem::query()
            ->where('module_key', '!=', 'platform')
            ->selectRaw('module_key, COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_count')
            ->groupBy('module_key')
            ->get()
            ->keyBy('module_key');

        $modules = collect($definitions)->map(function ($definition, $key) use ($counts) {
            $row = $counts->get($key);

            return [
                'key' => $key,
                'label' => $this->modules->moduleLabel($key),
                'label_en' => $definition['label_en'] ?? $key,
                'label_ar' => $definition['label_ar'] ?? $key,
                'app_types' => $definition['app_types'] ?? [],
                'route_patterns' => $definition['route_patterns'] ?? [],
                'total_links' => (int) ($row->total ?? 0),
                'active_links' => (int) ($row->active_count ?? 0),
            ];
        })->values();

        return view('main_admin.modules.index', compact('modules'));
    }

    public function show(string $module)
    {
        $definitions = collect($this->modules->moduleDefinitions())
            ->except(['platform'])
            ->all();

        if (! array_key_exists($module, $definitions) || $module === 'platform') {
            abort(404);
        }

        $definition = $definitions[$module];
        $items = ModuleMenuItem::query()
            ->forModule($module)
            ->ordered()
            ->get();

        $moduleKeys = array_values(array_filter(
            $this->modules->allModuleKeys(),
            fn ($key) => $key !== 'platform'
        ));
        $appTypes = AppType::query()
            ->whereIn('id', [1, 2, 7, 11])
            ->orderBy('id')
            ->get(['id', 'name_en', 'name_ar']);

        return view('main_admin.modules.show', [
            'moduleKey' => $module,
            'moduleLabel' => $this->modules->moduleLabel($module),
            'definition' => $definition,
            'items' => $items,
            'moduleKeys' => $moduleKeys,
            'appTypes' => $appTypes,
        ]);
    }

    public function store(Request $request, string $module): RedirectResponse
    {
        $this->assertValidModule($module);

        $validated = $this->validateItem($request, $module);

        ModuleMenuItem::create($validated);

        return redirect()
            ->route('modules-management.show', $module)
            ->with('success', __('main.module_menu_item_saved'));
    }

    public function update(Request $request, string $module, int $id): RedirectResponse
    {
        $this->assertValidModule($module);

        $item = ModuleMenuItem::query()->forModule($module)->findOrFail($id);
        $validated = $this->validateItem($request, $module, $item->id);

        $item->update($validated);

        return redirect()
            ->route('modules-management.show', $validated['module_key'])
            ->with('success', __('main.module_menu_item_saved'));
    }

    public function toggle(string $module, int $id): RedirectResponse
    {
        $this->assertValidModule($module);

        $item = ModuleMenuItem::query()->forModule($module)->findOrFail($id);
        $item->is_active = ! (bool) $item->is_active;
        $item->save();

        return redirect()
            ->route('modules-management.show', $module)
            ->with('success', __('main.module_menu_item_saved'));
    }

    public function destroy(string $module, int $id): RedirectResponse
    {
        $this->assertValidModule($module);

        ModuleMenuItem::query()->forModule($module)->whereKey($id)->delete();

        return redirect()
            ->route('modules-management.show', $module)
            ->with('success', __('main.module_menu_item_deleted'));
    }

    protected function assertValidModule(string $module): void
    {
        if ($module === 'platform' || ! array_key_exists($module, $this->modules->moduleDefinitions())) {
            abort(404);
        }
    }

    protected function validateItem(Request $request, string $module, ?int $ignoreId = null): array
    {
        $moduleKeys = $this->modules->allModuleKeys();

        $validated = $request->validate([
            'module_key' => ['required', Rule::in($moduleKeys)],
            'item_key' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('module_menu_items', 'item_key')->ignore($ignoreId),
            ],
            'route_name' => ['required', 'string', 'max:150'],
            'label_en' => ['required', 'string', 'max:255'],
            'label_ar' => ['required', 'string', 'max:255'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'app_types' => ['nullable', 'array'],
            'app_types.*' => ['integer'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $itemKey = trim((string) ($validated['item_key'] ?? ''));
        if ($itemKey === '') {
            $itemKey = Str::slug($validated['module_key'].'-'.$validated['route_name'].'-'.Str::random(4), '_');
        }

        return [
            'module_key' => $validated['module_key'],
            'item_key' => $itemKey,
            'route_name' => $validated['route_name'],
            'label_en' => $validated['label_en'],
            'label_ar' => $validated['label_ar'],
            'icon_class' => $validated['icon_class'] ?? null,
            'app_types' => ! empty($validated['app_types'])
                ? array_values(array_map('intval', $validated['app_types']))
                : null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMenuItem extends Model
{
    protected $fillable = [
        'module_key',
        'item_key',
        'route_name',
        'route_params',
        'label_en',
        'label_ar',
        'icon_class',
        'app_types',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'route_params' => 'array',
        'app_types' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function label(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'ar'
            ? ($this->label_ar ?: $this->label_en)
            : ($this->label_en ?: $this->label_ar);
    }

    public function matchesAppType(?int $appType): bool
    {
        if ($this->app_types === null || $this->app_types === []) {
            return true;
        }

        if ($appType === null) {
            return true;
        }

        return in_array($appType, array_map('intval', $this->app_types), true);
    }

    public function href(): string
    {
        $params = $this->route_params ?? [];

        try {
            return route($this->route_name, $params);
        } catch (\Throwable $e) {
            return '#';
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeForModule($query, string $moduleKey)
    {
        return $query->where('module_key', $moduleKey);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}

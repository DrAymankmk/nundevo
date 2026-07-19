<?php

use App\Services\ModuleService;

if (! function_exists('clinic_has_module')) {
    function clinic_has_module(string $module): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return app(ModuleService::class)->hasModule($user, $module);
    }
}

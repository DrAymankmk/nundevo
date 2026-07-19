<?php

namespace App\Http\Middleware;

use App\Services\ClinicModuleService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureClinicModuleAccess
{
    public function __construct(
        protected ClinicModuleService $modules
    ) {
    }

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        // Platform admin is unrestricted.
        if ((int) ($user->app_type ?? 0) === 6) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (! $this->modules->canAccessRoute($user, $routeName)) {
            $menuItem = null;

            try {
                $menuItem = \App\Models\ModuleMenuItem::query()
                    ->where('route_name', $routeName)
                    ->first();
            } catch (\Throwable $e) {
                // ignore missing table during early setup
            }

            $message = ($menuItem && ! $menuItem->is_active)
                ? trans('main.module_item_access_denied')
                : trans('main.module_access_denied');

            abort(403, $message);
        }

        return $next($request);
    }
}

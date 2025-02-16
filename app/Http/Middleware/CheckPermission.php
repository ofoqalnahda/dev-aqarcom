<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {

        if ($this->shouldCheckPermission($request)) {
            $permissionName = $this->getPermissionName($request);


            $permission = Permission::findOrCreate($permissionName);
            //check if permissions new created
            if($permission->wasRecentlyCreated )
            {
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            }



            if (auth()->user()->can($permissionName)) {
                return $next($request);
            } else {
                throw UnauthorizedException::forPermissions([$permissionName]);
            }
        }

        return $next($request);
    }

    protected function shouldCheckPermission(Request $request): bool
    {
        $routeName = $request->route()->getName();

        if (str_starts_with($routeName, 'dashboard.')) {
            $middleware = $request->route()->middleware();
            $action = $request->route()->getAction();
            $controllerAction = explode('@', $action['controller']);
            $controllerMethod = end($controllerAction);

            $skipMethods = ['update', 'store', 'updateLocation', 'send'];
            $skipRoutes = ['dashboard.logout', 'dashboard.marketers.sendCode', 'dashboard.home'];

            return (
                in_array('auth:admin', $middleware) &&
                isset($action['controller']) &&
                !in_array($controllerMethod, $skipMethods) &&
                !in_array($routeName, $skipRoutes)
            );
        }

        return false;
    }

    protected function getPermissionName(Request $request): string
    {
        $routeName = $request->route()->getName();
        $name = str_replace('dashboard.', '', $routeName);
        $name = str_replace('.', '-', $name);

        return $name;
    }
}

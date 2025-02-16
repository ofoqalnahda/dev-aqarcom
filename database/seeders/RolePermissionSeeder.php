<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
   /**
 * Run the database seeds.
 *
 * @return void
 */
public function run()
{
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    $routes = Route::getRoutes();

    foreach ($routes as $route) {
        $name = $route->getName();
        $action = $route->getAction();

        if (str_starts_with($name, 'dashboard.')) {
            $middleware = $route->middleware();
            $controllerAction = explode('@', $action['controller']);
            $controllerMethod = end($controllerAction);

            // Skip certain controller methods and routes
            $skipMethods = ['update', 'store', 'updateLocation', 'send'];
            $skipRoutes = ['dashboard.logout', 'dashboard.marketers.sendCode'];

            if (in_array('auth:admin', $middleware) && isset($action['controller']) && !in_array($controllerMethod, $skipMethods) && !in_array($name, $skipRoutes)) {
                $name = str_replace(['dashboard.', '.'], ['', '-'], $name);
                $permission = Permission::findOrCreate($name);
            }
        }
    }
}
}

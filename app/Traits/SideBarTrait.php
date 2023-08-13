<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;
use App\Models\Permission;

trait  SideBarTrait
{
    static function sidebar()
    {
        $my_routes      = Permission::where('role_id', auth()->guard('admin')->user()->role_id)->pluck('permission')->toArray();
        $routes         = Route::getRoutes() ;
        return view('admin.shared.sidebar.sidebar', [
            'my_routes'   => $my_routes,
            'routes'      => $routes   ,
            'routes_data' => self::authUserRoutes($my_routes , $routes),
        ]);
    }

    static function authUserRoutes($my_routes , $routes)
    {
        foreach ($routes as $route) {
            if ($route->getName() && in_array($route->getName(), $my_routes) && isset($route->getAction()['title']))
                $routes_data['"' . $route->getName() . '"'] = [
                    'title'     => $route->getAction()['title'],
                    'icon'      => isset($route->getAction()['icon']) ? $route->getAction()['icon'] : null,
                    'name'      => $route->getName(),
                ];
        }
        return $routes_data;
    }
}

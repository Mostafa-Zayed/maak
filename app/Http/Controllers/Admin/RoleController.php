<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use App\Traits\ReportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Admin\Role\Create;

class RoleController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $roles = Role::search(request()->searchArray)->paginate(30);
            $html = view('admin.roles.table' ,compact('roles'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.roles.index');
    }
  
    public function create()
    {
        $routes = Route::getRoutes();
        $routes_data = [];
        foreach ($routes as $route) {
            if ($route->getName()) {
                $routes_data['"' . $route->getName() . '"'] = ['title' => isset($route->getAction()['title']) ? $route->getAction()['title'] : null];
            }
        }
        return view('admin.roles.create' , get_defined_vars());
    }

    public function store(Create $request)
    {
        if(!$request->permissions){
            return back()->with('danger', 'يجب اختيار صلاحيه واحده علي الاقل ');
        }
        $role = Role::create($request->validated());
        // dd($request->permissions);
        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);
        ReportTrait::addToLog('  اضافه صلاحية') ;
        return redirect(route('admin.roles.index'))->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  get all roles  **************************/
    public function edit($id)
    {
        $role           = Role::findOrFail($id);
        $routes         = Route::getRoutes();
        $routes_data    = [];
        $my_routes      = Permission::where('role_id', $id)->pluck('permission')->toArray();

        foreach ($routes as $route){
            if ($route->getName()){
                $routes_data['"' . $route->getName() . '"'] = ['title' => isset($route->getAction()['title']) ? $route->getAction()['title'] : null];
            }
        }
        return view('admin.roles.edit',get_defined_vars());
    }

    public function update(Create $request, $id)
    {
        if (!$request->permissions) {
            return back()->with('danger', 'يجب اختيار صلاحيه واحده علي الاقل ');
        }
        $role = Role::findOrFail($id);
        $role->update($request->validated());
        
        $role->permissions()->delete();
        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);
        ReportTrait::addToLog('  تعديل صلاحية') ;

        return redirect(route('admin.roles.index'))->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف صلاحية') ;
        return response()->json(['id' =>$id]);
    }
}

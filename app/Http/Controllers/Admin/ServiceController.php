<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\services\Store;
use App\Http\Requests\Admin\services\Update;
use App\Models\Service ;
use App\Traits\ReportTrait;


class ServiceController extends Controller
{
    public function index($id = null)
    {
        $categories = Category::select('id','name')->whereNotNull('parent_id')->get();
        if (request()->ajax()) {
            $services = Service::with('category:id,name')->search(request()->searchArray)->paginate(30);

            $html = view('admin.services.table' ,compact('services','categories'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.services.index',['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.services.create',['categories' => Category::select('id','name')->whereNotNull('parent_id')->get()]);
    }


    public function store(Store $request)
    {
        try {
            Service::create($request->validated());
            ReportTrait::addToLog('  اضافه خدمة') ;
            return response()->json(['url' => route('admin.services.index')]);
        } catch (\Exception $e) {

        }

    }
    public function edit($id)
    {
        try {
            return view('admin.services.edit' , ['service' => Service::findOrFail($id),'categories' => Category::whereNotNull('parent_id')->get()]);
        } catch (\Exception $e) {

        }

    }

    public function update(Update $request, $id)
    {
//        dd($request->validated());
        $service = Service::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل خدمة') ;
        return response()->json(['url' => route('admin.services.index')]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show' , ['service' => $service]);
    }
    public function destroy($id)
    {
        $service = Service::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف خدمة') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Service::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من خدمات') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}

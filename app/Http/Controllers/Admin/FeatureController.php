<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\features\Store;
use App\Http\Requests\Admin\features\Update;
use App\Models\Feature ;
use App\Traits\ReportTrait;


class FeatureController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $features = Feature::search(request()->searchArray)->paginate(30);
            $html = view('admin.features.table' ,compact('features'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.features.index');
    }

    public function create()
    {
        return view('admin.features.create');
    }


    public function store(Store $request)
    {
        Feature::create($request->validated());
        ReportTrait::addToLog('  اضافه سمة') ;
        return response()->json(['url' => route('admin.features.index')]);
    }
    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.features.edit' , ['feature' => $feature]);
    }

    public function update(Update $request, $id)
    {
        $feature = Feature::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل سمة') ;
        return response()->json(['url' => route('admin.features.index')]);
    }

    public function show($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.features.show' , ['feature' => $feature]);
    }
    public function destroy($id)
    {
        $feature = Feature::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف سمة') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Feature::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من سمات') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}

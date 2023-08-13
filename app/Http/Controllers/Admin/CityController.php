<?php

namespace App\Http\Controllers\Admin;

use App\Models\City ;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\cities\Store;
use App\Models\Region;

class CityController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $cities = City::with('region')->search(request()->searchArray)->paginate(30);
            $html = view('admin.cities.table' ,compact('cities'))->render() ;
            return response()->json(['html' => $html]);
        }
        $regions = Region::get() ; 
        return view('admin.cities.index' , compact('regions'));
    }

    public function create()
    {
        $regions = Region::get() ; 
        return view('admin.cities.create' , compact('regions'));
    }

    public function store(Store $request)
    {
        City::create($request->validated());
        ReportTrait::addToLog('اضافه مدينة') ;
        return response()->json(['url' => route('admin.cities.index')]);
    }

    public function edit($id)
    {
        $regions = Region::get() ; 
        $city = City::findOrFail($id);
        return view('admin.cities.edit' , ['city' => $city , 'regions' => $regions]);
    }

    public function update(Store $request, $id)
    {
        $city = City::findOrFail($id)->update($request->validated() );
        ReportTrait::addToLog('  تعديل مدينة') ;
        return response()->json(['url' => route('admin.cities.index')]);
    }

    
     public function show($id)
     {
         $city = City::findOrFail($id);
         $regions = Region::get() ; 
         return view('admin.cities.show' , ['city' => $city , 'regions' => $regions]);
     }
 
    public function destroy($id)
    {
        $city = City::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف مدينة') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (City::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من المدن') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}

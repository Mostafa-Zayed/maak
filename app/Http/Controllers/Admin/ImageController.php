<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image ;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\images\Store;
use App\Http\Requests\Admin\images\Update;


class ImageController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $images = Image::search(request()->searchArray)->paginate(30);
            $html = view('admin.images.table' ,compact('images'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.images.index');
    }

    public function create()
    {
        return view('admin.images.create');
    }


    public function store(Store $request)
    {
        Image::create($request->validated());
        ReportTrait::addToLog('  اضافه بانر اعلاني') ;
        return response()->json(['url' => route('admin.images.index')]);
    }
    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('admin.images.edit' , ['image' => $image]);
    }

    public function update(Update $request, $id)
    {
        $image = Image::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل بانر اعلاني') ;
        return response()->json(['url' => route('admin.images.index')]);
    }
    public function show($id)
    {
        $image = Image::findOrFail($id);
        return view('admin.images.show' , ['image' => $image]);
    }
    public function destroy($id)
    {
        $image = Image::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف بانر اعلاني') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Image::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من البنرات الاعلانية') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}

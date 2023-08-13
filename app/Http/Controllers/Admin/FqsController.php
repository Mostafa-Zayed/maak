<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\fqs\Store;
use App\Models\Fqs ;
use App\Traits\ReportTrait;


class FqsController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $fqss = Fqs::search(request()->searchArray)->paginate(30);
            $html = view('admin.fqs.table' ,compact('fqss'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.fqs.index');
    }

    public function create()
    {
        return view('admin.fqs.create');
    }


    public function store(Store $request)
    {
        Fqs::create($request->validated());
        ReportTrait::addToLog('  اضافه سؤال') ;
        return response()->json(['url' => route('admin.fqs.index')]);
    }
    public function edit($id)
    {
        $fqs = Fqs::findOrFail($id);
        return view('admin.fqs.edit' , ['fqs' => $fqs]);
    }

    public function update(Store $request, $id)
    {
        $fqs = Fqs::findOrFail($id)->update($request->validated() );
        ReportTrait::addToLog('  تعديل سؤال') ;
        return response()->json(['url' => route('admin.fqs.index')]);
    }
    public function show($id)
    {
        $fqs = Fqs::findOrFail($id);
        return view('admin.fqs.show' , ['fqs' => $fqs]);
    }
    public function destroy($id)
    {
        $fqs = Fqs::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف سؤال') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Fqs::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من الاسئلة_الشائعة') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}

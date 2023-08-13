<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Mail\SendMail;
use App\Traits\ReportTrait;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Notifications\BlockUser;
use App\Notifications\NotifyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\Client\Store;
use App\Http\Requests\Admin\Client\Update;
use Illuminate\Support\Facades\Notification;

class ClientController extends Controller {

    public function index($id = null) {
        if (request()->ajax()) {
            $rows = User::search(request()->searchArray)->paginate(30);
            $html = view('admin.clients.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.clients.index');
    }

    public function create() {
        return view('admin.clients.create');
    }

    public function store(Store $request) {
        User::create($request->validated());
        ReportTrait::addToLog('  اضافه مستخدم');
        return response()->json(['url' => route('admin.clients.index')]);
    }

    public function edit($id) {
        $row = User::findOrFail($id);
        return view('admin.clients.edit', ['row' => $row]);
    }

    public function update(Update $request, $id) {
        $user = User::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل مستخدم');
        return response()->json(['url' => route('admin.clients.index')]);
    }

    public function show($id) {
        $row = User::findOrFail($id);
        return view('admin.clients.show', ['row' => $row]);
    }
    public function showfinancial($id) {
        $complaints = Complaint::where('user_id', $id)->paginate(10);
        return view('admin.complaints.user_complaints', ['complaints' => $complaints]);
    }

    public function showorders($id) {
        $orders = Order::where('user_id', $id)->paginate(10);
        return view('admin.clients.orders', ['orders' => $orders]);
    }


    public function destroy($id) {
        $user = User::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف مستخدم');
        return response()->json(['id' => $id]);
    }

    // public function blockUser(Request $request) {
    //     $user = User::findOrFail($request->id);
    //     Notification::send($user , new BlockUser());
    //     return response()->json(['message' =>  $user->refresh()->is_blocked == 1 ? __('admin.blocked') :  __('admin.unblocked')]) ; 
    // }

    public function block(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['is_blocked' => !$user->is_blocked]);
        if ($user->refresh()->is_blocked == 1) {
            Notification::send($user, new BlockUser($request->all()));
        }
        return response()->json(['message' => $user->refresh()->is_blocked == 1 ? __('admin.blocked') :  __('admin.unblocked')]);
    }


    public function notify(Request $request) {
        if ($request->notify == 'notifications') {
            $client = ('all' == $request->id) ? User::latest()->get() : User::findOrFail($request->id);
            Notification::send($client, new NotifyUser($request->all()));
        } else {
            $mail = ('all' == $request->id) ? User::where('email', '!=', null)->get()->pluck('email')->toArray() : User::findOrFail($request->id)->email;
            Mail::to($mail)->send(new SendMail(['title' => 'اشعار اداري', 'message' => $request->message]));
        }
        return response()->json();
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (User::whereIn('id', $ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من المستخدمين');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\Models\Permission;
use App\Traits\ResponseTrait;
use App\Traits\AdminFirstRouteTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminMiddleware {
  use ResponseTrait, AdminFirstRouteTrait;

  public function handle($request, Closure $next) {

    if (!Auth::guard('admin')->check() || !Auth::guard('admin')->user()->role_id > 0) {
      return redirect()->route('admin.login');
    }
    
    $permissions = Permission::where('role_id', auth()->guard('admin')->user()->role_id)
    ->pluck('permission')
    ->toArray();

    if (!in_array(Route::currentRouteName(), $permissions)) {
      $msg = trans('auth.not_authorized');
      if ($request->ajax()) {
        return $this->unauthorizedReturn(['type' => 'notAuth']);
      }

      if (!count($permissions)) {
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('admin.login'));
      }

      session()->flash('danger', $msg);

      return redirect()->route($this->getAdminFirstRouteName($permissions));
    }

    if(session()->has('beforeLoginUrl')){
      $currentUrl = session()->get('beforeLoginUrl');
      session()->remove('beforeLoginUrl');
      return redirect()->to($currentUrl);
    }

    return $next($request);
  }
}

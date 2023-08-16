<?php

namespace App\Services\auth;

use App\Models\User;
use App\Models\UserUpdate;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use GeneralTrait ;

    public function register($request){
        DB::beginTransaction();
        try {
            $user = User::create($request);
            $user->sendVerificationCode();
            DB::commit() ;
            return ['key' => 'success'  , 'msg' =>  __('auth.registered'), 'user' => $user->refresh()];
        } catch (\Exception $e) {
            DB::rollback();
            return ['key' => 'fail', 'msg' => __('site.wrong'), 'user' => []];
        }
    }

    public function activate($request)  {
        $user = User::where(['phone' => $request['phone'], 'country_code' => $request['country_code']])->first();
        return ['key' => 'success' ,'msg' => __('auth.activated') , 'user' => $user->refresh()];
    }

    public function resendCode($request)  {
        $user = User::where(['phone' => $request['phone'], 'country_code' => $request['country_code']])->first();
        $user->sendVerificationCode();
        return ['key' => 'success', 'msg' => __('auth.code_re_send'), 'user' => $user->refresh()];
    }

    public function login($request) {
        $user = User::where(['phone' => $request['phone'], 'country_code' => $request['country_code']])->first();
        
        if (!$user) {
            return ['key' => 'fail', 'msg' => __('auth.incorrect_key_or_phone'), 'user' => []];
        }

        if (!Hash::check($request['password'], $user->password)) {
            return ['key' => 'fail', 'msg' => __('auth.incorrect_pass'), 'user' => []];
        }

        if ($user->is_blocked) {
            return ['key' => 'blocked', 'msg' => __('auth.blocked'), 'user' => $user];
        }

        if (!$user->active) {
            return ['key' => 'needActive' , 'msg' => __('auth.not_active'), 'user' => $user];
        }
        return ['key' => 'success' , 'msg' => __('auth.signed'), 'user' => $user];
    }

    public function updateProfile($request)  {
        $user = auth()->user();
        $user->update($request) ; 
        return ['key' => 'success', 'msg' => __('auth.account_updated'), 'user' => $user->refresh()];
    }

    public function forgetPasswordSendCode($request)
    {
        $user = User::where(['phone' => $request['phone'], 'country_code' => $request['country_code']])->first();
        if (!$user) {
            return ['key' => 'fail', 'msg' => __('auth.incorrect_key_or_phone'), 'user' => []];
        }
        UserUpdate::updateOrCreate(['user_id' => $user->id, 'type' => 'password'] , ['code' => '']); // code will be filled from  UserUpdate model 

        return ['key' => 'success', 'msg' => __('apis.success') , 'user' => $user->refresh()];
    }


    public function resetPassword($request){
        $user = User::where(['phone' => $request['phone'], 'country_code' => $request['country_code']])->first();
        UserUpdate::where(['user_id' => $user->id, 'type' => 'password', 'code' => $request['code']])->first()->delete();
        $user->update(['password' => $request['password']]);
        return ['key' => 'success', 'msg' => __('auth.password_changed')];
    }


    public function changePhoneSendCode($request) {
        $update = UserUpdate::updateOrCreate([
            'user_id'      => auth()->id(),
            'type'         => 'phone',
            'country_code' => $request['country_code'],
            'phone'        => $request['phone'],
        ], [
            'code' => '',
        ])->refresh();
        auth()->user()->sendCodeAtSms($update->code, $update->full_phone);
//        return
        return $this->successMsg(__('apis.success'));
    }

}

<?php

namespace App\Repositories;

use App\Models\Provider;
use App\Repositories\Contracts\ProviderInterface;
use Illuminate\Support\Facades\DB;

class ProviderRepository implements ProviderInterface
{


    public function register($request)
    {
        // TODO: Implement register() method.

        DB::beginTransaction();
        try {
            $provider = Provider::create($request);
//            $provider->sendVerificationCode();
            DB::commit() ;
            return ['key' => 'success'  , 'msg' =>  __('auth.registered'), 'user' => $provider->refresh()];
        } catch (\Exception $e) {
            DB::rollback();
            return ['key' => 'fail', 'msg' => __('site.wrong'), 'user' => []];
        }
    }


    public function login()
    {
        // TODO: Implement login() method.
    }


    public function verify()
    {
        // TODO: Implement verify() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

}
<?php

namespace App\Repositories;

use App\Models\Provider;
use App\Models\ProviderUpdate;
use App\Models\User;
use App\Repositories\Contracts\ProviderInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProviderRepository implements ProviderInterface
{


    public function register($providerInfo)
    {
        return $this->store($providerInfo);
    }

    public function store($providerInfo)
    {
        return Provider::create($providerInfo);
    }

    public function login($requestPayload)
    {
        $provider = Provider::where('phone', $requestPayload['phone'])->where('country_code', $requestPayload['country_code'])->first();
        return Hash::check($requestPayload['password'], $provider->password) ? $provider : false;
    }

    public function verifyAccount(& $provider): static
    {
        $provider->update(['code' => null, 'code_expire' => null, 'active' => true]);
        return $this;
    }

    public function updateUserDevice(& $provider): static
    {
        $provider->devices()->updateOrCreate([
            'device_id'   => request()->device_id,
            'device_type' => request()->device_type,
        ]);
        return $this;
    }

    public function updateUserLang(& $provider): static
    {
        if (request()->header('Lang') != null && in_array(request()->header('Lang'), languages())) {
            $provider->update(['lang' => request()->header('Lang')]);
        } else {
            $provider->update(['lang' => defaultLang()]);
        }
        return $this;
    }

    public function logout($request): bool
    {
        auth()->user()->tokens()->delete();
        auth()->user()->devices()->where(['device_id' => request()->device_id])->delete();
        return true;
    }

    public function sendVerificationCode(& $requestPayload): bool
    {
        if($provider = Provider::where('country_code',$requestPayload['country_code'])->where('phone',$requestPayload['phone'])->first()) {
            if(auth()->user()->id == $provider->id) {
                $provider->update(['code' => self::getTestActivationCode(),'code_expire' => Carbon::now()->addMinute()]);
                return true;
            }
        }
        return false;
    }

    public function sendProviderUpdateVerifyCode()
    {
//        ProviderUpdate::updateOrCreate()
    }

    public static function getTestActivationCode(): string
    {
        return '1234';
    }

    public function storeProviderUpdate($requestPayload)
    {
        self::checkIsProviderHasUpdateOperation($requestPayload) ? self::updateExpirationActiveCode(auth()->user()->id,'password',5) : self::addNewProviderStore($requestPayload);
    }

    public static function updateExpirationActiveCode($providerId,$type,$timeWithMinutes = 5)
    {
        DB::table('provider_updates')->where('provider_id',$providerId)->where('status','pending')->where('type',$type)->update(['code' => self::getTestActivationCode(),'code_expire' => Carbon::now()->addMinutes($timeWithMinutes)]);
    }

    public static function addNewProviderStore($requestPayload)
    {
        DB::table('provider_updates')->insert([
            'provider_id' => auth()->user()->id,
            'code' => self::getTestActivationCode(),
            'code_expire' => Carbon::now()->addMinutes(5),
            'country_code' => $requestPayload['country_code'],
            'phone' => $requestPayload['phone'],
            'type' => $requestPayload['type'],
            'email' => auth()->user()->email ?? ''
        ]);
    }

    public static function checkIsProviderHasUpdateOperation(& $requestPayload): bool
    {
        return DB::table('provider_updates')->where('country_code',$requestPayload['country_code'])->where('phone',$requestPayload['phone'])->where('type',$requestPayload['type'])->where('status','pending')->where('provider_id',auth()->user()->id)->exists();
    }

    public function updateProviderUpdateStatus($requestPayload): int
    {
        return DB::table('provider_updates')->where('country_code',$requestPayload['country_code'])->where('phone',$requestPayload['phone'])->where('status','pending')->where('provider_id',auth()->user()->id)->where('type',$requestPayload['type'])->update(['status' => 'completed']);
    }

    public function updatePassword($requestPayload)
    {
        return auth()->user()->update(['password' => $requestPayload['password']]);
    }

    public function getAuthProvider(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }

    public function updateProfile($requestPayload)
    {
        return auth()->user()->update($requestPayload);
    }

}
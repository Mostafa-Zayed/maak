<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\UserUpdate;
use App\Repositories\Contracts\UserInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function register($authInfo)
    {
        return $this->store($authInfo);
    }

    public function login($requestPayload)
    {
        return User::where('phone', $requestPayload['phone'])->where('country_code', $requestPayload['country_code'])->first();
    }

    public function store($userInfo)
    {
        return User::create($userInfo);
    }

    public function verifyAccount(& $user): static
    {
        $user->update(['code' => null, 'code_expire' => null, 'active' => true]);
        return $this;
    }

    public function updateUserDevice(& $user): static
    {
        $user->devices()->updateOrCreate([
            'device_id'   => request()->device_id,
            'device_type' => request()->device_type,
        ]);
        return $this;
    }

    public function updateUserLang(& $user): static
    {
        if (request()->header('Lang') != null && in_array(request()->header('Lang'), languages())) {
            $user->update(['lang' => request()->header('Lang')]);
        } else {
            $user->update(['lang' => defaultLang()]);
        }
        return $this;
    }

    public function updateProfile($requestPayload)
    {
        return auth()->user()->update(['name' => $requestPayload['name']]);
    }

    public function sendActiveCode(& $user): static
    {
        $user->update([
            'code'        => 1234,
            'code_expire' => Carbon::now()->addMinute(),
        ]);
        return $this;
    }

    public function updatePhone($requestPayload)
    {
        UserUpdate::updateOrCreate([
            'user_id'      => auth()->id(),
            'type'         => 'phone',
            'country_code' => $requestPayload['country_code'],
            'phone'        => $requestPayload['phone'],
        ], [
            'code' => '',
        ])->refresh();

        // wait integration
    }

    public function changePhoneCheckCode($requestPayload): static
    {
        auth()->user()->update(['phone' => $requestPayload['phone'], 'country_code' => $requestPayload['country_code']]);
        return $this;
    }

    public function logout($request): bool
    {
        return $request->bearerToken() ? Auth::guard('sanctum')->user()->logout() : false;
    }
}
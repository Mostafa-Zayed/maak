<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Requests\Api\User\ChangePhoneCheckCodeRequest;
use App\Http\Requests\Api\User\ChangePhoneSendCodeRequest;
use App\Http\Requests\Api\User\ResendCodeRequest;
use App\Http\Requests\Api\User\RegisterRequest;
use App\Http\Requests\Api\User\UpdatePasswordRequest;
use App\Http\Requests\Api\User\VerifyCode;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use App\Models\UserUpdate;
use App\Repositories\Contracts\UserInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Api\User\UpdateProfileRequest;

class AuthController extends Controller
{
    use ResponseTrait;
    private UserInterface $userRepository;

    public function __construct(UserInterface $userInterface)
    {
        $this->userRepository = $userInterface;
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->userRepository->register($request->validated());
            return $this->successData($user->refresh());

        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if($user = $this->userRepository->login($request->validated())) {
                if ($user->active) {
                    if (! $user->is_blocked) {
                        $this->userRepository->verifyAccount($user)->updateUserDevice($user)->updateUserLang($user);
                        $token = $user->createToken(request()->device_type)->plainTextToken;
                        return $this->response('success', __('apis.signed'),[UserResource::make($user)->setToken($token)]);
                    }
                    return $this->blockedReturn($user);
                }
                return $this->phoneActivationReturn($user);
            }
            return $this->failMsg(__('auth.failed'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function verifyCode(VerifyCode $request): \Illuminate\Http\JsonResponse|UserResource
    {
        try {
            if($user = User::select(['id','phone','country_code','code','name'])->where('phone',$request->phone)->where('country_code',$request->country_code)->first()) {
                if($user->code == $request->code){
                    $this->userRepository->verifyAccount($user)->updateUserDevice($user)->updateUserLang($user);
                    $token = $user->createToken(request()->device_type)->plainTextToken;
                    return $this->response('success', __('auth.activated'),[UserResource::make($user)->setToken($token)]);
                }
                return $this->failMsg(trans('auth.code_invalid'));
            }
            return $this->failMsg(__('auth.failed'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            if($this->userRepository->updateProfile($request->validated())){
                return $this->response('success', __('apis.updated'),[UserResource::make(auth()->user())->setToken(ltrim($request->header('authorization'), 'Bearer '))]);
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function resendCode(ResendCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if($user = User::select(['id','phone','country_code','code','name'])->where('phone',$request->phone)->where('country_code',$request->country_code)->first()){
                $this->userRepository->sendActiveCode($user);
                return $this->response('success', __('auth.code_re_send'));
            }
            return $this->failMsg(__('auth.failed'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function changePhoneSendCode(ChangePhoneSendCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->userRepository->updatePhone($request->validated());
            return $this->successMsg(__('apis.success'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function changePhoneCheckCode(ChangePhoneCheckCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if($userUpdate = UserUpdate::where(['user_id' => auth()->id(), 'type' => 'phone', 'code' => $request->code])->first()){
                $this->userRepository->changePhoneCheckCode($request->validated());
                $userUpdate->delete();
                return $this->successMsg(__('apis.success'));
            }
            return $this->failMsg(trans('auth.code_invalid'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->userRepository->logout($request);
            return $this->response('success', __('apis.loggedOut'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    // waiting fo analysis
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            dd($request->all());
        } catch (\Exception $e) {

        }
    }
}

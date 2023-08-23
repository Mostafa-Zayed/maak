<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Provider\ChangePasswordSendCode;
use App\Http\Requests\Api\Provider\LoginRequest;
use App\Http\Requests\Api\Provider\RegisterRequest;
use App\Http\Requests\Api\Provider\UpdateBankRequest;
use App\Http\Requests\Api\Provider\UpdatePasswordRequest;
use App\Http\Resources\Api\Provider\ProfileResource;
use App\Http\Resources\Api\Provider\ProviderResource;
use App\Http\Resources\Api\User\UserResource;
use App\Repositories\Contracts\ProviderInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Api\Provider\ChangePasswordVerifyCode;

class AuthController extends Controller
{
    use ResponseTrait;

    private ProviderInterface $providerRepository;

    public function __construct(ProviderInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData($this->providerRepository->register($request->validated())->refresh());
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if($provider = $this->providerRepository->login($request->validated())) {
                if ($provider->active) {
                    if (! $provider->is_blocked) {
                        $this->providerRepository->verifyAccount($provider)->updateUserDevice($provider)->updateUserLang($provider);
                        $token = $provider->createToken(request()->device_type)->plainTextToken;
                        return $this->response('success', __('apis.signed'),[ProviderResource::make($provider)->setToken($token)]);
                    }
                    return $this->blockedReturn($provider);
                }
                $provider->update(['code' => self::getTestPhoneCode(),'code_expire' => Carbon::now()->addMinute(),]);
                return $this->failMsg(__('admin.account_not_active'));
            }
            return $this->failMsg(__('auth.failed'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public static function getTestPhoneCode(): string
    {
        return '1234';
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->providerRepository->logout($request);
            return $this->response('success', __('apis.loggedOut'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function changePasswordSendCode(ChangePasswordSendCode $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->providerRepository->storeProviderUpdate($request->validated());
            return $this->response('success', __('auth.code_re_send'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }

    }

    public function changePasswordVerifyCode(ChangePasswordVerifyCode $request): \Illuminate\Http\JsonResponse
    {
        try {
            if($this->providerRepository->updateProviderUpdateStatus($request->validated())){
                return $this->successMsg(__('apis.success'));
            }
            return $this->failMsg(trans('auth.code_invalid'));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function updatePassword(UpdatePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->providerRepository->updatePassword($request->all());
            return $this->successMsg(__('apis.updated'));
        } catch (\UnexpectedValueException $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function getProfile(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successData(new ProfileResource($this->providerRepository->getAuthProvider()));
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }

    public function updateBankInfo(UpdateBankRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if(auth()->user()) {
                $this->providerRepository->updateProfile($request->validated());
                return $this->successData('ok');
            }
            return $this->failMsg('no');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }
}

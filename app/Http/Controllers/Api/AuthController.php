<?php
namespace App\Http\Controllers\Api;
use App\Models\UserUpdate;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\auth\AuthService;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ActivateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResendCodeRequest;
use App\Http\Requests\Api\Auth\UpdateProfileRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\UpdatePasswordRequest;
use App\Http\Requests\Api\Auth\changePhoneSendCodeRequest;
use App\Http\Requests\Api\User\changePhoneCheckCodeRequest;
use App\Http\Requests\Api\Auth\forgetPasswordSendCodeRequest;
use App\Http\Requests\Api\Auth\forgetPasswordCheckCodeRequest;
use App\Http\Resources\Api\Notifications\NotificationsCollection;

class AuthController extends Controller {

    use ResponseTrait ;

    public function register(RegisterRequest $request) {
        $data = (new AuthService())->register($request->validated());
        return $this->response( $data['key'] ,$data['msg'] , $data['user'] == [] ? [] :  new UserResource($data['user']) );
    }

    public function activate(ActivateRequest $request) {
        $data = (new AuthService())->activate($request->validated());
        return $this->response('success', __('auth.activated'), $data['user']->markAsActive()->login());
    }


    public function resendCode(ResendCodeRequest $request) {
        (new AuthService())->resendCode($request->validated());
        return $this->response('success', __('auth.code_re_send'));
    }


    public function login(LoginRequest $request) {
        $data = (new AuthService())->login($request->validated());

        if ($data['key'] == 'fail') {
            return $this->failMsg($data['msg']);
        }

        if ($data['key'] == 'blocked') {
            return $this->blockedReturn($data['user']);
        }

        if ($data['key'] == 'needActive') {
            return $this->phoneActivationReturn($data['user']);
        }

        return $this->response('success', __('apis.signed'), $data['user']->login());
    }

    public function logout(Request $request) {
        auth()->user()->logout();
        return $this->response('success', __('apis.loggedOut'));
    }

    public function getProfile(Request $request) {
        return $this->successData(UserResource::make(auth()->user())->setToken(ltrim($request->header('authorization'), 'Bearer ')));
    }


    public function updateProfile(UpdateProfileRequest $request) {
        $data = (new AuthService())->updateProfile($request->validated());
        $requestToken = ltrim($request->header('authorization'), 'Bearer ');
        return $this->response('success',  $data['msg'],  UserResource::make($data['user'])->setToken($requestToken)  );
    }

    public function updatePassword(UpdatePasswordRequest $request) {
        auth()->user()->update($request->validated());
        return $this->successMsg(__('apis.updated'));
    }

    public function forgetPasswordSendCode(forgetPasswordSendCodeRequest $request) {
        $data = (new AuthService())->forgetPasswordSendCode($request->validated());
        if ($data['key'] == 'fail') {
            return $this->failMsg($data['msg']);
        }else{
            return $this->successMsg($data['msg']);
        }
    }

    public function forgetPasswordCheckCode(forgetPasswordCheckCodeRequest $request){
        return $this->successMsg(__('auth.code_checked'));
    }


    public function resetPassword(ForgetPasswordRequest $request) {
        $data = (new AuthService())->resetPassword($request->validated());
        return $this->successMsg($data['msg']);
    }

    public function changeLang(Request $request) {
        auth()->user()->update(['lang' => $request->lang]);
        App::setLocale($request->lang);
        return $this->successMsg(__('apis.updated'));
    }

    public function switchNotificationStatus() {
        $user = auth()->user();
        $user->update(['is_notify' => !$user->is_notify]);
        return $this->response('success', __('apis.updated'), ['notify' => (bool) $user->refresh()->is_notify]);
    }

    public function getNotifications() {
        auth()->user()->unreadNotifications->markAsRead();
        $notifications = new NotificationsCollection(auth()->user()->notifications()->paginate($this->paginateNum()));
        return $this->successData(['notifications' => $notifications]);
    }

    public function countUnreadNotifications() {
        return $this->successData(['count' => auth()->user()->unreadNotifications->count()]);
    }

    public function deleteNotification($notification_id) {
        auth()->user()->notifications()->where('id', $notification_id)->delete();
        return $this->successMsg(__('site.notify_deleted'));
    }

    public function deleteNotifications() {
        auth()->user()->notifications()->delete();
        return $this->successMsg(__('apis.deleted'));
    }

    public function changePhoneSendCode(changePhoneSendCodeRequest $request) {
        $update = UserUpdate::updateOrCreate([
            'user_id'      => auth()->id(),
            'type'         => 'phone',
            'country_code' => $request->country_code,
            'phone'        => $request->phone,
        ], [
            'code' => '',
        ])->refresh();
        auth()->user()->sendCodeAtSms($update->code, $update->full_phone);
        return $this->successMsg(__('apis.success'));
    }

    public function changePhoneCheckCode(changePhoneCheckCodeRequest $request) {
        $update = UserUpdate::where(['user_id' => auth()->id(), 'type' => 'phone', 'code' => $request->code])->first();
        if (!$update) {
            return $this->failMsg(trans('auth.code_invalid'));
        }
        auth()->user()->update(['phone' => $update->phone, 'country_code' => $update->country_code]);
        $update->delete();
        return $this->successMsg(__('apis.success'));
    }

    
    public function deleteAccount() {
        // if there any delete conditions write it here
        auth()->user()->delete();
        return $this->successMsg(__('auth.account_deleted'));
    }

}

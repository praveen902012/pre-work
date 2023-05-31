<?php
namespace Redlof\Page\Controllers;

use Exceptions\EntityNotFoundException;
use Exceptions\ValidationFailedException;
use Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use JWTAuth;
use Redlof\Core\Controllers\Controller;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\Page\Controllers\Requests\PasswordRequest;
use Redlof\Page\Controllers\Requests\PhonePasswordRequest;
use Redlof\Page\Controllers\Requests\ResetPasswordRequest;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class PasswordController extends Controller
{
    protected $user;
    use ResetsPasswords;

    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }

    public function postResetLink(PasswordRequest $request, UserRepo $user)
    {
        $Member = \UserHelper::checkExistenseofEmail($request->email);

        // $msg = 'A password reset mail has been sent to ' . $request->input('email');
        $error = false;

        if (empty($Member)) {
            $msg = 'This email address is not registered with us. If you want to create an account, hit sign up.';
            throw new EntityNotFoundException($msg);
        }

        $token = str_random(64);
        $token = strtolower($token);

        $user_password_resets = [
            [
                'user_id' => $Member->id,
                'token' => $token,
                'created_at' => \Carbon::now(),
            ]];
        \DB::table('user_password_resets')->where('user_id', $Member->id)->delete();
        \DB::table('user_password_resets')->insert($user_password_resets);

        $link = url($request->state . '/password/reset/' . $token);

        $EmailData = array(
            'link' => $link,
        );

        $subject = 'Reset Password';

        \MailHelper::sendSyncMail('page::emails.state-reset-password', $subject, $Member->email, $EmailData);

        $show = [
            'redirect' => '/' . $request->state,
        ];

        return api('Password reset link has been sent to your mail address.', $show);
    }

    public function postResetPhone(PhonePasswordRequest $request)
    {

        $Member = \Models\User::where('phone', $request->phone)->first();

        // $msg = 'A password reset mail has been sent to ' . $request->input('email');
        $error = false;

        if (empty($Member)) {
            $msg = 'This phone number is not registered with us. If you want to create an account, Please register your school';
            throw new EntityNotFoundException($msg);
        }

        $newPass = str_random(8);

        $hashPasword = Hash::make($newPass);

        $newSchoolAdmin = \Models\User::where('id', $Member->id)
            ->update(['password' => $hashPasword]);

        // $input['phone'] = $request->phone;
        // $input['message'] = 'We received a password reset request for your account, Your new password is ##'. $newPass .'## - PE Indus Action';

        $msgData = [
            "flow_id" => env('MSG_PASSWORD_FLOW_ID', '60d5d00310be1a30c523c202'),
            "phone" => $request->phone,
            "variables" => array(
                "var" => $newPass,
            ),
        ];

        \MsgHelper::sendTemplateSMS($msgData);

        $schoolAdmin = \Models\User::where('id', $Member->id)->first();

        if ($schoolAdmin->email) {

            $EmailData = array(
                'first_name' => $schoolAdmin->first_name,
                'email' => $schoolAdmin->email,
                'password' => $newPass,
            );

            $subject = 'Your Password Has Been Changed!';

            // \MailHelper::sendSyncMail('page::emails.sendpasswordresend', $subject, $schoolAdmin->email, $EmailData);
        }

        $show = ['redirect' => '/' . $request->state];

        return api('New password has been sent to your phone number.', $show);
    }

    public function postResetPassword(ResetPasswordRequest $request)
    {

        $info = \DB::table('user_password_resets')->where('token', $request->token)->first();

        if (empty($info)) {
            throw new ValidationFailedException('This is not a valid token.');
        }

        $user = \Models\User::find($info->user_id);

        $credentials = array(
            'token' => $request->input('token'),
            'email' => $user['email'],
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        );

        \DB::table('user_password_resets')->where('token', $request->token)->delete();

        $user->password = $request->password;
        $user->save();

        $data = route('state', $request->state);

        return response()->json(['data' => $data, 'msg' => 'Your password has been successfully reset, now you can signin with new password', 'error' => false], 200);

    }

    public function postSignOut()
    {

        $token = JWTAuth::getToken();
        $value = \AuthHelper::getCurrentUser();

        // $ActivityHelper = new ActivityHelper();
        // $ActivityHelper->record($value, 'signed-out');

        try {
            $newToken = JWTAuth::refresh($token);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['msg' => 'Token expired', 'status' => $e->getStatusCode()], $e->getStatusCode());
        }

        return response()->json(['msg' => 'SignOut Successfully'], 200);
    }
}

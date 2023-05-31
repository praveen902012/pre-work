<?php
namespace Redlof\Engine\Auth\Repositories;

use Exceptions\EntityAlreadyExistsException;
use Illuminate\Support\Facades\Hash;
use Models\Role;
use Models\User;
use Redlof\Core\Helpers\MailHelper;
use Redlof\Core\Repositories\AbstractEloquentRepository;

class UserRepo extends AbstractEloquentRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create($input)
    {

        // Check if email id from input exists and if yes throw exception
        $checkIfEmailExists = $this->getByValue('email', $input['email']);

        if ($checkIfEmailExists) {
            // Throw Exception
            throw new EntityAlreadyExistsException('Seems like you have already signed up with us using this email. Use forgot password to recover your password');
        }

        $user = $this->getUserObjectsWithData($input);

        if ($user->save()) {

            if (isset($input['role_type'])) {
                //Attach new roles
                $RoleObj = Role::where('name', $input['role_type'])->first();
                $user->attachRole($RoleObj);

                $input['user_id'] = $user->id;

                $EmailData = array(
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'confirmation_code' => $user->confirmation_code,
                );

                $subject = 'Welcome to RTE!';

                \MailHelper::sendSyncMail('admin::emails.welcome', $subject, $user->email, $EmailData);
            }

            return $user;
        }

        return false;
    }

    public function changePassword($input)
    {

        $userId = \AuthHelper::getCurrentUser()->id;
        $user = $this->model->find($userId);

        if (Hash::check($input['password'], $user->password)) {
            throw new EntityAlreadyExistsException('Your current password is same as the new password you typed in.');
        }

        if (Hash::check($input['old_password'], $user->password)) {

            $user->password = $input['password'];
            return $user->update();
        }

        return false;
    }

    public function enforceChangePassword($input, $user)
    {

        $user = $this->model->find($user->id);

        $user->password = $input['password'];
        $user->change_pass = false;
        return $user->update();

        return false;
    }

    public function updateProfile($input)
    {
        $userId = \AuthHelper::getCurrentUser()->id;

        $user = $this->model->find($userId);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->phone = isset($input['phone']) ? $input['phone'] : '';

        $user->dob = isset($input['dob']) ? $input['dob'] : '';

        $user->email = isset($input['email']) ? $input['email'] : '';
        $user->gender = isset($input['gender']) ? $input['gender'] : '';
        $user->update();

        return $user;
    }

    public function confirmAccount($token)
    {
        $Data = array();
        $user = $this->model->where('confirmation_code', $token)->first();

        if ($user) {
            if ($user->confirmed == 'TRUE') {
                $Data['msg'] = 'Your account is already confirmed.';
                $Data['status'] = 401;

                return $Data;
            }

            if ($user->confirmation_code == $token) {
                $user->confirmed = true;
                $user->status = 'active';
                $user->save();

                $Data['msg'] = 'Your account has been successfully confirmed!';
                $Data['status'] = 200;

                $EmailData = array(
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'confirmation_code' => $user->confirmation_code,
                );
                return $Data;
            }

            $Data['msg'] = 'Your confirmation code does not match.';
            $Data['status'] = 401;

            return $Data;
        }

        $Data['msg'] = 'That confirmation code does not exist.';
        $Data['status'] = 401;

        return $Data;
    }

    private function getUserObjectsWithData($input)
    {
        $this->model->first_name = isset($input['first_name']) ? $input['first_name'] : '';
        $this->model->last_name = isset($input['last_name']) ? $input['last_name'] : '';
        $this->model->email = $input['email'];
        $this->model->username = isset($input['username']) ? $input['username'] : $input['email'];
        $this->model->password = $input['password'];
        $this->model->phone = isset($input['phone']) ? $input['phone'] : null;
        $this->model->status = isset($input['status']) ? 'active' : 'inactive';
        $this->model->confirmation_code = md5(uniqid(mt_rand(), true));
        $this->model->confirmed = isset($input['confirmed']) ? '1' : '0';

        return $this->model;
    }

    public function getMemberSearch($request)
    {
        if (!isset($request['s']) || empty($request['s'])) {
            return [];
        }

        $keyword = $request['s'];

        $userModel = $this->model;

        $users = $userModel->where('first_name', 'ilike', "%$keyword%")->orWhere('last_name', 'ilike', "%$keyword%");

        $result = $users->get();

        return $result;

    }

    public function generatePassword($user)
    {
        $randomPass = rand();

        $user->password = bcrypt($randomPass);

        $EmailData = array(
            'receiver_name' => $user->first_name,
            'password' => $randomPass,
        );

        $subject = '[RTE] Your new password';

        \MailHelper::sendSyncMail('admin::emails.mandatory-reset-password', $subject, $user->email, $EmailData);

        return $user;

    }

}

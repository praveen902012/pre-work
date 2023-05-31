<?php
namespace Redlof\RoleAdmin\Controllers\Role;

use Illuminate\Http\Response;
use Models\User;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleAdmin\Controllers\Role\Requests\ChangePasswordRequest;
use Redlof\RoleAdmin\Controllers\Role\Requests\DashboardInfoRequest;
use Redlof\RoleAdmin\Controllers\Role\Requests\UpdatePhotoRequest;
use Redlof\RoleAdmin\Controllers\Role\Requests\UpdateProfileRequest;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;

class RoleAdminController extends RoleAdminBaseController {

	public function postChangePassword(ChangePasswordRequest $request, UserRepo $userRepo) {

		$Msg = 'This is not your old password';
		$Status = Response::HTTP_UNPROCESSABLE_ENTITY;

		$user = $userRepo->changePassword($request->all());

		if ($user) {
			$Msg = 'Successfull password change';
			$Status = Response::HTTP_OK;
		}

		return response()->json(['msg' => $Msg], $Status);
	}

	public function postUpdateProfile(UpdateProfileRequest $request) {

		$Msg = 'Updated your profile details successfully';
		$Status = Response::HTTP_UNPROCESSABLE_ENTITY;

		$user = User::where('id', $this->admin->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone' => $request->phone]);

		$data['reload'] = true;

		return api($Msg, $data);
	}

	public function postUpdatePhoto(UpdatePhotoRequest $request) {

		$user = \AuthHelper::getCurrentUser();

		$FileName = \ImageHelper::createFileName($request->photo);

		\ImageHelper::ImageUploadToS3($request->photo, $FileName, 'userphotos/', true, 100, 100);
		\UserHelper::updateFirstTimeUserPhoto($user->id, $FileName);

		$show['redirect'] = ['/admin/profile'];

		return api('Photo updated successfully', $show);
	}

	public function getAdminDashboardInfo(DashboardInfoRequest $request) {

		$data = \AdminDashHelper::getDashboardData($request);

		$content['stats'] = \View::make('admin::role.dashboard-data1')->with('data', $data)->render();
		$content['lists'] = \View::make('admin::role.dashboard-data2')->with('data', $data)->render();

		return response()->json(['data' => $content, 'chartData' => $data], 200);
	}

	public function getAllUsers() {

	}
}

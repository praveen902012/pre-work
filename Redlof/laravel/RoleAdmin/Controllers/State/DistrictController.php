<?php
namespace Redlof\RoleAdmin\Controllers\State;

use Exceptions\EntityAlreadyExistsException;
use Illuminate\Http\Request;
use Models\District;
use Models\StateDistrictAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;
use Redlof\RoleAdmin\Controllers\State\Requests\AddDistrictRequest;
use Redlof\RoleAdmin\Controllers\State\Requests\AddNewDistrictRequest;

class DistrictController extends RoleAdminBaseController {

	function getStateAdmins(Request $request, $state_id) {

		$stateadmin = StateAdmin::where('state_id', $state_id)
			->page($request)
			->with(['user'])
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('', $stateadmin);

	}

	function getDistricts(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->where('status', 'active')
			->page($request)
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('', $district);

	}

	function getSearchDistricts(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->where('status', 'active')
			->where('name', 'ilike', '%' . $request['s'] . '%')
			->page($request)
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('', $district);

	}

	function getDistrictsList(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->get()
			->trimTimeStamps();
		return api('', $district);

	}

	function getDistrictAdmins(Request $request, $district_id) {

		$districtadmin = StateDistrictAdmin::where('district_id', $district_id)
			->where('status', 'active')
			->page($request)
			->with(['user'])
			->orderBy('created_at', 'desc')
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('District Admin', $districtadmin);

	}

	function getDeactivatedDistrictAdmins(Request $request, $district_id) {

		$districtadmin = StateDistrictAdmin::where('district_id', $district_id)
			->where('status', 'inactive')
			->page($request)
			->with(['user'])
			->orderBy('created_at', 'desc')
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('District Admin', $districtadmin);

	}

	function getDistrictAdminsList(Request $request, $district_id) {

		$districtadmin = StateDistrictAdmin::where('status', 'active')
			->where('district_id', $district_id)
			->page($request)
			->with(['user'])
			->orderBy('created_at', 'desc')
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('District Admin', $districtadmin);

	}

	function postDistrictAdmins(AddDistrictRequest $request, UserRepo $userRepo) {

		$request['role_type'] = 'role-district-admin';

		$request->merge(['email' => strtolower($request->email)]);

		$request['password'] = rand() . \Carbon::now()->timestamp;

		$user = $userRepo->create($request);

		$newDistrictAdmin = new StateDistrictAdmin();

		$newDistrictAdmin->state_id = $request['state_id'];

		$newDistrictAdmin->district_id = $request['district_id'];

		$newDistrictAdmin->user_id = $user['id'];

		$newDistrictAdmin->save();

		$user['redirect'] = '/admin/states/districtadmin/' . $request->district_id;

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $request->email,
			'password' => $request['password'],
		);

		$subject = 'RTE Credentials!';

		\MailHelper::sendSyncMail('admin::emails.welcome-districtadmin', $subject, $user->email, $EmailData);

		return api('Created district Admin', $user);

	}

	function postAddDistrict(AddNewDistrictRequest $request) {

		$check = District::where('name', title_case($request->name))->get();

		if (count($check) > 0) {
			throw new EntityAlreadyExistsException("There already exists a district with similar name");

		}

		$addDistrict = new District();

		$addDistrict->state_id = $request->state_id;

		$addDistrict->name = $request->name;

		$addDistrict->save();

		$addDistrict['redirect'] = '/admin/states/' . $request->state_slug . '/district-admin';

		return api('New district added', $addDistrict);

	}

	function deactivateDistrict($district_id) {

		$districtUpdate = District::where('id', $district_id)->update(['status' => 'inactive']);
		$showObject = [
			'reload' => true,
		];

		return api('District is deactivated', $showObject);
	}

	function deactivateDistrictAdmin($districtadmin_id) {

		$districtUpdate = \Models\StateDistrictAdmin::where('id', $districtadmin_id)->update(['status' => 'inactive']);
		$showObject = [
			'reload' => true,
		];

		return api('District Admin is deactivated', $showObject);
	}

	function activateDistrictAdmin($districtadmin_id) {

		$districtUpdate = \Models\StateDistrictAdmin::where('id', $districtadmin_id)->update(['status' => 'active']);
		$showObject = [
			'reload' => true,
		];

		return api('District Admin is Activated', $showObject);
	}

}
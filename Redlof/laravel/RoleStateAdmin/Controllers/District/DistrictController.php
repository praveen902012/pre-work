<?php
namespace Redlof\RoleStateAdmin\Controllers\District;

use Illuminate\Http\Request;
use Models\Block;
use Models\District;
use Models\StateDistrictAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleStateAdmin\Controllers\District\Requests\AddDistrictAdminRequest;
use Redlof\RoleStateAdmin\Controllers\District\Requests\AddDistrictRequest;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class DistrictController extends RoleStateAdminBaseController {

	function getDistricts(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->where('status', 'active')
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('', $district);

	}
	function getSearchDistricts(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->search($request, ['name'])
			->where('status', 'active')
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('', $district);

	}

	function getDistrictBlocks(Request $request, $district_id) {

		$blocks = Block::where('district_id', $district_id)
			->page($request)
			->orderBy('id', 'desc')
			->get()
			->preparePage($request);

		return api('', $blocks);

	}

	function getDistrictListing(Request $request, $state_id) {

		$district = District::where('state_id', $state_id)
			->select('id', 'name')
			->where('status', 'active')
			->get();

		return api('', $district);

	}

	function postAddDistrict(AddDistrictRequest $request) {

		$check = District::where('name', title_case($request->name))->get();

		if (count($check) > 0) {
			throw new EntityAlreadyExistsException("There already exists a district with similar name");

		}

		$addDistrict = new District();

		$addDistrict->state_id = $request->state_id;

		$addDistrict->name = $request->name;

		$addDistrict->save();

		$addDistrict['reload'] = true;

		return api('New district added', $addDistrict);

	}

	function postUpdateBlockType($block_id, $new_type) {

		Block::where('id', $block_id)->update(['type' => $new_type]);

		$reloadObj['reload'] = true;

		return api('Saved successsfully', $reloadObj);

	}

	function deactivateDistrict($district_id) {

		$districtUpdate = District::where('id', $district_id)->update(['status' => 'inactive']);
		$showObject = [
			'reload' => true,
		];

		return api('District is deactivated', $showObject);
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

	function postDistrictAdmins(AddDistrictAdminRequest $request, UserRepo $userRepo) {

		$request['role_type'] = 'role-district-admin';

		$request['password'] = rand() . \Carbon::now()->timestamp;

		$request->merge(['email' => strtolower($request->email)]);

		$user = $userRepo->create($request);

		$newDistrictAdmin = new StateDistrictAdmin();

		$newDistrictAdmin->state_id = $request['state_id'];

		$newDistrictAdmin->district_id = $request['district_id'];

		$newDistrictAdmin->user_id = $user['id'];

		$newDistrictAdmin->save();

		$user['reload'] = true;

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $request->email,
			'password' => $request['password'],
		);

		$subject = 'RTE Credentials!';

		\MailHelper::sendSyncMail('admin::emails.welcome-districtadmin', $subject, $user->email, $EmailData);

		return api('Created district Admin', $user);

	}

	function deactivateDistrictAdmin($districtadmin_id) {

		$districtUpdate = \Models\StateDistrictAdmin::where('id', $districtadmin_id)->update(['status' => 'inactive']);
		$showObject = [
			'reload' => true,
		];

		return api('District Admin is deactivated', $showObject);
	}

}
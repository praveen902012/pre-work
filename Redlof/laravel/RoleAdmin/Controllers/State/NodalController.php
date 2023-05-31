<?php

namespace Redlof\RoleAdmin\Controllers\State;

use Illuminate\Http\Request;
use Models\StateNodal;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;
use Redlof\RoleAdmin\Controllers\State\Requests\AddNodalAdminRequest;

class NodalController extends RoleAdminBaseController {

	function getNodals(Request $request, $district_id) {

		$statenodal = StateNodal::where('status', 'active')
			->where('district_id', $district_id)
			->with(['user', 'state'])
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->preparePage($request);

		return api('', $statenodal);
	}

	function getSearchNodals(Request $request, $district_id) {

		$statenodal = StateNodal::where('status', 'active')
			->where('district_id', $district_id)
			->with(['user', 'state'])
			->whereIn('user_id', function ($query) use ($request) {

				$query->where('first_name', 'ilike', '%' . $request['s'] . '%')
					->select('id')
					->from(with(new \Models\User)->getTable());
			})
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->preparePage($request);

		return api('', $statenodal);
	}

	function getDeactivatedNodals(Request $request, $district_id) {

		$statenodal = StateNodal::where('status', 'inactive')
			->where('district_id', $district_id)
			->with(['user', 'state'])
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->preparePage($request);

		return api('', $statenodal);
	}

	function deactivateNodalAdmin($nodal_id) {

		$nodalUpdate = StateNodal::where('id', $nodal_id)->update(['status' => 'inactive']);

		$showObject = [
			'reload' => true,
		];

		return api('Nodal admin deactivated', $showObject);
	}

	function activateNodalAdmin($nodal_id) {

		$nodalUpdate = StateNodal::where('id', $nodal_id)->update(['status' => 'active']);

		$showObject = [
			'reload' => true,
		];

		return api('Nodal admin Activated', $showObject);
	}

	function postNodals(AddNodalAdminRequest $request, UserRepo $userRepo) {

		$nodalAdmin = new StateNodal();

		$nodalAdmin->state_id = $request->state_id;

		$nodalAdmin->district_id = $request->district_id;

		$request['role_type'] = 'role-nodal-admin';

		$request['password'] = rand() . \Carbon::now()->timestamp;

		$request->merge(['email' => strtolower($request->email)]);

		$user = $userRepo->create($request->all());

		$nodalAdmin->user_id = $user['id'];

		$nodalAdmin->save();

		$nodalAdmin['reload'] = true;

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $request->email,
			'password' => $request['password'],
		);

		$subject = 'RTE Credentials!';

		\MailHelper::sendSyncMail('admin::emails.welcome-nodaladmin', $subject, $user->email, $EmailData);

		return api('successfully added nodal admin', $nodalAdmin);

	}

	function NodalDelete($nodal_id) {

		$nodal = StateNodal::find($nodal_id)->delete();

		$redirect_nodal = route('admin.nodal.get');

		$showObject = [
			'redirect_nodal' => $redirect_nodal,
		];

		return api('Nodal deleted', $showObject);

	}

}
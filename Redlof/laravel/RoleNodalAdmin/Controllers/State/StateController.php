<?php
namespace Redlof\RoleNodalAdmin\Controllers\State;
use Illuminate\Http\Request;
use Models\Language;
use Models\State;
use Models\StateAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;
use Redlof\RoleNodalAdmin\Controllers\State\Requests\AddLanguageRequest;
use Redlof\RoleNodalAdmin\Controllers\State\Requests\AddStateAdminRequest;
use Redlof\RoleNodalAdmin\Controllers\State\Requests\UpdateStateRequest;

class StateController extends RoleNodalAdminBaseController {

	function getLanguages(Request $request) {

		$languages = Language::Select('id', 'name')
			->page($request)
			->get()
			->preparePage($request);

		return api('', $languages);
	}

	function getLanguagesList() {

		$languages = Language::Select('id', 'name')->get();

		return api('', $languages);
	}

	function postLanguagesAdd(AddLanguageRequest $request) {

		$newLanguage = Language::create($request->all());

		return api('New language ' . $newLanguage->name . ' added', $newLanguage);
	}

	function postStateAdd(UpdateStateRequest $request) {

		$request->merge(['slug' => str_slug($request['name'])]);

		$request->merge(['language_id' => $request['language']['id']]);

		if ($request->hasFile('image')) {

			$file_name = \ImageHelper::createFileName($request['image']);

			\ImageHelper::ImageUploadToS3($request['image'], $file_name, 'state/', true, 1200, 600, true);

			$request->merge(['logo' => $file_name]);
		}

		$newState = State::create($request->all());

		$show['redirect'] = '/nodaladmin/states';

		return api('Added new state', $show);
	}

	function postUpdateState(UpdateStateRequest $request) {

		$newState = State::find($request->id);

		$newState->name = $request->name;
		$newState->language_id = $request->language['id'];

		if ($request->hasFile('image')) {

			$file_name = \ImageHelper::createFileName($request['image']);
			\ImageHelper::ImageUploadToS3($request['image'], $file_name, 'state/', true, 1200, 600, true);

			$newState->logo = $file_name;
		}

		$newState->save();

		$data['redirect'] = '/nodaladmin/states';

		return api('Updated state info', $data);
	}

	function getStatesAll(Request $request) {

		$states = State::select('id', 'name', 'logo', 'language_id')
			->with(['language'])
			->page($request)
			->get()
			->preparePage($request);

		return api('', $states);
	}

	function getStates() {

		$states = State::get();

		return api('', $states);
	}

	function getStateAdminAll(Request $request) {

		$stateadmin = StateAdmin::page($request)
			->with('user', 'state')
			->get()
			->preparePage($request);

		return api('', $stateadmin);
	}

	function postAddStateAdmin(AddStateAdminRequest $request, UserRepo $userRepo) {

		$request['role_type'] = 'role-state-admin';

		$request['password'] = 'think201';

		$user = $userRepo->create($request);

		$newStateAdmin = StateAdmin::firstOrCreate(['state_id' => $request->state_id, 'user_id' => $user['id']]);

		$show = [
			'redirect' => '/nodaladmin/states',
			'toast' => 'Mapped admin to the state',

		];

		return response()->json(['show' => $show], 200);
	}

	function getUsers() {

		$users = \Models\User::get();

		return api('', $users);
	}

	function postStateDelete($state_id) {

		$state = State::find($state_id)->delete();

		return api($state->name . ' state deleted');
	}

	function UpdateStateAdmin(Request $request) {

		$stateadmin = StateAdmin::where('id', $request->id)->update(['status' => $request->status]);

		return api('State admin updated', $stateadmin);
	}

	function getDistricts($state_id, $keyword) {

		$states = \Models\District::where('state_id', $state_id)->where('name', 'ilike', '%' . $keyword . '%')->get();

		return api('', $states);
	}

	function searchBlock($district_id, $keyword) {

		$blocks = \Models\Block::where('name', 'ilike', '%' . $keyword . '%')->where('district_id', $district_id)->get();

		return api('', $blocks);
	}

	function searchLocality($block_id, $keyword) {

		$localities = \Models\Locality::where('name', 'ilike', '%' . $keyword . '%')->where('block_id', $block_id)->get();

		return api('', $localities);
	}

	function searchSubLocality($locality_id, $keyword) {

		$sublocalities = \Models\SubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('locality_id', $locality_id)->get();

		return api('', $sublocalities);
	}

	function searchSubSubLocality($sub_locality_id, $keyword) {

		$subsublocalities = \Models\SubSubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('sub_locality_id', $sub_locality_id)->get();

		return api('', $subsublocalities);

	}

}
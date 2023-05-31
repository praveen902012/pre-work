<?php
namespace Redlof\RoleStateAdmin\Controllers\State;
use Illuminate\Http\Request;
use Models\Language;
use Models\State;
use Models\StateAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;
use Redlof\RoleStateAdmin\Controllers\State\Requests\AddLanguageRequest;
use Redlof\RoleStateAdmin\Controllers\State\Requests\AddStateAdminRequest;
use Redlof\RoleStateAdmin\Controllers\State\Requests\AddSubjectRequest;
use Redlof\RoleStateAdmin\Controllers\State\Requests\UpdateStateRequest;
use Redlof\RoleStateAdmin\Controllers\State\Requests\AddDocumentRequest;

class StateController extends RoleStateAdminBaseController {

	function getLanguages(Request $request) {

		$languages = Language::Select('id', 'name')
			->page($request)
			->get()
			->preparePage($request);

		return api('Showing all languages', $languages);
	}

	function getLanguagesList() {

		$languages = Language::Select('id', 'name')->get();

		return api('Showing all languages', $languages);
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

		return api('All states', $states);
	}

	function getStates() {

		$states = State::get();

		return api('All states', $states);
	}

	function getLevels() {

		$levels = \Models\Level::select('id', 'level')
			->orderBy('id')
			->get();

		return api('', $levels);
	}

	function getSubjects(Request $request) {

		$subjects = \Models\StateSubject::where('state_id', $this->state_id)
			->with(['subject', 'level'])
			->page($request)
			->get()
			->preparePage($request);

		return api('', $subjects);
	}

	function postAddSubjects(AddSubjectRequest $request) {

		foreach ($request->subjects as $key => $sub) {

			$subject = \Models\Subject::create($sub);

			$stateSub = new \Models\StateSubject();

			$stateSub['subject_id'] = $subject->id;

			$stateSub['level_id'] = $request->level_id;

			$stateSub['stateadmin_id'] = $this->stateadmin->id;

			$stateSub['state_id'] = $this->state_id;

			$stateSub->save();

		}

		$reloadObj['reload'] = true;

		return api('Subject added sucessfully', $reloadObj);
	}

	function postDeleteSubject(Request $request, $subject_id) {

		$stateSubDelete = \Models\StateSubject::where('subject_id', $subject_id)
			->delete();

		$subDelete = \Models\Subject::where('id', $subject_id)
			->delete();

		$reloadObj['reload'] = true;

		return api('Subject deleted sucessfully', $reloadObj);
	}

	function getStateAdminAll(Request $request) {

		$stateadmin = StateAdmin::page($request)
			->with('user', 'state')
			->get()
			->preparePage($request);

		return api('Showing all State Admins', $stateadmin);
	}

	function getStateAdmins(Request $request, $state_id) {

		$stateadmin = StateAdmin::where('state_id', $state_id)
			->page($request)
			->with(['user'])
			->get()
			->trimTimeStamps()
			->preparePage($request);

		return api('State Admin', $stateadmin);

	}

	function deactivateStateAdmin($stateadmin_id) {

		$stateAdminUpdate = StateAdmin::where('id', $stateadmin_id)->update(['status' => 'inactive']);

		return api('State Admin Deactivated', $stateAdminUpdate);
	}

	function stateAdminDelete($stateadmin_id) {

		$stateadmin = StateAdmin::find($stateadmin_id)->delete();

		$redirect_stateadmin = route('stateadmin.state.state-admin');

		$showObject = [
			'redirect_stateadmin' => $redirect_stateadmin,
		];

		return api('stateadmin deleted', $showObject);

	}

	function postAddStateAdmin(AddStateAdminRequest $request, UserRepo $userRepo) {

		$request['role_type'] = 'role-state-admin';

		$request['password'] = 'think201';

		$user = $userRepo->create($request);

		$newStateAdmin = StateAdmin::firstOrCreate(['state_id' => $request->state_id, 'user_id' => $user['id']]);

		$show = [
			'redirect' => '/stateadmin/states',
			'toast' => 'Mapped admin to the state',

		];

		return response()->json(['show' => $show], 200);
	}

	function getUsers() {

		$users = \Models\User::get();

		return api('All Users', $users);
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

	function getGallery(Request $request) {
		$gallery = \Models\Gallery::where('state_id', $this->data['state_id'])
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->imagePath('gallery', 'name')
			->preparePage($request);

		return api('', $gallery);

	}

	function getFeaturedGallery(Request $request) {
		$gallery = \Models\Gallery::where('state_id', $this->data['state_id'])
			->page($request)
			->orderBy('created_at', 'desc')
			->get()
			->imagePath('gallery', 'name')
			->preparePage($request);

		return api('', $gallery);

	}

	function postAddImage(Request $request, $state_id) {

		foreach ($request['image'] as $key => $image) {

			$file_name = \ImageHelper::createFileName($image);

			\ImageHelper::ImageUploadToS3($image, $file_name, 'gallery/', true, 1200, 600, true);

			$request->merge([
				'state_id' => $state_id,
				'isfeatured' => 0,
				'name' => $file_name,
				'brief' => $file_name,

			]);

			$newImage = \Models\Gallery::create($request->all());
		}

		$showObject = [
			'reload' => true,
		];

		return api('New Images Added', $showObject);
	}

	function postSaveFeaturedImage(Request $request) {

		\Models\Gallery::whereIn('id', $request->previous_images)
			->update(['isfeatured' => false]);

		\Models\Gallery::whereIn('id', $request->selected_images)
			->update(['isfeatured' => true]);

		return api('Saved successfully');

	}

	function postAddFeaturedImage(Request $request, $state_id) {

		foreach ($request['image'] as $key => $image) {

			$file_name = \ImageHelper::createFileName($image);

			\ImageHelper::ImageUploadToS3($image, $file_name, 'gallery/', true, 1200, 600, true);

			$request->merge([
				'state_id' => $state_id,
				'isfeatured' => 1,
				'name' => $file_name,
				'brief' => $file_name,

			]);

			$newImage = \Models\Gallery::create($request->all());
		}

		$showObject = [
			'reload' => true,
		];

		return api('New Images Added', $showObject);
	}

	function postAddDocument(AddDocumentRequest $request) {
		
		$filename = null;
		$docfilename = null;

		if ($request->hasFile('image_file')) {

			$filename = upload('documents', $request->image_file);
		}

		if ($request->hasFile('doc_image_file')) {

			$docfilename = upload('document_images', $request['doc_image_file']);
		}

		$request->merge([
			'doc' => $filename,
			'doc_image' => $docfilename,
		]);

		\Models\Document::create($request->all());

		$showObject = [
			'reload' => true,
		];

		return api('New Document Added', $showObject);
	}

	function postDocumentDelete($id) {

		\Models\Document::find($id)->delete();

		$showObject = [
			'reload' => true,
		];

		return api('Successfully Deleted Document', $showObject);
	}

	function postDeleteImage($image_id) {

		$gallery = \Models\Gallery::find($image_id)->delete();

		$showObject = [
			'reload' => true,
		];

		return api('Image deleted', $showObject);

	}

	function getStateDetails($state_id) {

		$state = State::select('id', 'name', 'language_id')
			->with(['total_state_admins', 'total_district_admins', 'total_nodal_admins', 'total_schools', 'total_districts', 'total_students'])
			->find($state_id);

		return api('', $state);

	}

	function getLotteryDetails($lottery_id) {

		$application_cycle = \Models\ApplicationCycle::find($lottery_id);

		$lottery['session_year'] = $application_cycle->session_year;
		
		$lottery['cycle'] = $application_cycle->cycle;

		$lottery['total_applied_students'] = \Models\RegistrationCycle::where('application_cycle_id', $application_cycle->id)
												->where('document_verification_status', 'verified')
												->count();

		$lottery['total_allotted_students'] = \Models\RegistrationCycle::where('application_cycle_id', $application_cycle->id)
												->where('document_verification_status', 'verified')
												->where('status', '<>', 'applied')
												->count();

		return api('', $lottery);
	}

}
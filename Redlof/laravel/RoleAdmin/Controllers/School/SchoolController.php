<?php
namespace Redlof\RoleAdmin\Controllers\School;
use Illuminate\Http\Request;
use Models\School;
use Models\SchoolAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;
use Redlof\RoleAdmin\Controllers\School\Requests\AddSchoolRequest;

class SchoolController extends RoleAdminBaseController {

	public function getSchoolsAll(Request $request) {

		$schools = School::select('id', 'name')
			->page($request)
			->get()
			->preparePage($request);

		return api('', $schools);
	}

	function getSearchedSchools(Request $request) {

		$schools = School::select('id', 'name')
			->where('name', 'ilike', '%' . $request['s'] . '%')
			->page($request)
			->get()
			->preparePage($request);

		return api('', $schools);
	}

	public function postSchoolAdd(AddSchoolRequest $request, UserRepo $userRepo) {

		if ($request->hasFile('image')) {

			$file_name = \ImageHelper::createFileName($request['image']);

			\ImageHelper::ImageUploadToS3($request['image'], $file_name, 'school/', true, 1200, 600, true);

			$request->merge(['logo' => $file_name]);
		}
		$request->merge(['language_id' => 1]);
		$request->merge(['state_id' => $request['state_id']]);
		$request->merge(['district_id' => $request['district_id']]);
		$request->merge(['block_id' => $request['block_id']]);
		$request->merge(['locality_id' => $request['locality_id']]);
		$request->merge(['sub_locality_id' => $request['sub_locality_id']]);
		$request->merge(['sub_sub_locality_id' => $request['sub_sub_locality_id']]);

		$newSchool = School::create($request->all());

		$newSchoolAdmin = new SchoolAdmin();

		$newSchoolAdmin->school_id = $newSchool->id;

		$input['first_name'] = $request['name'];
		$input['last_name'] = $request['name'];
		$input['email'] = $request['admin_email'];
		// dd($input);
		$request['role_type'] = 'role-school-admin';
		$request['password'] = 'think201today';

		$user = $userRepo->create($request);

		$newSchoolAdmin->user_id = $user['id'];
		$newSchoolAdmin->save();

		return api('New school ' . $newSchool->name . ' is added');
	}

	public function postSchoolUpdate(AddSchoolRequest $request) {

		$newSchool = School::where('id', $request->id)->update(['name' => $request->name]);

		return api('School updated', $newSchool);
	}

	public function postAddSchoolAdmin(AddSchoolRequest $request, UserRepo $userRepo) {

		$newSchoolAdmin = new SchoolAdmin();

		$newSchoolAdmin->school_id = $request->school_id;
		$request['role_type'] = 'role-school-admin';
		$request['password'] = rand() . \Carbon::now()->timestamp;

		$user = $userRepo->create($request);

		$newSchoolAdmin->user_id = $user['id'];
		$newSchoolAdmin->save();

		$user['redirect'] = '/admin/states/' . $request->state_slug . '/schools';

		$EmailData = array(
			'first_name' => $user->first_name,
			'email' => $request->email,
			'password' => $request['password'],
		);

		$subject = 'RTE Credentials!';

		\MailHelper::sendSyncMail('admin::emails.welcome-schooladmin', $subject, $user->email, $EmailData);

		return api('Created School Admin', $user);
	}

	public function postSchoolDelete($school_id) {

		$school = School::find($school_id);
		$school->delete();
		$showObject = [
			'reload' => true,
		];

		return api('School is deleted.', $showObject);
	}

	public function getDistricts($state_id, $keyword) {

		$states = \Models\District::where('state_id', $state_id)->where('name', 'ilike', '%' . $keyword . '%')->get();

		return api('', $states);
	}

	public function searchBlock($district_id, $keyword) {

		$blocks = \Models\Block::where('name', 'ilike', '%' . $keyword . '%')->where('district_id', $district_id)->get();

		return api('', $blocks);
	}

	public function searchLocality($block_id, $keyword) {

		$localities = \Models\Locality::where('name', 'ilike', '%' . $keyword . '%')->where('block_id', $block_id)->get();

		return api('', $localities);
	}

	public function searchSubLocality($locality_id, $keyword) {

		$sublocalities = \Models\SubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('locality_id', $locality_id)->get();

		return api('', $sublocalities);
	}

	public function searchSubSubLocality($sub_locality_id, $keyword) {

		$subsublocalities = \Models\SubSubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('sub_locality_id', $sub_locality_id)->get();

		return api('', $subsublocalities);

	}

}
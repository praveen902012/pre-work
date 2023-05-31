<?php
namespace Redlof\RoleStateAdmin\Controllers\Role;

use Models\User;
use Illuminate\Http\Request;
//use Redlof\Auth\Classes\AuthHelper;
use Illuminate\Http\Response;
use Helpers\DashboardStudentHelper;
use Helpers\DashboardOverviewHelper;
use Illuminate\Support\Facades\Cache;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;
use Redlof\RoleStateAdmin\Controllers\Role\Requests\DashboardInfoRequest;
use Redlof\RoleStateAdmin\Controllers\Role\Requests\UpdateProfileRequest;
use Redlof\RoleStateAdmin\Controllers\Role\Requests\ChangePasswordRequest;

class RoleStateAdminController extends RoleStateAdminBaseController {
	protected $user;

	public function __construct(UserRepo $user) {
		parent::__construct();
		$this->user = $user;
	}

	public function postChangePassword(ChangePasswordRequest $request) {

		$Msg = 'This is not your old password';
		$Status = Response::HTTP_UNPROCESSABLE_ENTITY;

		$user = $this->user->changePassword($request->all());

		if ($user) {
			$Msg = 'Successfull password change';
			$Status = Response::HTTP_OK;
		}

		return api($Msg);
	}

	public function postUpdateProfile(UpdateProfileRequest $request) {

		$Msg = 'Your profile details not updated successfully';
		$Status = Response::HTTP_UNPROCESSABLE_ENTITY;

		$user = User::where('id', \AuthHelper::getCurrentUser()->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone' => $request->phone]);

		if ($user) {
			$Msg = 'Your profile details updated successfully';
			$Status = Response::HTTP_OK;
		}

		$show['reload'] = true;

		return api('Profile updated successfully', $show);
	}

	public function postUpdatePhoto(Request $request) {

		$user = \AuthHelper::getCurrentUser();

		$FileName = \ImageHelper::createFileName($request->photo);

		\ImageHelper::ImageUploadToS3($request->photo, $FileName, 'userphotos/', true, 100, 100);
		\UserHelper::updateFirstTimeUserPhoto($user->id, $FileName);

		$show['redirect'] = ['/stateadmin/profile'];

		return api('Photo updated successfully', $show);
	}

	public function getAdminInformation() {
		$User = \AuthHelper::getCurrentUser();
		return response()->json(['data' => $User], 200);
	}

	public function getAdminDashboardInfo(DashboardInfoRequest $request) {

		$data = \AdminDashHelper::getDashboardData($request);

		$content['stats'] = \View::make('admin::role.dashboard-data1')->with('data', $data)->render();
		$content['lists'] = \View::make('admin::role.dashboard-data2')->with('data', $data)->render();

		return response()->json(['data' => $content, 'chartData' => $data], 200);
	}

	function getApplicationCycleListing() {
		$applicationcycle = \Models\ApplicationCycle::select('session_year')
			->distinct('session_year')
			->orderBy('session_year', 'DESC')
			->get();

		return api('', $applicationcycle);

	}

	function getDistrictListing() {

		$district = \Models\District::select('id', 'name')
			->where('state_id', $this->state_id)
			->where('status', 'active')
			->get();

		return api('', $district);

	}

	function getNodalListing($district_id) {

		if ($district_id != "null") {

			$nodal = \Models\StateNodal::select('id', 'user_id')
				->where('state_id', $this->state_id)
				->where('status', 'active')
				->where('district_id', $district_id)
				->with('user')
				->get();

		} else {

			$nodal = \Models\StateNodal::select('id', 'user_id')
				->where('state_id', $this->state_id)
				->where('status', 'active')
				->with('user')
				->get();

		}

		return api('', $nodal);

	}

	function getSchoolListing($district_id) {

		if ($district_id != "null") {

			$schools = \Models\School::select('id', 'name')
				->where('application_status', '<>', 'applied')
				->where('district_id', $district_id)
				->get();

		} else {

			$schools = \Models\School::select('id', 'name')
				->where('application_status', '<>', 'applied')
				->where('state_id', $this->state_id)
				->get();

		}

		return api('', $schools);

	}

	function getSchoolInfo($application_cycle_year, $district_id, $nodal_id, $refresh='false') {
	  
		$state_id = $this->state_id;
		 
		$cache_key = 'rte-getschoolinfo-api';
		 
		if($refresh == 'true'){

			Cache::store('file')->forget($cache_key);

			$data = \Helpers\DashboardHelper::getSchoolInfo($state_id, $application_cycle_year, $district_id, $nodal_id);
				
			// Cache Data
			$cache_data = [];
			$cache_data['data'] = $data;
			$cache_data['created_at'] = \Carbon::now();
			
			Cache::store('file')->rememberForever($cache_key, function() use($cache_data){

				return $cache_data;
			});

			$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
			$data = $cache_data;

		}else{
			
			if (Cache::store('file')->has($cache_key)) {
			 
				$cache_data = Cache::store('file')->get($cache_key);
				
				$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
				$data = $cache_data;

			} else {
	
				$data = \Helpers\DashboardHelper::getSchoolInfo($state_id, $application_cycle_year, $district_id, $nodal_id);
				
				// Cache Data
				$cache_data = [];
				$cache_data['data'] = $data;
				$cache_data['created_at'] = \Carbon::now();
				
				Cache::store('file')->rememberForever($cache_key, function() use($cache_data){

					return $cache_data;
				});

				$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
				$data = $cache_data;
			}
		}

	 	return api('', $data);
	}

	function applyFilterStudentDetails(Request $request, $refresh='false') {

		$state_id = $this->state_id;

		$cache_key = 'rte-getstudentinfo-api';
		 
		if($refresh == 'true'){
			
			Cache::store('file')->forget($cache_key);

			$data = DashboardStudentHelper::applyStudentFilter($state_id, $request);

			// Cache Data
			$cache_data = [];
			$cache_data['data'] = $data;
			$cache_data['created_at'] = \Carbon::now();
			
			Cache::store('file')->rememberForever($cache_key, function() use($cache_data){

				return $cache_data;
			});

			$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
			$data = $cache_data;

		}else{
			
			if (Cache::store('file')->has($cache_key)) {
			 
				$cache_data = Cache::store('file')->get($cache_key);
				
				$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
				$data = $cache_data;

			} else {
	
				$data = DashboardStudentHelper::applyStudentFilter($state_id, $request);
				
				// Cache Data
				$cache_data = [];
				$cache_data['data'] = $data;
				$cache_data['created_at'] = \Carbon::now();
				
				Cache::store('file')->rememberForever($cache_key, function() use($cache_data){

					return $cache_data;
				});

				$cache_data['created_at'] = \Carbon::parse($cache_data['created_at'])->diffForHumans();
				$data = $cache_data;
			}
		}

		return api('', $data);

	}

	function applyFilterOverviewMetrics(Request $request) {

		$state_id = $this->state_id;

		$filtered_data = DashboardOverviewHelper::applyOveriewFilter($state_id, $request);

		$filtered_data['top_districts'] = DashboardOverviewHelper::getTopPerformingDistricts($state_id, $request);
		$filtered_data['top_nodals'] = DashboardOverviewHelper::getTopPerformingNodals($state_id, $request);

		return api('', $filtered_data);

	}

	function getClassListing() {

		$class = \Models\Level::select('id', 'level')
			->where('entry_point', true)
			->get();

		return api('', $class);

	}
}

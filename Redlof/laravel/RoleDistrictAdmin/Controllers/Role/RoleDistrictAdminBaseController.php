<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class RoleDistrictAdminBaseController extends Controller {

	protected $data;

	public function __construct() {

		$this->districtadmin = \AuthHelper::getCurrentUser();

		$district = \Models\StateDistrictAdmin::select('id', 'district_id', 'user_id')->where('user_id', $this->districtadmin->id)->first();

		$this->data['districtadmin_user'] = $district;

		$this->district = \Models\District::select('id', 'state_id', 'name')->find($district->district_id);

		$this->data['districtadmin'] = $this->districtadmin;

		$this->data['district'] = $this->district;

		$this->data['latest_application_cycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle();

		$this->data['all_application_cycle'] = \Helpers\ApplicationCycleHelper::getAllCycle();

		$state_districtadmin = \Models\State::select('slug')
			->find($this->district->state_id);

		$this->data['state_slug'] = $state_districtadmin->slug;

		$this->data['state_id'] = $this->district->state_id;

		$this->state_id = $this->district->state_id;

	}

}
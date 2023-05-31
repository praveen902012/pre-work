<?php
namespace Redlof\RoleStateAdmin\Controllers\District;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class DistrictViewController extends RoleStateAdminBaseController {

	public function getDistrictView() {

		$this->data['title'] = "Districts of";
		return view('stateadmin::district.districts', $this->data);
	}

	function getDistrictBriefView($district_id) {

		$district = \Models\District::with([
			'districtadmin.user'])
			->find($district_id);

		$state = \Models\State::with([
			'language',
			'stateadmin.user',
			'total_district_admins',
			'total_nodal_admins',
			'total_schools'])
			->find($district->state_id);

		$this->data['state'] = $state;

		$this->data['district'] = $district;

		return view('stateadmin::district.district-brief-view', $this->data);
	}

	function getDistrictAdminView($district_id) {

		$district = \Models\District::with([
			'districtadmin.user'])
			->find($district_id);

		$state = \Models\State::with([
			'language',
			'stateadmin.user',
			'total_district_admins',
			'total_nodal_admins',
			'total_schools'])
			->find($district->state_id);

		$this->data['state'] = $state;

		$this->data['district'] = $district;

		$this->data['title'] = 'All District Admins of ';

		return view('stateadmin::district.district-admin', $this->data);
	}

	function getDistrictBlockView($district_id) {

		$district = \Models\District::with([
			'districtadmin.user'])
			->find($district_id);

		$state = \Models\State::with([
			'language',
			'stateadmin.user',
			'total_district_admins',
			'total_nodal_admins',
			'total_schools'])
			->find($district->state_id);

		$this->data['state'] = $state;

		$this->data['district'] = $district;

		$this->data['title'] = 'All Blocks of ';

		return view('stateadmin::district.blocks', $this->data);
	}

	function getDistrictAdminBriefView($district_admin_id) {

		$district_admin = \Models\StateDistrictAdmin::with([
			'user'])
			->find($district_admin_id);

		$this->data['district_admin'] = $district_admin;

		$this->data['state'] = 'Data';

		return view('stateadmin::district.district-admin-brief-view', $this->data);
	}
}
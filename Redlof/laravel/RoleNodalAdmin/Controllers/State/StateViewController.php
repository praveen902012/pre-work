<?php
namespace Redlof\RoleNodalAdmin\Controllers\State;

use Models\State;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class StateViewController extends RoleNodalAdminBaseController {

	// State

	function getStates() {

		$this->data['title'] = 'States';

		return view('nodaladmin::state.states', $this->data);
	}

	function getStateBriefView($state_id) {

		$state = State::with([
			'language',
			'stateadmin.user',
			'total_district_admins',
			'total_nodal_admins',
			'total_schools'])
			->find($state_id);

		$this->data['state'] = $state;

		return view('nodaladmin::state.state-brief-view', $this->data);
	}

	function getStateSingleView($state) {

		$state = State::select('*')->where('slug', $state)->first();

		$this->data['state'] = $state;

		return view('nodaladmin::state.state-single-view', $this->data);
	}

	// Disctrict

	function getDistrictView($state) {

		$state = State::select('*')->where('slug', $state)->first();

		$this->data['state'] = $state;

		$this->data['title'] = 'District Administrators';

		return view('nodaladmin::state.district-admin', $this->data);
	}

	// Nodal

	function getNodalView($state) {

		$this->data['title'] = 'List of Nodal Admins';

		return view('nodaladmin::state.nodal-admin', $this->data);
	}

	// School

	function getSchoolView($state) {

		$state = State::select('id', 'name', 'slug')->where('slug', $state)->first();

		if (empty($state)) {
			throw new Exceptions\ValidationFailedException("This state is not registered with our platform yet");
		}

		$this->data['title'] = "Admin | Schools";

		$this->data['state'] = $state;

		return view('nodaladmin::school.registered-schools', $this->data);
	}

	function getSchoolSingleView($id) {

		$this->data['school'] = School::with(['schooladmin.user', 'language'])->find($id);

		return view('nodaladmin::school.viewsingleschool', $this->data);
	}

}
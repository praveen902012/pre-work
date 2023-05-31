<?php
namespace Redlof\RoleNodalAdmin\Controllers\Grievance;

use Illuminate\Http\Request;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class GrievanceController extends RoleNodalAdminBaseController {

	function __construct() {
		parent::__construct();
	}

	function getAdmissionDenied(Request $request) {

		$state_id = $this->state->id;

		$nodal_id = $this->state_nodal->id;

		$reports = \Models\DenyAdmission::with(['basic_details', 'basic_details.registration_cycle', 'basic_details.registration_cycle.school'])

			->whereHas('basic_details.registration_cycle', function ($mainquery) use ($state_id, $nodal_id) {

				$mainquery->where('application_cycle_id', function ($query) use ($state_id) {

					$query->select('id')->where('state_id', $state_id)
						->where('status', 'completed')
						->orderBy('created_at', 'desc')
						->from(with(new \Models\ApplicationCycle)->getTable());

				})
					->where('status', '<>', 'applied')
					->whereIn('allotted_school_id', function ($query) use ($nodal_id) {

						$query->select('school_id')->where('nodal_id', $nodal_id)
							->from(with(new \Models\SchoolNodal)->getTable());

					});

			})
			->page($request)
			->get()
			->preparePage($request);

		return api('', $reports);
	}

}
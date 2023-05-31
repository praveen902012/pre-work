<?php
namespace Redlof\RoleNodalAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class RoleNodalAdminBaseController extends Controller {

	protected $data;

	protected $nodaladminHelper;

	public function __construct() {

		$this->nodaladmin = \AuthHelper::getCurrentUser();
		$this->data['nodaladmin'] = $this->nodaladmin;
		$this->data['udise_requested'] = false;

		$state_nodaladmin = \Models\StateNodal::with('state', 'district')
			->where('user_id', $this->data['nodaladmin']->id)
			->first();

		if (!empty($state_nodaladmin->district)) {

			$check_nodal_request = \Models\NodalRequest::where('district_id', $state_nodaladmin->district->id)->first();

			if (!empty($check_nodal_request)) {

				$this->data['udise_requested'] = true;

			}
		}

		$this->data['latest_application_cycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle();

		$this->data['all_application_cycle'] = \Helpers\ApplicationCycleHelper::getAllCycle();

		$this->data['state_slug'] = $state_nodaladmin->state->slug;

		$this->data['state_nodal'] = $state_nodaladmin;

		$this->data['state'] = $state_nodaladmin->state;

		$this->state = $state_nodaladmin->state;
		$this->state_nodal = $state_nodaladmin;

	}

}
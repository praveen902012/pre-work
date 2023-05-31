<?php
namespace Redlof\RoleStateAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class RoleStateAdminBaseController extends Controller {

	protected $data;

	protected $adminHelper;

	public function __construct() {

		$this->stateadmin = \AuthHelper::getCurrentUser();

		$this->data['stateadmin'] = $this->stateadmin;

		$state_stateadmin = \Models\StateAdmin::with('state')
			->where('user_id', $this->data['stateadmin']->id)
			->first();

		$this->state_id = $state_stateadmin->state->id;

		$this->state = $state_stateadmin->state;

		$this->data['state_slug'] = $state_stateadmin->state->slug;

		$this->data['state_id'] = $state_stateadmin->state->id;

		$this->data['state'] = $state_stateadmin->state;

		$this->data['latest_application_cycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle();

		$this->data['all_application_cycle'] = \Helpers\ApplicationCycleHelper::getAllCycle();

	}

	protected function checkAccess() {

		return true;
	}

}
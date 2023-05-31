<?php
namespace Redlof\RoleAdmin\Controllers\State;

use Models\State;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;

class StateBaseController extends RoleAdminBaseController {

	protected $state;
	protected $data;

	public function __construct() {

		parent::__construct();

		$parameters = \Route::current()->parameters();

		if (isset($parameters['state'])) {

			$this->state = State::select('id', 'name', 'slug', 'logo')->where('slug', $parameters['state'])->first();

			// if the sate is not found - redirect to the State not resgitered page

			if (empty($this->state)) {
				// TODO: Create an exception & throw the same

				abort(404);
			}

			$this->data['state'] = $this->state;
		}
	}

}
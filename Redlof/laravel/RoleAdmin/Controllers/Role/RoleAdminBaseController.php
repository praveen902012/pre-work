<?php
namespace Redlof\RoleAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class RoleAdminBaseController extends Controller {

	protected $data;

	public function __construct() {

		$this->admin = \AuthHelper::getCurrentUser();

		// dd($this->admin);

		$this->data['admin'] = $this->admin;

	}

}
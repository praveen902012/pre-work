<?php
namespace Redlof\RoleNodalAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('nodaladmin::includes.index');
	}

	public function getPage($slug) {
		return response()->view('nodaladmin::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('nodaladmin::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('nodaladmin::includes.' . $slug);
	}

}

<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('schooladmin::includes.index');
	}

	public function getPage($slug) {
		return response()->view('schooladmin::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('schooladmin::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('schooladmin::includes.' . $slug);
	}

}

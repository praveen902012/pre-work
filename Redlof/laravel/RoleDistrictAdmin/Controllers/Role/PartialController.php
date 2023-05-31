<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('districtadmin::includes.index');
	}

	public function getPage($slug) {
		return response()->view('districtadmin::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('districtadmin::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('districtadmin::includes.' . $slug);
	}

}

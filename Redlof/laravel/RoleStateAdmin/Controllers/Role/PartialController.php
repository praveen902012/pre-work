<?php
namespace Redlof\RoleStateAdmin\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('stateadmin::includes.index');
	}

	public function getPage($slug) {
		return response()->view('stateadmin::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('stateadmin::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('stateadmin::includes.' . $slug);
	}

}

<?php
namespace Redlof\State\Controllers\Role;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('state::includes.index');
	}

	public function getPage($slug) {
		return response()->view('state::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('state::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('state::includes.' . $slug);
	}

}
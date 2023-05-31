<?php
namespace Redlof\RoleAdmin\Controllers\Role;

use Illuminate\Http\Request;
use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function index() {
		return view('admin::includes.index');
	}

	public function getPage($slug) {
		return response()->view('admin::' . $slug);
	}

	public function getPopup($slug) {
		return response()->view('admin::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('admin::includes.' . $slug);
	}

	public function getDynamicContent($name, Request $request) {

		$this->data['request'] = $request->all();
		return response()->view('admin::' . $name, $this->data);
	}

}

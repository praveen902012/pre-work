<?php
namespace Redlof\Page\Controllers;

use Redlof\Core\Controllers\Controller;

class PartialController extends Controller {
	public function __construct() {
	}

	public function getPage($slug) {
		return response()->view('page::' . $slug);
	}

	public function getInclude($slug) {
		return response()->view('page::includes.' . $slug);
	}

	public function getPopups($name) {
		return response()->view('page::' . $name);
	}

}
<?php
namespace Redlof\Page\Controllers;
use Redlof\Core\Controllers\Controller;

class SchoolController extends Controller {

	public function __construct() {
	}

	public function AddSchoolView() {

		$Data['title'] = 'Schools';
		return view('page::practice.add-schools', $Data);
	}

	// public function getStatesView() {

	// 	$language = Language::select('id', 'name')->limit(2)->get();
	// 	$Data['language'] = $language;

	// 	// $Data['title'] = 'List of States';
	// 	return view('page::practice.view-states', $Data);
	// }

}
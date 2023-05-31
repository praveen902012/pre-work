<?php
namespace Redlof\RoleNodalAdmin\Controllers\DataRepo;

use Illuminate\Http\Request;
use Models\Language;
use Redlof\RoleNodalAdmin\Controllers\DataRepo\Requests\AddLanguageRequest;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class DataRepoController extends RoleNodalAdminBaseController {

	function getLanguages(Request $request) {

		$languages = Language::Select('id', 'name')
			->page($request)
			->get()
			->preparePage($request);

		return api('', $languages);
	}

	function getLanguagesList() {

		$languages = Language::Select('id', 'name')->get();

		return api('', $languages);
	}

	function postLanguagesAdd(AddLanguageRequest $request) {

		$newLanguage = Language::create($request->all());

		return api('New language ' . $newLanguage->name . ' added', $newLanguage);
	}

}
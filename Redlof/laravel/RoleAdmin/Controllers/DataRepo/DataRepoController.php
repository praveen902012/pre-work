<?php
namespace Redlof\RoleAdmin\Controllers\DataRepo;

use Illuminate\Http\Request;
use Models\Language;
use Redlof\RoleAdmin\Controllers\DataRepo\Requests\AddLanguageRequest;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;

class DataRepoController extends RoleAdminBaseController {

	function getLanguages(Request $request) {

		$languages = Language::Select('id', 'name')
			->page($request)
			->get()
			->preparePage($request);

		return api('', $languages);
	}

	function getSearchedLanguages(Request $request) {

		$languages = Language::select('id', 'name')
			->where('name', 'ilike', '%' . $request['s'] . '%')
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

		$redirect_state = route('admin.language.all');

		$showObject = [
			'reload' => true,
		];

		return api('New Language Added', $showObject);
	}

}
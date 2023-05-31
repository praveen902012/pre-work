<?php
namespace Redlof\RoleAdmin\Controllers\DataRepo;

use Models\Language;
use Redlof\RoleAdmin\Controllers\Role\RoleAdminBaseController;

class DataRepoViewController extends RoleAdminBaseController {

	function Languageall() {

		$this->data['title'] = 'List of languages';

		$this->data['language'] = Language::select('id', 'name')->get();

		return view('admin::datarepo.languagelist', $this->data);
	}

}
<?php
namespace Redlof\RoleStateAdmin\Controllers\DataRepo;

use Models\Language;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class DataRepoViewController extends RoleStateAdminBaseController {

	function Languageall() {

		$this->data['title'] = 'List of languages';

		$this->data['language'] = Language::select('id', 'name')->get();

		return view('stateadmin::datarepo.languagelist', $this->data);
	}

}
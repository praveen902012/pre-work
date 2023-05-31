<?php
namespace Redlof\RoleNodalAdmin\Controllers\DataRepo;

use Models\Language;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class DataRepoViewController extends RoleNodalAdminBaseController {

	function Languageall() {

		$this->data['title'] = 'List of languages';

		$this->data['language'] = Language::select('id', 'name')->get();

		return view('nodaladmin::datarepo.languagelist', $this->data);
	}

}
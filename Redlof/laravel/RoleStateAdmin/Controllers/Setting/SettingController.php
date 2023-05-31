<?php
namespace Redlof\RoleStateAdmin\Controllers\Setting;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class SettingController extends RoleStateAdminBaseController {

	public function getsettingView() {

		return view('stateadmin::setting.setting', $this->data);
	}


}
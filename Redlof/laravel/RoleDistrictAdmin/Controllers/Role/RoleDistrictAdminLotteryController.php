<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class RoleDistrictAdminLotteryController extends RoleDistrictAdminBaseController {

	public function getLotteryView() {

		return view('districtadmin::lottery.lottery', $this->data);
	}

}
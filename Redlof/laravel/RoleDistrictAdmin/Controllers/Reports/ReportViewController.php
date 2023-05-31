<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Reports;

use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class ReportViewController extends RoleDistrictAdminBaseController
{

    public function getReportsView()
    {
        $this->data['title'] = 'Reports';

        return view('districtadmin::reports.reports', $this->data);
    }

}

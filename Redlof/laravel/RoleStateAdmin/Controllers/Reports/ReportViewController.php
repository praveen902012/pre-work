<?php
namespace Redlof\RoleStateAdmin\Controllers\Reports;

use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class ReportViewController extends RoleStateAdminBaseController
{

    public function getReportsView()
    {
        return view('stateadmin::reports.reports', $this->data);
    }

}

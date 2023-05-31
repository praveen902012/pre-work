<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Role;

use Exceptions\UnAuthorizedException;
use Redlof\Core\Controllers\Controller;

class RoleSchoolAdminBaseController extends Controller
{

    protected $data;

    protected $schooladminHelper;

    public function __construct()
    {

        $this->data['has_current_cycle'] = true;

        $this->schooladmin = \AuthHelper::getCurrentUser();

        $this->data['schooladmin'] = $this->schooladmin;

        $schooladmin = \Models\SchoolAdmin::with('school')
            ->where('user_id', $this->data['schooladmin']->id)
            ->first();

        $this->adminschool = $schooladmin;

        $this->school = \Models\School::find($schooladmin->school->id);
        $this->data['school'] = $this->school;

        $state_schooladmin = \Models\School::with('state')->find($schooladmin->school->id);

        if (!$state_schooladmin['state']) {
            throw new UnAuthorizedException("You seem to have skipped registration steps");
        }

        $this->data['latest_application_cycle'] = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $this->data['all_application_cycle'] = \Helpers\ApplicationCycleHelper::getAllCycle();

        $this->data['state_slug'] = $state_schooladmin->state->slug;

        $this->data['state'] = $state_schooladmin->state;

        $today = \Carbon::now();

        $school_registration_on = false;

        $school_registration_check = \Models\ApplicationCycle::select('id', 'cycle')
            ->where('status', 'new')
            ->where('is_latest', true)
            ->whereDate('reg_start_date', '<=', $today)
            ->whereDate('reg_end_date', '>=', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (count($school_registration_check) > 0) {
            $school_registration_on = true;
        }

        // Check if the school have entry for current cycle
        $cycleCheck = \Models\SchoolCycle::where('school_id', $this->school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']->id)->first();

        if (empty($cycleCheck)) {

            // Migrate to new cycle
            $this->data['has_current_cycle'] = false;
        }

        $this->data['school_registration_on'] = $school_registration_on;

    }

    protected function checkAccess()
    {
        return true;
    }
}

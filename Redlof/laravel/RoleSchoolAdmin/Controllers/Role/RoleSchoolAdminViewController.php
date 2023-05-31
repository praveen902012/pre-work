<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Role;

use Redlof\RoleSchoolAdmin\Controllers\Role\RoleSchoolAdminBaseController;

class RoleSchoolAdminViewController extends RoleSchoolAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDashboardView()
    {

        $this->data['title'] = "Dashboard";

        // $check = \Models\SchoolLevelInfo::where('school_id', $this->school->id)
        //     ->count();

        // if ($check == 0) {

        //     return view('schooladmin::role.unverified-dashboard', $this->data);

        // } else {

        //     $check = \Models\SchoolLevelInfo::select('id')
        //         ->where('school_id', $this->school->id)
        //         ->whereIn('level_id', $this->school->levels)
        //         ->whereNull('total_seats')
        //         ->get();

        //     $this->data['seat_filled'] = FALSE;

        //     if (count($check) == 0) {
        //         $this->data['seat_filled'] = true;
        //     }

        // $now = \Carbon::now();
        // $current_cycle = $now->year;

        $this->data['current_cycle'] = $this->data['latest_application_cycle']->session_year;

        $this->data['school_cycle'] = \Models\SchoolCycle::where('school_id', $this->school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->first();

        return view('schooladmin::role.dashboard', $this->data);
    }

    public function getProfileView()
    {
        $this->data['title'] = "Profile";
        return view('schooladmin::role.profile', $this->data);
    }

    public function getChangePasswordView()
    {
        $this->data['title'] = "Change Password";
        return view('schooladmin::role.change-password', $this->data);
    }

    public function getMembersView()
    {
        $this->data['title'] = "Members";
        return view('schooladmin::usermanagement.members', $this->data);
    }

    public function getProfileUpdateView()
    {
        $this->data['title'] = "Update Profile";
        return view('schooladmin::role.update-profile', $this->data);
    }

    public function getProfileUpdatePhotoView()
    {
        $this->data['title'] = "Photo";
        return view('schooladmin::role.update-photo', $this->data);
    }

    public function getRegisterYourSchool()
    {

        $this->data['title'] = "School Registration";

        return view('schooladmin::school.register-your-school', $this->data);
    }

    public function getReimbursementView()
    {

        if ($this->school->application_status == 'verified') {

            $reimburse = \Models\SchoolReimbursement::where('school_id', $this->school->id)
                ->first();

            $this->data['reimburse'] = $reimburse;

            $this->data['title'] = "Reimbursement";

            return view('schooladmin::school.reimbursement', $this->data);

        } else {

            $this->data['title'] = "Dashboard";
            return view('schooladmin::role.dashboard', $this->data);

        }
    }

    public function getResetView()
    {

        $this->data['title'] = "Dashboard";
        return view('schooladmin::school.help', $this->data);

    }

    public function getAddFeeStructureView()
    {

        $this->data['title'] = "Fee Structure";

        $check = \Models\SchoolLevelInfo::where('school_id', $this->school->id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->get();

        $this->data['add_fee'] = true;

        if (count($check) == 0) {
            $this->data['add_fee'] = false;
        }

        return view('schooladmin::school.add-fee-structure', $this->data);
    }

    public function getAddSeatStructureView()
    {
        $this->data['title'] = "Seat information";

        $check = \Models\SchoolLevelInfo::select('id')
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('school_id', $this->school->id)
            ->whereIn('level_id', $this->school->levels)
            ->whereNull('total_seats')
            ->get();

        $this->data['seat_filled'] = false;

        if (count($check) == 0) {
            $this->data['seat_filled'] = true;
        }

        return view('schooladmin::school.add-seat-information', $this->data);
    }

    public function getEditSchoolView()
    {
        $this->data['title'] = "Edit School Details";

        // if (!$this->data['school_registration_on']) {

        //     throw new EntityNotFoundException("School registration is closed, You are not eligible to modify details now.!");
        // }

        // $this->school->application_status = 'registered';

        // $this->school->save();

        // Update the school cycle status

        \Models\SchoolCycle::where('school_id', $this->school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => $this->school->application_status]);

        return view('schooladmin::school.edit-school', $this->data);
    }

    public function getUpdateAddressView($udise)
    {

        if ($this->school->application_status != 'verified') {

            $this->data['title'] = "Edit Address Details";

            $this->data['udise'] = $udise;

            return view('schooladmin::school.update-address', $this->data);

        } else {

            $this->data['title'] = "Dashboard";
            return view('schooladmin::role.dashboard', $this->data);

        }

    }

    public function getUpdateRegionView($udise)
    {

        if ($this->school->application_status != 'verified') {

            $this->data['title'] = "Edit Region Selection";

            $this->data['udise'] = $udise;

            return view('schooladmin::school.update-region', $this->data);

        } else {

            $this->data['title'] = "Dashboard";
            return view('schooladmin::role.dashboard', $this->data);

        }

    }

    public function getUpdateFeeView($udise)
    {
        $year = $this->data['latest_application_cycle']['session_year'];

        $this->data['year'] = $year;

        if ($this->school->application_status != 'verified') {

            $this->data['title'] = "Edit Fee Details";

            $this->data['udise'] = $udise;

            return view('schooladmin::school.update-fee', $this->data);

        } else {

            $this->data['title'] = "Dashboard";

            return view('schooladmin::role.dashboard', $this->data);
        }

    }

    public function getUpdateBankView($udise)
    {

        if ($this->school->application_status != 'verified') {

            $this->data['title'] = "Edit Bank Details";

            $this->data['udise'] = $udise;

            return view('schooladmin::school.update-bank', $this->data);
        } else {

            $this->data['title'] = "Dashboard";
            return view('schooladmin::role.dashboard', $this->data);

        }

    }

    public function getProfilePrimaryView()
    {

        $this->data['title'] = "School Primary Details";

        return view('schooladmin::school.profile-primary', $this->data);

    }

    public function getProfileAddressView()
    {

        $this->data['title'] = "School Address Details";

        $this->data['udise'] = $this->school->udise;

        return view('schooladmin::school.profile-address', $this->data);

    }

    public function getProfileRegionView()
    {

        $this->data['title'] = "School Region Details";

        $this->data['udise'] = $this->school->udise;

        return view('schooladmin::school.profile-region', $this->data);

    }

    public function getProfileFeeView()
    {
        $year = $this->data['latest_application_cycle']['session_year'];

        $this->data['year'] = $year;

        $this->data['title'] = "School Fee Details";

        $this->data['udise'] = $this->school->udise;

        return view('schooladmin::school.profile-fee', $this->data);
    }

    public function getProfileBankView()
    {

        $this->data['title'] = "School Bank Details";

        $this->data['udise'] = $this->school->udise;

        return view('schooladmin::school.profile-bank', $this->data);

    }

}

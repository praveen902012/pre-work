<?php
namespace Redlof\RoleStateAdmin\Controllers\Role;

use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminViewController extends RoleStateAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDashboardView()
    {
        $this->data['title'] = "Dashboard";

        $this->data['current_cycle'] = $this->data['latest_application_cycle']->session_year;

        return view('stateadmin::role.dashboard', $this->data);
    }

    public function getProfileView()
    {
        $this->data['title'] = "Profile";
        return view('stateadmin::role.profile', $this->data);
    }

    public function getProfileUpdateView()
    {
        $this->data['title'] = "Update Profile";
        return view('stateadmin::role.update-profile', $this->data);
    }

    public function getProfileUpdatePhotoView()
    {
        $this->data['title'] = "Photo";
        return view('stateadmin::role.update-photo', $this->data);
    }

    public function getChangePasswordView()
    {
        $this->data['title'] = "Change Password";
        return view('stateadmin::role.change-password', $this->data);
    }

    public function getAllSchoolView()
    {
        $this->data['title'] = "Schools";
        return view('stateadmin::school.schools-all', $this->data);
    }

    public function getNodalView()
    {
        $this->data['title'] = "All Nodal Admins";
        return view('stateadmin::nodal.nodal-admin', $this->data);
    }

    public function getDeactivatedNodalView($state_id)
    {

        $district = \Models\District::with([
            'districtadmin.user'])
            ->find($state_id);

        $state = \Models\State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($state_id);

        $this->data['state'] = $state;

        $this->data['district'] = $district;

        $this->data['title'] = 'List of Nodal Admins';

        return view('stateadmin::nodal.deactivated-nodal-admin', $this->data);
    }

    public function getAssignBlockNodalAdminView()
    {

        $districts = \Models\District::all();

        $this->data['districts'] = $districts;

        $this->data['title'] = 'Assign Blocks to Nodal Admins';

        return view('stateadmin::nodal.assign-block-to-nodal-admin', $this->data);
    }

    public function getManageStudentsView()
    {

        $this->data['title'] = 'Manage Students';

        return view('stateadmin::student.manage-students', $this->data);
    }

    public function getNodalAdminBriefView($nodal_admin_id)
    {

        $nodal_admin = \Models\StateNodal::with([
            'user'])
            ->find($nodal_admin_id);

        $this->data['nodal_admin'] = $nodal_admin;

        $this->data['state'] = 'Data';

        return view('stateadmin::nodal.nodal-admin-brief-view', $this->data);
    }

    public function getDocumentsView()
    {

        $this->data['title'] = "Documents";

        $documents = \Models\Document::all();

        $this->data['documents'] = $documents;

        return view('stateadmin::documents.documentview', $this->data);

    }

    // function getDocumentUpdatePopup($id) {

    //     $this->data['title'] = "Document update";

    //     $document = \Models\Document::find($id);

    //     $this->data['document'] = $document;

    //     return view('stateadmin::documents.popup.documentedit', $this->data);

    // }

}

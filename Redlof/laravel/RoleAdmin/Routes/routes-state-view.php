<?php

// View Routes

Route::group([
    'middleware' => ['role:role-admin', 'web'],
    'prefix' => 'admin',
    'namespace' => 'State'],
    function () {

        $c = 'StateViewController@';

        // STATE

        Route::get('states', ['as' => 'admin.state.get', 'uses' => $c . 'getStates']);

        Route::get('states/brief/{state_id}', ['as' => 'admin.state.brief', 'uses' => $c . 'getStateBriefView'])
            ->where('state_id', '[0-9]+');

        Route::get('stateadmin/brief/{state_admin_id}', ['as' => 'admin.stateadmin.brief', 'uses' => $c . 'getStateAdminBriefView'])
            ->where('state_admin_id', '[0-9]+');

        Route::get('district/brief/{district_id}', ['as' => 'admin.district.brief', 'uses' => $c . 'getDistrictBriefView'])
            ->where('district_admin_id', '[0-9]+');

        Route::get('districtadmin/brief/{district_admin_id}', ['as' => 'admin.districtadmin.brief', 'uses' => $c . 'getDistrictAdminBriefView'])
            ->where('district_admin_id', '[0-9]+');

        Route::get('deactivated-districtadmin/brief/{district_admin_id}', ['as' => 'admin.districtadmin.brief', 'uses' => $c . 'getDeactivatedDistrictAdminBriefView'])
            ->where('district_admin_id', '[0-9]+');

        Route::get('nodaladmin/brief/{nodal_admin_id}', ['as' => 'admin.nodaladmin.brief', 'uses' => $c . 'getNodalAdminBriefView'])
            ->where('nodal_admin_id', '[0-9]+');

        Route::get('school/brief/{school_id}', ['as' => 'admin.school.brief', 'uses' => $c . 'getSchoolBriefView'])
            ->where('school_id', '[0-9]+');

        Route::get('states/{state}', ['as' => 'admin.state.single', 'uses' => $c . 'getStateSingleView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/stateadmins', ['as' => 'admin.state.state-admin', 'uses' => $c . 'getStateAdminView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/deactivated-stateadmins', ['as' => 'admin.state.deactivated-state-admin', 'uses' => $c . 'getDeactivatedStateAdminView'])
            ->where('state', '[a-z\-]+');

        // DISTRICT

        Route::get('states/districtadmin/{district_id}', ['as' => 'admin.role.district-admin', 'uses' => $c . 'getDistrictAdminView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/districtadmin/{district_id}/deactivated-district-admins', ['as' => 'admin.role.deactivated-district-admin', 'uses' => $c . 'getDeactivatedDistrictAdminView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/district-admin', ['as' => 'admin.single.district-admin', 'uses' => $c . 'getDistrictView'])->where('state', '[a-z\-]+');;

        // NODAL

        Route::get('states/{district_id}/nodal-admins', ['as' => 'admin.nodal.nodal-admin', 'uses' => $c . 'getNodalView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{district_id}/deactivated-nodal-admins', ['as' => 'admin.nodal.deactivated-nodal-admin', 'uses' => $c . 'getDeactivatedNodalView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/all-districts-nodal', ['as' => 'admin.nodal.nodal-admin-districts', 'uses' => $c . 'getDistrictNodalView'])
            ->where('state', '[a-z\-]+');

        // SCHOOL

        Route::get('states/{state}/schools', ['as' => 'admin.school.get', 'uses' => $c . 'getSchoolView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/school/add', ['as' => 'admin.school.add', 'uses' => $c . 'getSchoolAddView'])
            ->where('state', '[a-z\-]+');

        Route::get('school/{id}', ['as' => 'admin.school.single', 'uses' => $c . 'getSchoolSingleView']);

        //STUDENT

        Route::get('states/{state}/alloted-students', ['as' => 'admin.students.allotted', 'uses' => $c . 'getAllottedStudentView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/enrolled-students', ['as' => 'admin.students.enrolled', 'uses' => $c . 'getEnrolledStudentView'])
            ->where('state', '[a-z\-]+');

        Route::get('states/{state}/rejected-students', ['as' => 'admin.students.rejected', 'uses' => $c . 'getRejectedStudentView'])
            ->where('state', '[a-z\-]+');

        //Other Views which are not visible directly to admin

        Route::get('manage-districts', ['as' => 'admin.manage.districts', 'uses' => $c . 'getAddLocalitiesView']);

        Route::get('downloads', ['as' => 'admin.downloads', 'uses' => $c . 'getDownloadsView']);

        Route::get('add-blocks', ['as' => 'admin.add.blocks', 'uses' => $c . 'getAddBlocksView']);

        Route::get('think201/management', ['as' => 'admin.think201.management', 'uses' => $c . 'getManagementView']);

    });
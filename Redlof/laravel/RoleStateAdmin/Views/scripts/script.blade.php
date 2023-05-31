@extends('stateadmin::includes.layout')
@section('content')

<section class="admin_dash" ng-controller="AppController" ng-cloak>

    <div class="container-fluid" ng-init="formData={}">

        <hr>
        <h2>
            School Sections
        </h2>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">School having atleast one duplicate level</div>
                    <div class="panel-body">

                        <button class="btn btn-primary" ng-click="getAPIData('stateadmin/remove/duplicate/school/level/entries', 'duplicateSchoolIds')">Get Schools</button>

                        <button ng-if="duplicateSchoolIds.length>0" class="btn btn-danger" ng-click="getAPIData('stateadmin/remove/duplicate/school/level/entries/true', 'duplicateSchoolIds')">Remove duplicate entries</button>

                        <br>

                        <p ng-if="duplicateSchoolIds.length>0" style="margin-top: 30px;">School IDS ([[duplicateSchoolIds.length]]):</p>

                        <div ng-if="duplicateSchoolIds.length>0" style="width: 100%; max-height: 223px;overflow-y: scroll;">
                            <div ng-repeat="item in duplicateSchoolIds">[[item]],</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Map nodal to school from udise_nodal table</div>
                    <div class="panel-body">
                        <button ng-disabled="inProcess" class="btn-theme" ng-click="create('stateadmin/map/school/to/nodal', {})">
                            <span ng-if="!inProcess">Map</span>
                            <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>

             <!-- <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Map schools statu to school cycles status</div>
                    <div class="panel-body">
                        <button ng-disabled="inProcess" class="btn-theme" ng-click="create('stateadmin/map/school/cycles-status', {})">
                            <span ng-if="!inProcess">Update Status</span>
                            <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div> -->


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Update school status from cycle</div>
                    <div class="panel-body">
                        <button ng-disabled="inProcess" class="btn-theme" ng-click="create('stateadmin/script/school-status-update', {})">
                            <span ng-if="!inProcess">Update Status</span>
                            <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="panel panel-default" ng-init="status=['registered', 'verified']">
                    <div class="panel-heading">Schools(registered/verified) not having entries in school_cycles for latest application cycle </div>
                    <div class="panel-body">
                        <label>Select School status</label>
                        <ui-select class="custom_ui_select" ng-model="formData.application_status" theme="select2">
                            <ui-select-match>
                            [[$select.selected]]
                            </ui-select-match>

                            <ui-select-choices repeat="item in status | filter: $select.search | orderBy: 'name' ">
                            [[item]]
                            </ui-select-choices>
                        </ui-select>

                        <button ng-if="formData.application_status" class="btn btn-danger" style="margin-top: 5px" ng-click="getAPIData('stateadmin/schools/not-registered-in/school_cycles/for-latest-app-cyc/'+[[formData.application_status]], 'schools')">Get Schools</button>

                        <br>

                        <p ng-if="schools.length>0" style="margin-top: 30px;">Schools ([[schools.length]]):</p>

                        <div ng-if="schools.length>0" style="width: 100%; max-height: 223px;overflow-y: scroll;">
                            <button ng-disabled="inProcess" class="btn btn-danger" style="margin-top: 5px" ng-really-action="Migrate" ng-really-message="Do you want to Migrate?" ng-really-click="create('stateadmin/migrate/schools/new-cycle/[[formData.application_status]]', {})">
                                <span ng-if="!inProcess">Migrate [[formData.application_status]] Schools to New cycle</span>
                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button>

                            <div ng-repeat="item in schools">
                                <p><b>Udise:-</b>[[item.udise]] <b>Id:-</b>[[item.id]]</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Update School phone number and available seats</div>
                    <div class="panel-body">
                        <label>Enter UDISE</label>

						<input validator="required" valid-method="blur" ng-model="formData.udise" type="text" class="form-control" id="udise" placeholder="Enter udise" >

                        <button ng-if="formData.udise" class="btn btn-primary" style="margin-top: 5px" ng-click="getAPIData('stateadmin/get-school/'+[[formData.udise]], 'schoolData')">Get School</button>

                        <br>

                        <div ng-if="schoolData" style="margin-top: 4px; width: 100%">
                            <p style="margin-top: 4px;"><b>UDISE:</b>[[schoolData.udise]]</p>
                            <p style="margin-top: 4px;"><b>Name:</b> [[schoolData.name]]</p>
                            <p style="margin-top: 4px;"><b>School Phone:</b>[[schoolData.phone]]</p>
                            <p style="margin-top: 4px;"><b>Admin Phone:</b>[[schoolData.schooladmin.user.phone]]</p>

                            <div class="row" style="margin-top: 24px; margin-bottom: 14px" >

                                <div class="col-md-10" style="margin-bottom: 10px">
                                    <label>Enter Phone number</label>
                                    <input validator="required" valid-method="blur" ng-model="schoolData.phone" type="text" class="form-control" id="udise" placeholder="Enter phone" >
                                </div>

                                <div class="col-md-12" ng-repeat="e_levels in schoolData.entry_levels">
                                    <label>Entry Class: [[e_levels.level_info.level]]</label>

                                    <input style="margin-bottom: 10px" type="text" validator="required" valid-method="blur" ng-model="e_levels.total_seats" ng-change="e_levels.available_seats = (0.25 * e_levels.total_seats).toFixed(0)" class="form-control" id="total_seats" >

                                    <input disabled type="text" validator="required" valid-method="blur" ng-model="e_levels.available_seats" class="form-control" id="available_seats" >
                                </div>

                                <div class="col-md-8">
                                    <button ng-disabled="inProcess" class="btn btn-primary" style="margin-top: 5px" ng-click="create('stateadmin/script/school-admin/update', schoolData)">
                                        <span ng-if="!inProcess">Update</span>
                                        <span ng-if="inProcess">Please wait <i class="fa fa-spinner fa-spin"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div ng-if="!schoolData">
                            No School
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10" ng-init="schoolDetailData={}">
                <div class="panel panel-default" style="font-size: 14px;">
                    <div class="panel-heading">School Internal Data</div>
                    <div class="panel-body" ng-controller="DownloadReportController as Download">
                        <div class="row">
                            <div class="col-md-8">
        						<input validator="required" valid-method="blur" ng-model="schoolDetailData.udise" type="text" class="form-control" id="udise" placeholder="Enter udise" >
                            </div>

                            <div class="col-md-4">
                                <button ng-disabled="!schoolDetailData.udise" class="btn btn-primary" ng-click="getAPIData('stateadmin/get-complete-school/'+[[schoolDetailData.udise]], 'schoolDetails')">Get complete school details</button>
                            </div>
                        </div>

                        <hr>

                        <div class="row" ng-if="schoolDetails">
                            <div class="col-md-5">
                                <h3 style="margin-bottom: 16px;text-decoration: underline;">School Details</h3>
                                <p><b class="text-muted">UDISE : </b> [[schoolDetails.school.udise]]</p>
                                <p><b class="text-muted">Name : </b> [[schoolDetails.school.name]]</p>
                                <p><b class="text-muted">school_id : </b> [[schoolDetails.school.id]]</p>
                                <p><b class="text-muted">school phone : </b> [[schoolDetails.school.phone]]</p>
                                <p><b class="text-muted">application_status : </b> [[schoolDetails.school.application_status]]</p>
                                <p><b class="text-muted">created_at : </b> [[schoolDetails.school.created_at]]</p>
                                <p><b class="text-muted">updated_at : </b> [[schoolDetails.school.updated_at]]</p>

                                <hr>

                                <h3 style="margin-bottom: 16px;text-decoration: underline;">School Admin</h3>
                                <p><b class="text-muted">User Name : </b> [[schoolDetails.school.schooladmin.user.first_name]]</p>
                                <p><b class="text-muted">user_id : </b> [[schoolDetails.school.schooladmin.user.id]]</p>
                                <p><b class="text-muted">phone : </b> [[schoolDetails.school.schooladmin.user.phone]]</p>
                                <p><b class="text-muted">email : </b> [[schoolDetails.school.schooladmin.user.email]]</p>

                                <hr>

                                <h3 style="margin-bottom: 16px;text-decoration: underline;">District Admin</h3>
                                <p><b class="text-muted">District : </b> [[schoolDetails.school.district.name]]</p>
                                <p><b class="text-muted">User Name : </b> [[schoolDetails.school_district_admin.user.first_name]]</p>
                                <p><b class="text-muted">user_id : </b> [[schoolDetails.school_district_admin.user.id]]</p>
                                <p><b class="text-muted">phone : </b> [[schoolDetails.school_district_admin.user.phone]]</p>
                                <p><b class="text-muted">email : </b> [[schoolDetails.school_district_admin.user.email]]</p>

                                <hr>

                                <h3 style="margin-bottom: 16px;text-decoration: underline;">Nodal Admin</h3>
                                <p><b class="text-muted">is school mapped from udise_nodal : </b> <span ng-if="udise_nodal">Yes</span> <span ng-if="!udise_nodal">No</span></p>
                                <p><b class="text-muted">school_nodal_id : </b> [[schoolDetails.school_nodal.id]]</p>
                                <p><b class="text-muted">User Name : </b> [[schoolDetails.school_nodal.nodaladmin.user.first_name]]</p>
                                <p><b class="text-muted">user_id : </b> [[schoolDetails.school_nodal.nodaladmin.user.id]]</p>
                                <p><b class="text-muted">phone : </b> [[schoolDetails.school_nodal.nodaladmin.user.phone]]</p>
                                <p><b class="text-muted">email : </b> [[schoolDetails.school_nodal.nodaladmin.user.email]]</p>


                                <h3 style="margin-bottom: 16px;text-decoration: underline;">Neighbourhood Wards</h3>

                                <div ng-repeat="ward in schoolDetails.neighbourhood_wards">
                                    <p><b class="text-muted">[[$index + 1]] </b> [[ward.name]]</p>
                                </div>
                                <br>
                                <button ng-disabled="!schoolDetailData.udise" class="btn btn-primary" ng-click="helper.school_id=schoolDetails.school.id;openPopup('stateadmin', 'scripts', 'map-neighbourhood-ward', 'create-popup-style');">
                                    Map Neighbourhood Ward
                                </button>
                            </div>

                            <div class="col-md-7">
                                <h3 style="margin-bottom: 16px;">Application Cycles</h3>

                                <hr>

                                <div ng-repeat="item in schoolDetails.all_application_cycles">
                                    <p><b>Application_cycle_id : </b> [[item.id]]</p>
                                    <p><b>session year : </b> [[item.session_year]]</p>

                                    <p><b class="text-muted">Is school registered for this app_cyc (Entry in school_cycles table): </b> <span ng-if="item.school_cycle">Yes</span> <span ng-if="!item.school_cycle">No</span></p>

                                    <br>

                                    <p><b class="text-muted">Entry Class: </b>[[item.entry_class.level_info.level]] </p>
                                    <p><b class="text-muted">Total seats in [[item.entry_class.level_info.level]]: </b> [[item.entry_class.total_seats]] </p>
                                    <p><b class="text-muted">25% available seats in [[item.entry_class.level_info.level]]: </b> [[item.entry_class.available_seats]] </p>

                                    <br>

                                    <p style="margin-bottom: 2px;" class="text-muted">Students applied to this School: <b>[[item.no_reg_students]]</b></p>
                                    <p style="margin-bottom: 8px;" class="text-muted">
                                        Students ONLY applied to this School: <b>[[item.only_no_reg_students]]</b>
                                        <button ng-if="item.only_no_reg_students>0" class="btn btn-success" ng-click="Download.triggerDownload('stateadmin/script/student/applied-to-school/app_cyc/'+[[item.id]]+'/udise/'+[[schoolDetailData.udise]]+'/download', {})">Download students</button>
                                    </p>

                                    <br>

                                    <h5 style="margin-bottom: 8px;">Enrolled Students ([[item.enrolled_students.length]])</h5>
                                    <p><b class="text-muted">Student registration number : </b> <span ng-repeat="e_s in item.enrolled_students">[[e_s.basic_details.level_id]]-[[e_s.basic_details.registration_no]], </span> </p>

                                    <br>

                                    <h5 style="margin-bottom: 8px;">Allotted Students ([[item.alloted_students.length]])</h5>
                                    <p><b class="text-muted">Student registration number : </b> <span ng-repeat="a_s in item.alloted_students">[[a_s.basic_details.level_id]]-[[a_s.basic_details.registration_no]], </span> </p>

                                    <br>

                                    <h5 style="margin-bottom: 8px;">Dismissed Students ([[item.dismissed_students.length]])</h5>
                                    <p><b class="text-muted">Student registration number : </b> <span ng-repeat="d_s in item.dismissed_students">[[d_s.basic_details.level_id]]-[[d_s.basic_details.registration_no]], </span> </p>

                                    <hr>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="panel panel-default" >
                    <div class="panel-heading">Schools(verified) applied for latest application cycle having (0/null) total seats or 25% available available</div>
                    <div class="panel-body">

                        <button class="btn btn-primary" style="margin-top: 5px" ng-click="getAPIData('stateadmin/schools/registered-in/school_cycles/for-latest-app-cyc/have-zero-or-null-avalible-seats', 'null_seats_schools')">Get Schools</button>

                        <br>

                        <p ng-if="null_seats_schools.length>0" style="margin-top: 30px;">Schools ([[null_seats_schools.length]]):</p>

                        <div ng-if="null_seats_schools.length>0" style="width: 100%; max-height: 223px;overflow-y: scroll;">
                            {{-- <button ng-disabled="inProcess" class="btn btn-danger" style="margin-top: 5px" ng-really-action="Migrate" ng-really-message="Do you want to Migrate?" ng-really-click="create('stateadmin/migrate/schools/new-cycle/[[formData.application_status]]', {})">
                                <span ng-if="!inProcess">Migrate [[formData.application_status]] Schools to New cycle</span>
                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button> --}}

                            <div ng-repeat="item in null_seats_schools">
                                <p><b>Udise:-</b>[[item.udise]] <b>Id:-</b>[[item.id]]</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Re-checked schools for latest application cycle</div>
                    <div class="panel-body" ng-init="nodals={{$nodals}}">

                        <ui-select class="" ng-model="formData.nodal_id" theme="select2">
							<ui-select-match placeholder="Select Nodal">
							    [[$select.selected.user.email]]
							</ui-select-match>
							<ui-select-choices repeat="item.id as item in nodals | filter:$select.search">
							    [[item.user.email]]
							</ui-select-choices>
                        </ui-select>

                        <br>

                        <button class="btn btn-primary" style="margin-top: 5px" ng-click="getAPIData('stateadmin/schools/re-checked?nodal_id='+[[formData.nodal_id]], 'rechecked_schools')">Get Rechecked Schools</button>

                        <br>

                        <p ng-if="rechecked_schools.length>0" style="margin-top: 30px;">Schools ([[rechecked_schools.length]]):</p>

                        <div ng-if="rechecked_schools.length>0" style="width: 100%; max-height: 223px;overflow-y: scroll;">
                            <button ng-disabled="inProcess" class="btn btn-danger" style="margin-top: 5px" ng-really-action="Convert" ng-really-message="Do you want to Convert?" ng-really-click="create('stateadmin/schools/convert/re-checked/to/registered', formData)">
                                <span ng-if="!inProcess">Convert to Registered</span>
                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button>

                            <div ng-repeat="item in rechecked_schools">
                                <p><b>Udise:-</b>[[item.udise]] <b>Id:-</b>[[item.id]]</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" ng-controller="DownloadReportController as Download">
            <div class="col-md-4">
                <div class="panel panel-default" >
                    <div class="panel-heading">Download Schools having duplicate UDISE</div>
                    <div class="panel-body">
                        <button class="btn btn-primary" style="margin-top: 5px" ng-click="Download.triggerDownload('stateadmin/script/download-duplicate-udise-schools',{})">Download Schools</button>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">Get students who have selected given school in preferences <b>For Latest App Cyc</b></div>
                    <div class="panel-body">

        				<input validator="required" valid-method="blur" ng-model="school_udise" type="text" class="form-control" id="udise" placeholder="Enter udise" >

                        <br>

                        <button class="btn btn-primary" ng-click="getAPIData('stateadmin/script/student/applied-to-school/udise/'+[[school_udise]], 'selectedStudents')">Get Students</button>

                        <br>

                        <input class="form-control" style="margin-top: 20px;" validator="required" valid-method="blur" ng-model="school_replace_udise" type="text" id="udise" placeholder="Enter new udise" >

                        <br>

                        <button ng-if="selectedStudents.length>0" class="btn btn-danger" ng-click="getAPIData('stateadmin/script/student/applied-to-school/udise/'+[[school_udise]]+'/replace-udise/'+[[school_replace_udise]], 'selectedStudents')">Replace School in preferrence</button>

                        <br>

                        <p ng-if="selectedStudents" style="margin-top: 30px;">Students ([[selectedStudents.length]]):</p>

                        <div ng-if="selectedStudents.length>0" style="margin-bottom: 10px; width: 100%; max-height: 223px;overflow-y: scroll;">
                            <div ng-repeat="item in selectedStudents">
                                <p><b>Reg. no.</b> [[item.registration_id]], <b>Mob.</b> [[item.mobile]], <b>Email</b> [[item.email]]</p>
                            </div>
                            <hr>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<section class="admin_dash" ng-controller="AppController" ng-cloak>

    <div class="container-fluid" ng-init="formData={}">

        <hr>
        <h2>
            Student Sections
        </h2>
        <hr>

        <div class="row">
			<div class="col-md-12" ng-init="studentData={}">
                <div class="panel panel-default" style="font-size: 14px;">
                    <div class="panel-heading">Student Details</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
        						<input validator="required" valid-method="blur" ng-model="studentData.registration_no" type="text" class="form-control" id="registration_no" placeholder="Enter mobile/registration number" required>
                            </div>

                            <div class="col-md-4 pull-right">
                                <button ng-disabled="!studentData.registration_no" class="btn btn-primary" ng-click="getAPIData('stateadmin/script/student/info/'+[[studentData.registration_no]], 'studentDetails')">Get student details</button>
                            </div>
                        </div>

                        <hr>
                        <div class="row" ng-if="studentDetails">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success pull-right" style="margin-right: 5px;" ng-click="openPopup('stateadmin', 'scripts', 'change-student-status', 'create-popup-style');helper.studentData=studentDetails">
                                            Change Status
                                        </button>
                                        <button class="btn btn-success pull-right" style="margin-right: 5px;" ng-click="openPopup('stateadmin', 'scripts', 'change-student-category', 'create-popup-style');helper.studentData=studentDetails">
                                            Change Category
                                        </button>
                                        <button class="btn btn-success pull-right" style="margin-right: 5px;" ng-click="openPopup('stateadmin', 'scripts', 'change-student-dob', 'create-popup-style');helper.studentData=studentDetails">
                                            Change DOB
                                        </button>
                                        <button class="btn btn-success pull-right" style="margin-right: 5px;" ng-disabled="inProcess" ng-really-action="Allot" ng-really-message="Do you want to allot seat?" ng-really-click="create('stateadmin/script/student/'+ [[studentDetails.id]]+'/allot-seat', {})">
                                                <span ng-if="!inProcess">Allot Seat</span>
                                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h3 style="margin-bottom: 16px;">Student details</h3>
                                <p>
                                    <a target="_blank" href="/stateadmin/students/[[studentDetails.registration_no]]">
                                        <b class="text-muted">Registration No : </b> [[studentDetails.registration_no]]
                                    </a>
                                </p>
                                <p><b class="text-muted">Name : </b> [[studentDetails.first_name]] [[studentDetails.last_name]]</p>
                                <p><b class="text-muted">ID : </b> [[studentDetails.id]]</p>
                                <p><b class="text-muted">Phone : </b> [[studentDetails.mobile]]</p>
                                <p><b class="text-muted">Date Of Birth : </b> [[studentDetails.fmt_dob]]</p>
                                <p><b class="text-muted">Applied Class : </b> [[studentDetails.level_id]]</p>
                                <p><b class="text-muted">Allotted School ID : </b> [[studentDetails.student.allotted_school_id]]</p>
                                <p><b class="text-muted">Status : </b> [[studentDetails.status]]</p>
                                <p><b class="text-muted">Application status : </b> [[studentDetails.registration_cycle.status]]</p>
                                <p><b class="text-muted">Doc verification status : </b> [[studentDetails.registration_cycle.document_verification_status]]</p>

                                <p><b class="text-muted">District : </b> [[studentDetails.personal_details.district.name]]</p>
                                <p><b class="text-muted">Block : </b> [[studentDetails.personal_details.block.name]]</p>
                                <p><b class="text-muted">Locality : </b> [[studentDetails.personal_details.locality.name]]</p>
                                <p><b class="text-muted">Block Admin : </b> [[studentDetails.nodal.nodaladmin.user.email]]</p>


                                <p><b class="text-muted">Preferrence : </b> [[studentDetails.registration_cycle.preferences]]</p>
                                <p><b class="text-muted">Nearby preferrence : </b> [[studentDetails.registration_cycle.nearby_preferences]]</p>
                                <p><b class="text-muted">Allotted school ID : </b> #[[studentDetails.registration_cycle.allotted_school_id]]</p>


                                <p><b class="text-muted">Created At : </b> [[studentDetails.created_at]]</p>
                                <p><b class="text-muted">Updated At : </b> [[studentDetails.updated_at]]</p>
                            </div>
                            <div class="col-md-8">
                                <div class="" ng-if="studentDetails.schools.length > 0">
                                    <h3 style="margin-bottom: 16px;">School preferences and allotted school</h3>
                                    <div class="row">
                                        <!-- Loop through each school and list them -->
                                        <div class="col-sm-12 col-xs-12">
                                            <table class="table table-responsive table-bordered custom-table">
                                                <thead class="thead-cls">
                                                    <tr>
                                                        <th>UDISE</th>
                                                        <th>School ID</th>
                                                        <th>Name</th>
                                                        <th>Total</th>
                                                        <th>Allotted</th>
                                                        <th>Available</th>
                                                        <th>Preference</th>
                                                    </tr>
                                                </thead>
                                                <tr ng-repeat="preferedSchool in studentDetails.schools">
                                                    <td>[[preferedSchool.udise]]</td>
                                                    <td>#[[preferedSchool.id]]</td>
                                                    <td>[[preferedSchool.name]]</td>
                                                    <td>[[preferedSchool.total_seats]]</td>
                                                    <td>[[preferedSchool.allotted_seats]]</td>
                                                    <td>[[preferedSchool.available_seats]]</td>
                                                    <td>[[preferedSchool.preferences]]</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> Manual lottery script Trigger</div>
                    <div class="panel-body" style="overflow: auto;">
                       <button class="btn btn-success" ng-disabled="inProcess" ng-really-action="Trigger" ng-really-message="Do you want to trigger the lottery?" ng-really-click="create('stateadmin/script/manual/lottery/run', {})">
                            <span ng-if="!inProcess">Trigger</span>
                            <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                       </button>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> Post lottery analysis of latest app cycle</div>
                    <div class="panel-body" style="overflow: auto;">
                       <button class="btn btn-success" ng-disabled="inProcess" ng-click="create('stateadmin/script/lottery/analysis', {})">
                            <span ng-if="!inProcess">Analysis</span>
                            <span ng-if="inProcess">Please wait. watch result in networks. <i class="fa fa-spinner fa-spin"></i></span>
                       </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Students who have not selected any schools
                        <span>
                            <button class="btn btn-success" ng-click="getAPIData('stateadmin/script/students/schools-not-selected', 'regStudents')">
                                <span ng-if="!inProcess">Get Students</span>
                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </span>
                    </div>
                    <div class="panel-body" style="overflow: auto;">
                        <p>
                            Total students who are not selected prefered schools for the current cycle <b> [[regStudents.length ? regStudents.length:0 ]] </b>
                        </p>
                        <table ng-if="regStudents.length>0" class="table table-responsive custom-table table-bordered">
                            <thead class="thead-cls">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Preferrence</th>
                                    <th>Nearby preferrence</th>
                                    <th>Applcation status</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in regStudents">
                                <td>
                                    [[item.registration_no]]
                                </td>

                                <td>
                                    <a target="_blank" href="/stateadmin/students/[[item.registration_no]]">[[item.first_name]] [[item.last_name]]</a>
                                </td>

                                <td>[[item.registration_cycle.preferences]]</td>

                                <td>[[item.registration_cycle.nearby_preferences]]</td>

                                <td>[[item.status]]</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" ng-init="unallottedStudents=[]">
                 <div class="panel panel-default">
					<div class="panel-heading">
                        Get students who got no school

                        <span class="pull-right">
                            [[ unallottedStudents.length ? unallottedStudents.length : 0]] students
                        </span>
                    </div>
					<div class="panel-body">

                        <div class="row">
                            <div class="col-md-6 ">
                            </div>
                            <div class="col-md-6 text-right">
                                <button  class="btn btn-primary" ng-click="getAPIData('stateadmin/script/students/not-allotted', 'unallottedStudents')">
                                    Get Students
                                </button>
                                <button  ng-if="unallottedStudents.length" type="button" ng-disabled="inProcess" class="btn btn-danger" ng-really-action="Add" ng-really-message="Do you want to add class 1 as entry class?" ng-really-click="create('stateadmin/script/schools/add-entry-class',{})">
                                    <span ng-if="!inProcess">DNC</span>
                                    <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="panel-body text-left"></div>
                        <div class="row text-center" ng-if="unallottedStudents.length">
                            <div class="col-md-3"> Registration No </div>
                            <div class="col-md-6"> Level </div>
                            <div class="col-md-6"> Applied Cycle </div>
                            <div class="col-md-3"> Schools </div>
                        </div>

                        <div class="panel-body scroll" ng-if="unallottedStudents.length">
                            <div class="row text-center" ng-repeat="unallottedStu in unallottedStudents">
                                <div class="col-md-3">
                                    [[unallottedStu.basic_details.registration_no]]
                                </div>
                                <div class="col-md-3">
                                    [[unallottedStu.basic_details.level.level]]
                                </div>
                                <div class="col-md-3">
                                    [[unallottedStu.application_cycle_id]]
                                </div>
                                <div class="col-md-3">
                                    [[unallottedStu.schools.length]]
                                </div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-10 col-md-10 col-xs-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Students who have not updated application for second cycle
                        <span>
                            <button class="btn btn-success" ng-click="getAPIData('stateadmin/script/students/not-updated-application', 'notUpdatedStudents')">
                                <span ng-if="!inProcess">Get Students</span>
                                <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </span>
                    </div>
                    <div class="panel-body" style="overflow: auto;">
                        <p>
                            Students who have not updated application for second cycle <b> [[notUpdatedStudents.length ? notUpdatedStudents.length:0 ]] </b>
                        </p>
                        <table ng-if="notUpdatedStudents.length>0" class="table table-responsive custom-table table-bordered">
                            <thead class="thead-cls">
                                <tr>
                                    <th>ID</th>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Application Cycle</th>
                                    <th>Preferrence</th>
                                    <th>Nearby preferrence</th>
                                    <th>Applcation status</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="item in notUpdatedStudents">
                                <td>
                                    [[item.id]]
                                </td>

                                <td>
                                    [[item.registration_no]]
                                </td>

                                <td>
                                    <a target="_blank" href="/stateadmin/students/[[item.registration_no]]">[[item.first_name]] [[item.last_name]]</a>
                                </td>

                                <td>[[item.registration_cycle.application_cycle_id]]</td>

                                <td>[[item.registration_cycle.preferences]]</td>

                                <td>[[item.registration_cycle.nearby_preferences]]</td>

                                <td>[[item.status]]</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>


@endsection

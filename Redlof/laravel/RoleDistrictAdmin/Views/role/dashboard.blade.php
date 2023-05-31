@extends('districtadmin::includes.layout')
@section('content')
<div class="state-single cm-content dash_content" ng-controller="AppController">
    <div class="" ng-controller="DashboardController as Dashboard">
        <div>
            {{-- <div class="dash_hero_sec">
				<div class="state-profile">
					<h2>
					{{$district->name}} - District
            </h2>
        </div>
    </div> --}}
    <div class="dashboard_container">

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <h4>VIEWING STUDENT DETAILS</h4>
                <div class=""
                    ng-init="Dashboard.formData.selectedCycle='{{$current_cycle}}';Dashboard.formData.selectedDistrict={{$district->id}};Dashboard.formData.selectedNodal='null';Dashboard.formData.selectedSchool='null';Dashboard.formData.selectedSex='null';Dashboard.formData.selectedCategory='null';Dashboard.applyFilterStudentDetails('districtadmin/apply-filter/student-details', Dashboard.formData);">

                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <div ng-show="Dashboard.show_student_details" ng-cloak>
                                <form name="student-details" class="d_board_form"
                                    ng-submit="Dashboard.applyFilterStudentDetails('districtadmin/apply-filter/student-details/true', Dashboard.formData)">
                                    <div class="form-inline">
                                        <div class="form-group" ng-init="">
                                            <div class="input-group">
                                                <select class="form-control" ng-model="Dashboard.formData.selectedCycle"
                                                    id="sel1">
                                                    <option value="null">Admission Cycle</option>
                                                    <option value="[[cycle.session_year]]"
                                                        ng-repeat="cycle in Dashboard.admissionCycle">[[cycle.session_year]] -
                                                        [[cycle.session_year+1]]</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit"
                                                ng-click="Dashboard.getSchoolInfo(Dashboard.formData.selectedCycle,Dashboard.selectedDistrict,Dashboard.selectedNodal,'true')"
                                                class="btn btn-primary btn-theme">Apply filters</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12" ng-if="Dashboard.show_school_information" ng-cloak>
                            <button class="btn btn-info float-right" ng-disabled="!Dashboard.show_school_information"
                                ng-click="Dashboard.getSchoolInfo(Dashboard.formData.selectedCycle,Dashboard.selectedDistrict,Dashboard.selectedNodal,'true');Dashboard.applyFilterStudentDetails('districtadmin/apply-filter/student-details/true', Dashboard.formData)">
                                <i class="fas fa-sync"></i> fetch
                            </button>
                            <div class="float-right sa-db-last-fetch">
                                <small>Last fetched [[Dashboard.schoolInfo.created_at]]</small>
                            </div>
                        </div>
                    </div>


                    <div ng-show="!Dashboard.show_student_details">
                        <div class="row">
                            <div class="text-center col-md-12">
                                <h2>Loading</h2>
                                <img src="{!! asset('img/loader.gif') !!}">
                                <h2> </h2>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div ng-show="!Dashboard.show_school_information">
                        <div class="row">
                            <div class="text-center col-md-12">
                                <h2>Loading</h2>
                                <img src="{!! asset('img/loader.gif') !!}">
                                <h2> </h2>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div ng-show="Dashboard.show_student_details" ng-cloak>
            <div class="row" ng-cloak>
                <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_seats]]</h2>
                        <p>Overall Available Seats</p>
                    </div>
                </div>
                <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_unique_applications_received]]</h2>
                        <p>Total Unique Students Applied</p>
                    </div>
                </div>
                <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_allotted]]</h2>
                        <p>Total Students Allotted</p>
                    </div>
                </div>
                <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_admitted]]</h2>
                        <p>Total Students Admitted (enrolled)</p>
                    </div>
                </div>
                <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_verified]]</h2>
                        <p>Total Students Verified</p>
                    </div>
                </div>
                 <div class="school_det_cart">
                    <div class="ttl_new_count_card">
                        <h2>[[Dashboard.studentFilteredData.data.total_rejected]]</h2>
                        <p>Total Students Rejected</p>
                    </div>
                </div>
            </div>
        </div>

        <div class=""
            ng-init="Dashboard.initAdmissionCycle();Dashboard.selectedCycle='{{$current_cycle}}';Dashboard.selectedDistrict={{$district->id}};Dashboard.initNodals(Dashboard.selectedDistrict); Dashboard.selectedNodal='null';Dashboard.getSchoolInfo(Dashboard.selectedCycle,Dashboard.selectedDistrict,Dashboard.selectedNodal)">
            <div ng-show="Dashboard.show_school_information" ng-cloak>

                <div class="row">
                    <div class="school_det_cart">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.total_schools_udise]]</h2>
                            <p>Total Schools present in UDISE</p>
                        </div>
                    </div>
                    <div class="school_det_cart">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.verified_schools]]</h2>
                            <p>Number of Schools which verified</p>
                        </div>
                    </div>
                    <div class="school_det_cart">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.registered_schools]]</h2>
                            <p>Number of Schools which registered</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h2>
                            School admissions
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.one_student_enrolled]]</h2>
                            <p>Schools with at least one admission (one student enrolled)</p>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.schools_with_no_application]]</h2>
                            <p>Schools with 0 applications (Schools which didn’t get any application from students)</p>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="ttl_new_count_card">
                            <h2>[[Dashboard.schoolInfo.data.schools_with_no_enrollment]]</h2>
                            <p>Schools with >0 application and no admission( Had some allotment but no enrollment)</p>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="chart_card">
                    <div class="header">
                        <h6>
                            Admitted Students - EWS vs DG
                        </h6>
                    </div>
                    <div id="ewsDg" class="custom_piechart_canvas">
                    </div>
                    <div class="footer_chart">
                        <p ng-if="Dashboard.studentFilteredData.data.registered_students_group_graph.show==true">
                            <span>
                                <strong>
                                    [[ Dashboard.studentFilteredData.data.registered_students_group_graph.ews_percentage
                                    ]]%
                                </strong>
                                Economically Weaker Section(EWS)
                            </span>
                            <span>
                                <strong class="txt-purple">[[
                                    Dashboard.studentFilteredData.data.registered_students_group_graph.dg_percentage
                                    ]]%</strong>
                                Disadvanted Group (DG) </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="chart_card">
                    <div class="header">
                        <h6>
                            Admission bifurcation of gender
                        </h6>
                    </div>
                    <div id="boyGirl" class="custom_piechart_canvas">
                    </div>
                    <div class="footer_chart">
                        <p ng-if="Dashboard.studentFilteredData.data.registered_students_gender_graph.show==true">
                            <span><strong>[[
                                    Dashboard.studentFilteredData.data.registered_students_gender_graph.boys_percentage
                                    ]]%</strong>Boys</span>
                            <span> <strong class="txt-purple">[[
                                    Dashboard.studentFilteredData.data.registered_students_gender_graph.girls_percentage
                                    ]]%</strong>Girls </span>
                            <span><strong>[[
                                    Dashboard.studentFilteredData.data.registered_students_gender_graph.transgender_percentage
                                    ]]%</strong>Transgender </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

</div>
</div>
</div>
</div>
@endsection

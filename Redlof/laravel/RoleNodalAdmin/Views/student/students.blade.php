@extends('nodaladmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List" ng-init="List.selectedCycle=null">
        <div class="row">

            <div class="col-sm-6 col-xs-12">
                <div class="heading-strip"></div>
            </div>
            <div class="col-sm-9 col-xs-12">
                <div class="all-admin-link">
                    <a href="">
                        <button class="btn btn-primary">छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.allotedstudents') }}">
                        <button class="btn btn-default">आवंटित छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.enrolledstudents') }}">
                        <button class="btn btn-default">नामांकित छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.verifiedstudents') }}">
                        <button class="btn btn-default">सत्यापित छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.all.rejectedstudents') }}">
                        <button class="btn btn-default">खारिज किए गये छात्र</button>
                    </a>
                    {{-- <a href="{{ route('nodaladmin.rejectedstudents') }}">
                        <button class="btn btn-default">अनुरोध अस्वीकार</button>
                    </a> --}}
                </div>
            </div>
            <div class="col-sm-2 col-xs-12  text-right">
                <div class="form-group">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                            ng-init="getAPIData('nodaladmin/get/applicationcycle','admissionCycle')">
                            Admission Cycles
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li ng-repeat="cycle in admissionCycle"><a href=""
                                    ng-click="List.selectedCycle=cycle.session_year;List.init('student-list', {'getall': 'nodaladmin/allstudents?selectedCycle='+cycle.session_year, 'search': 'nodaladmin/allstudents/searchByName?selectedCycle='+cycle.session_year })">[[cycle.session_year]]
                                    - [[cycle.session_year+1]]</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div ng-init="List.init('student-list', { 'search': 'nodaladmin/allstudents/searchByName', 'getall': 'nodaladmin/allstudents?selectedCycle='+cycle.session_year})"
                ng-cloak>
                <div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="search-action clearfix">
                            <span class="">
                                <div class="form-group">
                                    <input ng-model="keyword" search-icon type="text"
                                        class="form-control theme-blur-focus clearable"
                                        placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
                                </div>
                                <button ng-disabled="List.appTableService.inProcess" class="btn-theme btn-blue"
                                    ng-click="List.search(keyword)" type="button">
                                    <span ng-if="!List.appTableService.inProcess">खोज</span>
                                    <span ng-if="List.appTableService.inProcess">Please Wait.. <i
                                            class="fa fa-spinner fa-spin"></i></span>
                                </button>
                                </form>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <div class="rt-action  pull-right" ng-controller="DownloadReportController as Download">
                            <button ng-if="List.ListService.results.length > 0" type="button"
                                class="btn btn-warning pull-right"
                                ng-click="Download.triggerDownload('nodaladmin/allstudents/download?selectedCycle='+List.selectedCycle)"><i
                                    class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</button>
                        </div>
                    </div>
                    <div ng-if="List.ListService.results.length > 0">
                        <table class="table table-responsive custom-table table-bordered" ng-controller="ToBeVerifiedStudent as DocVerify">
                            <thead class="thead-cls">
                                <tr>
                                    <th>आई.डी</th>
                                    <th>छात्र का नाम</th>
                                    <th>स्थिति</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="student in List.ListService.results">
                                <td>
                                    [[student.basic_details.registration_no]]
                                </td>
                                <td>
                                    <a target="_blank" href="student-details/[[student.basic_details.id]]">[[student.basic_details.first_name]]</a>
                                </td>
                                <td class="text-capitalize">
                                    <span ng-if="!student.document_verification_status">[[student.status]]</span>
                                    <span ng-if="student.document_verification_status">[[student.document_verification_status]]</span>
                                </td>
                                <td>

                                        <div ng-if="student.doc_verification_status==NULL&&student.application_cycle_id=={{$latest_application_cycle->id}}" class="btn-docverify[[student.basic_details.id]]">
                                            <button style="width:42%;" class="btn btn-success"
                                                ng-click="DocVerify.documentVerifyStudent(student.basic_details.id,'verifed')">
                                                Verify
                                            </button>

                                            <button style="margin-left: 10px;width:42%" class="btn btn-danger"
                                                ng-click="helper.registration_id=student.basic_details.id;openPopup('nodaladmin', 'student', 'reject-student-reason', 'create-popup-style')">
                                                Reject
                                            </button>
                                        </div>

                                    <span ng-if="student.document_verification_status">-</span>
                                </td>
                            </tr>
                        </table>
                        <div class="t-footer">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <p>
                                        Showing [[List.ListService.currentPage]] of [[List.ListService.totalPage]]
                                        pages.
                                    </p>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="prev-next pagination-custom tb-pagination pull-right">
                                        <table class="table">
                                            <td class="no-border">
                                                <ul class="list-unstyled list-inline text-left"
                                                    ng-class="{ 'hide-pagination': !List.ListService.pagination }">
                                                    <li>
                                                        <a href="" ng-click="List.prevPage()" class="next-prev-link">
                                                            <i class="fa ion-ios-arrow-left" aria-hidden="true"></i>
                                                            <span>
                                                                Prev [[List.ListService.pagesize]]
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" ng-click="List.nextPage()" class="next-prev-link">
                                                            <span>
                                                                Next [[List.ListService.pagesize]]
                                                            </span>
                                                            <i class="fa ion-ios-arrow-right" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div align="center" class="col-sm-12 col-xs-12">
                        <p ng-if="List.ListService.results.length == 0">No Students to display</p>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

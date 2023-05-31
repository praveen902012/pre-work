@extends('districtadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List"
        ng-init="List.selectedCycle=null;List.init('student-list', {'getall': 'districtadmin/allottedstudents','search': 'districtadmin/search/allottedstudents'})"
        ng-cloak>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="all-admin-link" ng-controller="DownloadReportController as Download">
                    <a href="{{ route('districtadmin.students') }}">
                        <button class="btn btn-default">छात्र</button>
                    </a>
                    <a href="{{ route('districtadmin.registeredstudents') }}">
                        <button class="btn btn-default">पंजीकृत छात्र</button>
                    </a>
                    <a href="">
                        <button class="btn btn-primary">आवंटित छात्र</button>
                    </a>
                    <a href="{{ route('districtadmin.enrolledstudents') }}">
                        <button class="btn btn-default">दाखिला लिया छात्र</button>
                    </a>

                </div>
            </div>

            <div class="col-sm-6 col-xs-12 form-inline">
                <div class="pull-right">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                ng-init="getAPIData('districtadmin/get/applicationcycle','admissionCycle')">
                                Admission Cycle
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li ng-repeat="cycle in admissionCycle"><a href=""
                                        ng-click="List.selectedCycle=cycle.session_year;List.init('student-list', {'getall': 'districtadmin/allottedstudents?selectedCycle='+cycle.session_year, 'search': 'districtadmin/search/allottedstudents?selectedCycle='+cycle.session_year})">[[cycle.session_year]]
                                        - [[cycle.session_year+1]]</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group" ng-controller="DownloadReportController as Download">
                        <button ng-if="List.ListService.results.length > 0" type="button" class="btn btn-warning"
                            ng-click="Download.triggerDownload('districtadmin/allottedstudents/download?selectedCycle='+List.selectedCycle)"><i
                                class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</button>
                    </div>
                </div>
            </div>

            <br>
            <div class="col-sm-12">
                <b class="mb-2" ng-if="List.selectedCycle" style="margin-bottom:20px;display: block;">For Admission Cycle: [[List.selectedCycle]] - [[List.selectedCycle + 1 ]]</b>
                <b class="mb-2" ng-if="!List.selectedCycle" style="margin-bottom:20px;display: block;">For Admission Cycle: {{$current_cycle}} - {{$current_cycle + 1}}</b>
            </div>
            

            <div>
                <div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="search-action clearfix">
                            <form class="">
                                <div class="form-group">
                                    <input ng-model="keyword" search-icon type="text"
                                        class="form-control theme-blur-focus clearable"
                                        placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
                                </div>
                                <button ng-disabled="List.appTableService.inProcess" class="btn-theme btn-blue"
                                    ng-click="List.search(keyword)" type="button">
                                    <span ng-if="!List.appTableService.inProcess">खोज</span>
                                    <span ng-if="List.appTableService.inProcess">Please wait.. <i
                                            class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div ng-if="List.ListService.results.length > 0">
                        <table class="table table-responsive custom-table table-bordered">
                            <thead class="thead-cls">
                                <tr>
                                    <th>आई.डी</th>
                                    <th>छात्र का नाम</th>
                                    <th>जन्म तिथि</th>
                                    <th>Class</th>
                                    <th>विद्यालय</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="student in List.ListService.results">
                                <td>[[student.registration_no]]</td>
                                <td>[[student.first_name]]</td>
                                <td>[[student.dob | date:'mediumDate']]</td>
                                <td>[[student.level.level]]</td>
                                <td>[[student.registration_cycle.school.name]]</td>
                                <td class="text-center"><a class="btn btn-primary btn-md a-no-style"
                                        ng-href="student/details/[[student.registration_no]]">View details</a></td>
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
    </div>
</section>
@endsection
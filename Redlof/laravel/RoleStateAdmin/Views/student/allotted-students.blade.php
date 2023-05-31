@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List" ng-init="List.selectedCycle={{$latest_application_cycle->session_year}}">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="all-admin-link">
                    <a href="{{ route('stateadmin.registeredstudents') }}">
                        <button class="btn btn-default">पंजीकृत छात्र</button>
                    </a>
                    <a href="">
                        <button class="btn btn-primary">आवंटित छात्र</button>
                    </a>
                    <a href="{{ route('stateadmin.enrolledstudents') }}">
                        <button class="btn btn-default">नामांकित छात्र</button>
                    </a>
                     <a href="{{route('stateadmin.dismissedstudents')}}">
                        <button class="btn btn-default">ख़ारिज छात्र</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 form-inline">
                <div class="pull-right">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                ng-init="getAPIData('stateadmin/get/applicationcycle','admissionCycle')">
                                [[List.selectedCycle]] - [[List.selectedCycle + 1 ]]
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li ng-repeat="cycle in admissionCycle"><a href=""
                                        ng-click="List.selectedCycle=cycle.session_year;List.init('student-list', {'getall': 'stateadmin/allottedstudents?selectedCycle='+cycle.session_year, 'search':'stateadmin/allottedstudents/search?selectedCycle='+cycle.session_year })">[[cycle.session_year]]
                                        - [[cycle.session_year+1]]</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group" ng-controller="DownloadReportController as Download">
                        <button ng-disabled="Download.inProcess" ng-if="List.ListService.results.length > 0" type="button"
                            class="btn btn-warning pull-right" ng-click="Download.triggerDownload('stateadmin/download/allottedstudents?selectedCycle='+List.selectedCycle)">
                            <span ng-if="!Download.inProcess"><i class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</span>
                            <span ng-if="Download.inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div ng-init="List.init('student-list', {'getall': 'stateadmin/allottedstudents', 'search':'stateadmin/allottedstudents/search'})"
                    ng-cloak>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class=" search-action clearfix">
                                <form class="">
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

                        </div>
                    </div>
                    <div ng-if="List.ListService.results.length > 0">
                        <div class="tb-container">
                            <div class="table-responsive ">
                                <div class="rte-table bg-wht">
                                    <table class="table table-fixed">
                                        <thead class="thead-cls">
                                            <tr>
                                                <th class="col-xs-2">आई.डी</th>
                                                <th class="col-xs-2">छात्र का नाम</th>
                                                <th class="col-xs-2">जन्म तिथि</th>
                                                <th class="col-xs-2">Class</th>
                                                <th class="col-xs-2">School</th>
                                                <th class="col-xs-2">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="student in List.ListService.results">
                                                <td class="col-xs-2">[[student.basic_details.registration_no]]</td>
                                                <td class="col-xs-2">[[student.basic_details.first_name]]</td>
                                                <td class="col-xs-2">[[student.basic_details.dob | date:'mediumDate']]
                                                </td>
                                                <td class="col-xs-2">[[student.basic_details.level.level]]</td>
                                                <td class="col-xs-2">[[student.school.name]]</td>
                                                <td class="col-xs-2">[[student.fmt_status]]</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                    <div align="center" ng-if="List.ListService.results.length == 0">
                        <p ng-if="List.ListService.results.length == 0">No Students to display</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

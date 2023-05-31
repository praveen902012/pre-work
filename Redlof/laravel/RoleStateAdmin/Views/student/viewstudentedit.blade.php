@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List" ng-init="List.selectedCycle=null">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
               <h2>Students</h2>
            </div>

            <div class="col-sm-6 col-xs-12 form-inline">
                <div class="pull-right">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                ng-init="getAPIData('stateadmin/get/applicationcycle','admissionCycle')">
                                Admission Cycle
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li ng-repeat="cycle in admissionCycle"><a href=""
                                        ng-click="List.selectedCycle=cycle.session_year;List.init('student-list', {'getall': 'stateadmin/registeredstudents?selectedCycle='+cycle.session_year})">[[cycle.session_year]]
                                        - [[cycle.session_year+1]]</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div ng-init="List.init('student-list', {'getall': 'stateadmin/registeredstudents', 'search':'stateadmin/registeredstudents/search'})"
                    ng-cloak>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="search-action clearfix">
                                <form class="">
                                    <div class="form-group">
                                        <input ng-model="keyword" search-icon type="text"
                                            class="form-control theme-blur-focus clearable"
                                            placeholder="Search by ID" table-list-search="[[List.ListName]]">
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
                                                <th class="col-xs-4">आई.डी</th>
                                                <th class="col-xs-4">छात्र का नाम</th>
                                                <th class="col-xs-2">Mobile</th>
                                                <th class="col-xs-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="student in List.ListService.results">
                                                <td class="col-xs-4">[[student.registration_no]]</td>
                                                <td class="col-xs-4">[[student.first_name]]</td>
                                                <td class="col-xs-2">[[student.mobile]]</td>
                                                <td class="col-xs-2">
                                                    <a ng-click="openPopup('stateadmin', 'student', 'update-student-mobile', 'create-popup-style');helper.student=student" class="btn btn-blue-outline">Update phone</a>
                                                </td>
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
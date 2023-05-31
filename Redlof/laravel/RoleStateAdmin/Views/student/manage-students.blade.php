@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List" ng-init="List.selectedCycle=null">

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div ng-init="List.init('student-list', {'getall': 'stateadmin/registeredstudents', 'search':'stateadmin/registeration/completed/students/search'})"
                    ng-cloak>
                    <h2>Manage Students</h2>
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
                                                <th class="col-xs-3">आई.डी</th>
                                                <th class="col-xs-3">छात्र का नाम</th>
                                                <th class="col-xs-2">जन्म तिथि</th>
                                                <th class="col-xs-2">Status</th>
                                                <th class="col-xs-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="student in List.ListService.results">
                                                <td class="col-xs-3">[[student.registration_no]]</td>
                                                <td class="col-xs-3">[[student.first_name]]</td>
                                                <td class="col-xs-2">[[student.dob | date:'mediumDate']]</td>
                                                <td class="col-xs-2">[[student.status]]</td>
                                                <td class="col-xs-2">
                                                    <a ng-disabled="inProcess" ng-really-action="Make Editable" ng-really-message="By marking the student as editable, Student with Registration ID:- [[student.registration_no]] will not be considered as Registered to the platform. Unless he/she resume and Complete the registration." ng-really-click="create('stateadmin/registeration/completed/students/'+[[student.registration_no]]+'/activate')" class="btn btn-blue-outline">
                                                        <span ng-if="!inProcess">Mark as Editable</span>
                                                        <span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
                                                    </a>
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
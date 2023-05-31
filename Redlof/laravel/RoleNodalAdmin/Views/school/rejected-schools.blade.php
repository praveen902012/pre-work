@extends('nodaladmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List"
        ng-init="List.cycle ='Admission Cycle';List.year=null">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="heading-strip">
                    <h2>
                        Rejected Schools
                    </h2>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-init="latest_session_year={{$latest_application_cycle->session_year}}">
                <!-- <a href="{{route('school.add-school')}}"  class="btn btn-blue-outline pull-right" >
					Add Schools
				</a> -->
                <div class="all-admin-link pull-right">
                    <span class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                [[List.cycle]]
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                @foreach($years as $year)
                                <li>
                                    <a href="#"
                                        ng-click="List.year={{$year}};List.cycle='{{$year}} - {{$year+1}}'; List.init('student-list', {'getall': 'nodaladmin/get/rejected-schools/?selectedCycle={{$year}}','search': 'nodaladmin/schools/search-rejected?selectedCycle={{$year}}'})">
                                        {{$year}} - {{$year+1}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </span>
                    <a href="{{route('school.all-schools')}}" class="btn btn-blue-outline">
                        All Schools
                    </a>
                    <a href="{{route('school.registered-schools')}}" class="btn btn-blue-outline">
                        Registered Schools
                    </a>
                    <a href="{{route('school.verified-schools')}}" class="btn btn-blue-outline">
                        Verified Schools
                    </a>
                    <a href="" class="btn btn-blue">
                        Rejected Schools
                    </a>
                    <a href="{{route('school.banned-schools')}}" class="btn btn-blue-outline">
                        Banned Schools
                    </a>
                </div>
            </div>
            <div ng-init="List.init('school-list', {'getall': 'nodaladmin/get/rejected-schools','search': 'nodaladmin/schools/search-rejected'})"
                ng-cloak>
                <div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="search-action clearfix">
                                <form class="">
                                    <div class="form-group">
                                        <input ng-model="keyword" search-icon type="text"
                                            class="form-control theme-blur-focus clearable"
                                            placeholder="Search by Name or UDISE" table-list-search="[[List.ListName]]">
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
                                    class="btn btn-warning pull-right" ng-disabled="Download.inProcess"
                                    ng-click="Download.triggerDownload('nodaladmin/get/rejected-schools/download?selectedCycle='+List.year)">
                                    <span ng-if="!Download.inProcess"><i class="fa fa-download"></i> Download Excel</span>
                                    <span ng-if="Download.inProcess">Please wait..<i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div ng-if="List.ListService.results.length > 0">
                        <table class="table table-responsive custom-table">
                            <thead class="thead-cls">
                                <tr>
                                    <th>S.No.</th>
                                    <th>U-डाइस</th>
                                    <th>विद्यालय का नाम</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="school in List.ListService.results">
                                <td>[[$index+1]]</td>
                                <td>[[school.school.udise]]</td>
                                <td>[[school.school.name]]</td>
                                <td>
                                    <a href="school/[[school.school.id]]" target="_blank"
                                        class="btn btn-success btn-xs city-action-btn">Details</a>

                                    @if($all_application_cycle->where('status', 'new')->count())
                                        <!-- <a ng-really-action="Accept" ng-really-message="Do you want to accept this school?"
                                            ng-really-click="create('nodaladmin/school/accept/'+[[school.school.id]],  school, 'accept')"
                                            class="btn btn-success btn-xs city-action-btn">
                                            Verify
                                        </a> -->
                                    @endif
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
                        <p ng-if="List.ListService.results.length == 0">No Schools to display</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

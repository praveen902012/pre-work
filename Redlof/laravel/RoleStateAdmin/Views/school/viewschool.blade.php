@extends('stateadmin::includes.layout')
@section('content')
<section class="stateadmin_dash" ng-controller="AppController" ng-cloak>
    <div class="container-fluid" ng-controller="ListController as List" ng-init="List.init('school-list', {'getall': 'stateadmin/get/registered-schools', 'search': 'stateadmin/schools/search-registered'});
        List.cycle='Admission Cycle';List.year=null" ng-cloak>

        <h2 ng-init="title='Registered'">
            [[title]] Schools
        </h2>

        <div class="row">
            <div class="col-sm-12 pd-tb-2">
                <button ng-click="List.init('school-list', {'getall': 'stateadmin/get/verified-schools', 'search': 'stateadmin/schools/search-verified'}); title='Verified'" class="btn btn-blue-outline float-right" ng-class="{'btn-blue': title=='Verified'}">Verified School</button>
                <button ng-click="List.init('school-list', {'getall': 'stateadmin/get/registered-schools', 'search': 'stateadmin/schools/search-registered'}); title='Registered'" class="btn btn-blue-outline float-right" ng-class="{'btn-blue': title=='Registered'}">Registered School</button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12"></div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group pull-right">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            [[List.cycle]]
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            @foreach($years as $year)
                            <li ng-if="title=='Registered'">
                                <a href="#"
                                    ng-click="List.year={{$year}};List.cycle='{{$year}} - {{$year+1}}'; List.init('school-list', {'getall': 'stateadmin/get/registered-schools?selectedCycle={{$year}}', 'search': 'stateadmin/schools/search-registered?selectedCycle={{$year}}' })">
                                    {{$year}} - {{$year+1}}
                                </a>
                            </li>
                            <li ng-if="title=='Verified'">
                                <a href="#"
                                    ng-click="List.year={{$year}};List.cycle='{{$year}} - {{$year+1}}'; List.init('school-list', {'getall': 'stateadmin/get/verified-schools?selectedCycle={{$year}}', 'search': 'stateadmin/schools/search-verified?selectedCycle={{$year}}' })">
                                    {{$year}} - {{$year+1}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="rt-action  pull-left" ng-controller="DownloadReportController as Download">
                    <button ng-disabled="Download.inProcess" ng-if="List.ListService.results.length > 0" type="button" class="btn btn-warning pull-right"
                        ng-click="Download.triggerDownload('stateadmin/get/schools/download?selectedCycle='+List.year+'&application_status='+title)">
                        <span ng-if="!Download.inProcess"><i class="fa fa-download"></i> Download Excel</span>
						<span ng-if="Download.inProcess">Please wait..<i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        @include('page::app.tablelist-pagination')
        <div ng-if="List.ListService.results.length > 0">
            <div>
                <table class="table table-responsive custom-table">
                    <thead class="thead-cls">
                        <tr>
                            <th>Sl.no</th>
                            <th>नाम</th>
                            <th>U-डाइस</th>
                            <th>एक्शन</th>
                        </tr>
                    </thead>
                    <tr ng-repeat="school in List.ListService.results">
                        <td>[[$index+1]]</td>
                        <td>[[school.name]]</td>
                        <td>[[school.udise]]</td>
                        <td>
                            {{-- <button ng-disabled="inProcess"
                                ng-really-action="Delete"
                                ng-really-message="Do you want to delete this school?"
                                ng-really-click="create('stateadmin/school/delete/'+[[school.id]],  school, 'delete')"
                                class="btn btn-danger btn-xs city-action-btn">

                                <span ng-if="!inProcess" class="font-size-11 pos-rel"><i class="fa fa-trash-o"></i></span>
                                <span ng-if="inProcess" class="font-size-11 pos-rel"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>

                            <button class="btn btn-info btn-xs city-action-btn" ng-click="openPopup('stateadmin', 'school', 'update-school-admin-mobile', 'create-popup-style');helper.school_id=school.id">Update phone</button>
                             --}}

                            <a href="schools/[[school.id]]" class="btn btn-info btn-xs city-action-btn" target="_blank">View</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <p ng-if="List.ListService.results.length == 0">No Schools to display</p>
    </div>
</section>
@endsection

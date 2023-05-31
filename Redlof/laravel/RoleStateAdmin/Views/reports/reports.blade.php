@extends('stateadmin::includes.layout')
@section('content')
<section  class="stateadmin_dash"  ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-cloak>
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-10 col-xs-12">
					<div class="state-brief">

						<h2>
    						Reports
						</h2>
					</div>
				</div>
				<div class="col-sm-2 col-xs-12">
                    <div class="form-group" ng-controller="DownloadReportController as Download">
                        <button ng-disabled="Download.inProcess" type="button"
                            class="btn btn-warning pull-right" ng-click="Download.triggerDownload('stateadmin/reports/download')">
                            <span ng-if="!Download.inProcess"><i class="fa fa-download"></i>Download</span>
                            <span ng-if="Download.inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
			</div>
		</div>
	</div>

    <div class="container-fluid">

        <div class="row" ng-init="formData={}">
            <div class="col-md-8" ng-init="formData.acadamic_year='{{ date('Y') }}'">
                <div class="panel panel-default" ng-init="getAPIData('stateadmin/reports/session-year?year='+[[formData.acadamic_year]], 'currYearStats')">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-8">
                                <b> Registration and Allotment stats for the year - [[formData.acadamic_year]] </b>
                            </div>
                            <div class="col-md-4">
                                <div class="pull-right">
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                                ng-init="getAPIData('stateadmin/get/applicationcycle','admissionCycle')">
                                                [[formData.acadamic_year]] - [[ +formData.acadamic_year + 1 ]]
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li ng-repeat="cycle in admissionCycle">
                                                    <a href="#" ng-click="formData.acadamic_year=cycle.session_year;getAPIData('stateadmin/reports/session-year?year='+[[formData.acadamic_year]], 'currYearStats')">[[cycle.session_year]] - [[cycle.session_year+1]]</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" ng-if="!currYearStats">
                                <div class="alert alert-info">
                                    Please click on the fetch button to see the stats!
                                </div>
                            </div>
                            <div class="col-md-12" ng-if="currYearStats">
                                <table class="table table-borderless table-hover text-left">
                                    <thead>
                                        <tr>
                                            <td><b>Status</b></td>
                                            <td><b>Girls</b></td>
                                            <td><b>Boys</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Registered</td>
                                            <td>[[currYearStats.total_registered_girls]]</td>
                                            <td>[[currYearStats.total_registered_boys]]</td>
                                        </tr>
                                        <tr>
                                            <td>Total Allotted</td>
                                            <td>[[currYearStats.total_allotted_girls]]</td>
                                            <td>[[currYearStats.total_allotted_boys]]</td>
                                        </tr>
                                        <tr>
                                            <td>Total Enrolled</td>
                                            <td>[[currYearStats.total_enrolled_girls]]</td>
                                            <td>[[currYearStats.total_enrolled_boys]]</td>
                                        </tr>
                                        <tr>
                                            <td>Total Dismissed</td>
                                            <td>[[currYearStats.total_dismissed_girls]]</td>
                                            <td>[[currYearStats.total_dismissed_boys]]</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


</section>
@endsection

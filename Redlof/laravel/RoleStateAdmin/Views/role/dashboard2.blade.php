@extends('stateadmin::includes.layout')
@section('content')
<div class="state-single cm-content" ng-controller="AppController">
	<div class="container-fluid" ng-controller="DashboardController as Dashboard">
		<div class="container-fluid" ng-init="getAPIData('stateadmin/state/details/{{$state_id}}', 'state_details')">
			<div class="all-admin-link">
				<a class="btn btn-outline-blue no-margin" href="{{route('stateadmin.district.get')}}">
					<span ng-if="state_details.total_districts.total" ng-bind="state_details.total_districts.total"></span>
					<span ng-if="!state_details.total_districts.total">0</span>
					<i class="ion-ios-arrow-right arrow-icon"></i>Districts
				</a>
				<a class="btn btn-outline-blue" href="{{route('stateadmin.district.get')}}">
					<span ng-if="state_details.total_district_admins.total" ng-bind="state_details.total_district_admins.total"></span>
					<span ng-if="!state_details.total_district_admins.total" >0</span>
					<i class="ion-ios-arrow-right arrow-icon"></i>District Admins
				</a>
				<a  class="btn btn-outline-blue" href="{{route('stateadmin.nodal.nodal-admin', $state_slug)}}">
					<span ng-if="state_details.total_nodal_admins.total" ng-bind="state_details.total_nodal_admins.total"></span>
					<span ng-if="!state_details.total_nodal_admins.total" >0</span>
					<i class="ion-ios-arrow-right arrow-icon"></i>Nodal Admins
				</a>
				<a class="btn btn-outline-blue no-margin" href="{{route('stateadmin.school.getall')}}">
					<span ng-if="state_details.total_schools.total" ng-bind="state_details.total_schools.total"></span>
					<span ng-if="!state_details.total_schools.total">0</span>
					<i class="ion-ios-arrow-right arrow-icon"></i>Schools
				</a>
				<a class="btn btn-outline-blue" href="{{route('stateadmin.registeredstudents')}}">
					<span ng-if="state_details.total_students.total" ng-bind="state_details.total_students.total"></span>
					<span ng-if="!state_details.total_students.total" >0</span>
					<i class="ion-ios-arrow-right arrow-icon"></i>Students
				</a>
			</div>
		</div>
		<div class="school-info">
			<h4>OVERVIEW METRICES</h4>
			<br>
			<div class="col-sm-12 col-xs-12" ng-init="Dashboard.initAdmissionCycle();Dashboard.formData.selectedCycle='null';Dashboard.initDistricts();Dashboard.formData.selectedDistrict='null';Dashboard.initNodals(Dashboard.formData.selectedDistrict); Dashboard.formData.selectedNodal='null';Dashboard.formData.selectedSchool='null';Dashboard.formData.selectedSex='null';Dashboard.formData.selectedCategory='null';Dashboard.applyFilterOverviewMetrics('stateadmin/apply-filter/overview-metrics', Dashboard.formData);">
				<div class="all-admin-link pull-left">
					<form name="student-details" class="common-form add-area" ng-submit="Dashboard.applyFilterOverviewMetrics('stateadmin/apply-filter/overview-metrics', Dashboard.formData)" >
						<div class="form-inline">
							<div class="form-group" ng-init="">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									<select  class="form-control" ng-model="Dashboard.formData.selectedCycle" id="sel1">
										<option value="null">Admission Cycle</option>
										<option value="[[cycle.session_year]]" ng-repeat="cycle in Dashboard.admissionCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="dropdown">
									<select class="form-control" ng-change="Dashboard.initNodals(Dashboard.formData.selectedDistrict)" ng-model="Dashboard.formData.selectedDistrict" id="sel2">
										[[Dashboard.districts]]
										<option value="null">District</option>
										<option value="[[district.id]]" ng-repeat="district in Dashboard.districts">[[district.name]]</option>
									</select>
								</div>
							</div>
							<div class="form-group"  ng-init="">
								<select class="form-control" ng-model="Dashboard.formData.selectedNodal" id="sel3">
									<option value="null">Nodal</option>
									<option ng-repeat="nodal in Dashboard.nodals" value="[[nodal.id]]">[[nodal.user.first_name]]</option>
								</select>
							</div>
							<div class="form-group"  ng-init="Dashboard.initSchools(Dashboard.formData.selectedDistrict)">
								<select class="form-control" ng-model="Dashboard.formData.selectedSchool" id="sel3">
									<option value="null">School</option>
									<option ng-repeat="school in Dashboard.schools" value="[[school.id]]">[[school.name]]</option>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Apply filters</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection
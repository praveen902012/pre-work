@extends('schooladmin::includes.layout')
@section('content')
<section class="admin_dash"  ng-cloak ng-init="displaySuccessCard = true;" ng-controller="DashboardController as Dashboard">

	@if($school->application_status == 'applied')
		<div class="col-sm-12 col-xs-12">
			<div class="graph-card registered-student">
				<div class="heading-header">
					<h3>
					Complete your registration process
					</h3>
					To complete your registration process please fill out the fees details and seat information for classes.
				</div>
			</div>
		</div>
	@elseif($school->application_status == 'registered')
		<div class="col-sm-12 col-xs-12">
			<div class="graph-card registered-student">
				<div class="heading-header in-progress">
					<h3>
						The school verification is being processed right now.
					</h3>
					<p>
						Once registration is confirmed you will be notified via email and SMS to your registered email and mobile number.
					</p>
				</div>
			</div>
		</div>
	@elseif($school->application_status == 'verified')
		<div class="col-sm-12 col-xs-12" ng-show="displaySuccessCard">
			<div class="graph-card registered-student">
				@if($school_cycle)

					<div class="heading-header successful clearfixs row" style="display: flex;" ng-init="formData={};formData.school_id={{$school->id}}">
						<div class="col-md-10">
							<h3>
								Your registration has been successfully verified. <br>
								<small>You can update your school information by clicking update button</small>
							</h3>
						</div>

						@if($school_registration_on)
							<div class="col-md-2" style="margin: auto;">
								<button ng-disabled="Dashboard.inProcess" class="btn btn-primary" ng-really-action="Confirm" ng-really-message="Please do not Update the school, if you have already updated the data for 2023-24. If you edit the data again, your school will no longer be in verified state, It would be resent to block admin to Verify, Please confirm if you want to proceed." ng-really-click="Dashboard.editSchool('schooladmin/edit/previous/school', formData)">
									<p ng-if="!Dashboard.inProcess" style="color: white">Update</p>
									<p ng-if="Dashboard.inProcess" style="color: white">Please wait <i class="fa fa-spinner fa-spin"></i></p>
								</button>
							</div>
						@endif

					</div>

				@endif
			</div>
		</div>
		<div class="cm-content dash_content">
			<div class="dashboard_container">
				<div class="row state-single">
					<div class="col-sm-12 col-xs-12 " ng-init="Dashboard.initAdmissionCycle();Dashboard.formData.selectedCycle='{{$current_cycle}}';Dashboard.formData.selectedSex='null';Dashboard.formData.selectedCategory='null';Dashboard.applySchoolFilter('schooladmin/apply-filter/school-details', Dashboard.formData);">
						<div>
							<h4>INFORMATION</h4>
							<form name="student-details" class="common-form add-area" ng-submit="Dashboard.applySchoolFilter('schooladmin/apply-filter/school-details', Dashboard.formData)" >
								<div class="form-inline d_board_form">
									<div class="form-group">
										<div class="input-group">
											<select  class="form-control" ng-model="Dashboard.formData.selectedCycle" id="sel1">
												<option value="null">Admission Cycle</option>
												<option value="[[cycle.session_year]]" ng-repeat="cycle in Dashboard.admissionCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="dropdown">
											<select class="form-control" ng-model="Dashboard.formData.selectedSex" id="sel3">
												<option value="null">Sex</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
												<option value="transgender">Transgender</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<select class="form-control" ng-model="Dashboard.formData.selectedCategory" id="sel3" ng-init="Dashboard.category = [{value: 'sc', name: 'SC' }, {value: 'st', name: 'ST' }, {value: 'obc', name: ' OBC NCL (Income less than 4.5L)' }, {value: 'orphan', name: 'Orphan'}, {value: 'with_hiv', name: 'Child or Parent is HIV +ve'},
											{value: 'single_women', name: 'Widow or Divorced women with income less than INR 80,000'},{value: 'kodh', name: 'Kodh with income less than 4.5L' },{value: 'disable', name: 'Child or Parent is Differently Abled'}]">
											<option value="null">Category</option>
											<option ng-repeat="item in Dashboard.category" value="[[item.value]]">[[item.name]]</option>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-theme">Apply filters</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div ng-cloak>
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<p>Applications</p>
							<div class="row">
								<div class="col-sm-3 col-xs-12">
									<div class="totl_count_card">
										<h1>[[Dashboard.schoolFilteredData.total_unique_applications]]</h1>
										<p>Total Unique Students Applied</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="chart_card">
										<div class="header">
											<h6>Total unique admissions based on preferences</h6>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-6 col-xs-12">
													<div class="chart_card">
														<div class="header">
															<h6>Nearby Preferences</h6>
														</div>
														<div class="panel-body">
															<table class="text-center table table-bordered table-hover">
																<tbody>
																	<tr>
																		<td><b>Preferences</b></td>
																		<td><b>Applications</b></td>
																	</tr>
																</tbody>
																<tbody>
																	<tr ng-repeat="preferences in Dashboard.schoolFilteredData.nearby_preferences | limitTo : 4">
																		<td>[[preferences.pos]]</td>
																		<td>[[preferences.applications]]</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<div class="col-sm-6 col-xs-12">
													<div class="chart_card">
														<div class="header">
															<h6>Neighboring Preferences</h6>
														</div>
														<div class="panel-body">
															<table class="text-center table table-bordered table-hover">
																<tbody>
																	<tr>
																		<td><b>Preferences</b></td>
																		<td><b>Applications</b></td>
																	</tr>
																</tbody>
																<tbody>
																	<tr ng-repeat="neighbour_preferences in Dashboard.schoolFilteredData.neighboring_preferences | limitTo : 4">
																		<td>[[neighbour_preferences.pos]]</td>
																		<td>[[neighbour_preferences.applications]]</td>
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
							</div>
							<p>Seats and Admissions</p>
							<div class="row">
								<div class="col-sm-4 col-xs-12">
									<div class="totl_count_card">
										<h1>[[Dashboard.schoolFilteredData.total_seats]]</h1>
										<p>Overall Available Seats</p>
									</div>
								</div>
								<div class="col-sm-4 col-xs-12">
									<div class="totl_count_card  no-border">
										<h1>[[Dashboard.schoolFilteredData.total_admissions]]</h1>
										<p>Total Students Admitted(enrolled)</p>
									</div>
								</div>
							</div>
							<div class="row">
							<div class="col-sm-6">
								<div class="chart_card">
									<div class="header">
										<h6>
										Top reasons for Provisional admission(rejection)
										</h6>
									</div>
									<div id="rejectionGraph" class="custom_piechart_canvas">
									</div>
									<div class="footer_chart">
										<p ng-if="Dashboard.schoolFilteredData.show_reason==true">
											<span>
												<strong>
												[[ Dashboard.schoolFilteredData.top_reasons_for_provisional_admission.false_document[0][1] ]]%
												</strong>
												False Document
											</span>
											<span>
												<strong class="txt-purple">[[ Dashboard.schoolFilteredData.top_reasons_for_provisional_admission.did_not_report[0][1] ]]%</strong>
											Did Not Report </span>

											<span>
												<strong class="txt-purple">[[ Dashboard.schoolFilteredData.top_reasons_for_provisional_admission.no_document[0][1] ]]%</strong>
											No document </span>
										</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
									<div class="chart_card">
										<div class="header">
											<h6>Percentage of fill rate</h6>
										</div>
										<div id="studentFill" class="custom_barchart_canvas">

										</div>
										<div class="footer_chart">
											<p ng-if="Dashboard.schoolFilteredData.percentage_of_fill_rate.show==true">
												<span><strong> [[ Dashboard.schoolFilteredData.percentage_of_fill_rate.total_enrollment
												]]</strong>Enrollment</span>
												<span><strong class="txt-purple">[[ Dashboard.schoolFilteredData.percentage_of_fill_rate.total_applications ]]</strong>Total Application</span>
											</p>
										</div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@elseif($school->application_status == 'rejected')
		<div class="col-sm-12 col-xs-12">
			<div class="graph-card registered-student">
				<div class="heading-header rejected">
					<h3>
					Your registration has been rejected.
					</h3>
					<p>
						Nodal admin has rejected your application
					</p>
				</div>
			</div>
		</div>
	@elseif($school->application_status == 'recheck')
		<div class="col-sm-12 col-xs-12">
			<div class="graph-card registered-student">
				<div class="heading-header rejected">
					<h3>
					Your registration has been requested for recheck.
					</h3>
					<p>
						Nodal admin has requested you to recheck your application, edit your changes.
					</p><br>
					@if($school->recheck_reason)
					<h4><b>Reason: </b>{{$school->recheck_reason}}</h4><br>
					@endif
					<a href="{{route('schooladmin.edit-school')}}" class="btn-theme btn-blue" >Edit details</a>
				</div>
			</div>
		</div>
	@endif

</section>
@endsection

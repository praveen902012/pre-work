@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="StudentController as Student">
		<div ng-controller="ListController as List">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="all-admin-link">
						<a href="{{route('schooladmin.students')}}">
							<button class="btn btn-default">All Students</button>
						</a>
						<a href="{{route('schooladmin.allotted-students')}}">
							<button class="btn btn-default">Allotted Students</button>
						</a>
						<a href="">
							<button class="btn btn-primary">Enrolled Students</button>
						</a>
						<a href="{{route('schooladmin.rejected-students')}}">
							<button class="btn btn-default">Rejected Students</button>
						</a>
						<a href="{{route('schooladmin.dropout-students')}}">
							<button class="btn btn-default">Dropout Students</button>
						</a>
						<div class="rt-action  pull-right">
							<div class="form-inline filter_by">
								<strong>Filter by:</strong>
								<div class="form-group" ng-init="Student.initClass()">
									<div class="input-group">
										<select  class="form-control" ng-model="Student.selectedClass" id="sel1"  ng-init="Student.selectedClass='null'">
											<option value="null">Select Class</option>
											<option value="[[class.id]]" ng-repeat="class in Student.classData">[[class.level]]</option>
										</select>
									</div>
								</div>
								<div class="form-group" ng-init="Student.initAdmissionCycle()">
									<div class="input-group">
										<select  class="form-control" ng-model="Student.selectedCycle" id="sel2"  ng-init="Student.selectedCycle='null'">
											<option value="null">Admission Cycle</option>
											<option value="[[cycle.session_year]]" ng-repeat="cycle in Student.admissionCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<button ng-click="List.init('student-list', {'getall': 'schooladmin/get/enrolled-students/ac/'+[[Student.selectedCycle]]+'/class/'+[[Student.selectedClass]], 'search': 'schooladmin/search/enrolled-students/ac/'+[[Student.selectedCycle]]+'/class/'+[[Student.selectedClass]]})" class="btn btn-theme">Apply Filter</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div ng-init="List.init('student-list', {'getall': 'schooladmin/get/enrolled-students/ac/'+[[Student.selectedCycle]]+'/class/'+[[Student.selectedClass]], 'search': 'schooladmin/search/enrolled-students/ac/'+[[Student.selectedCycle]]+'/class/'+[[Student.selectedClass]]})" ng-cloak>
				<div class="row">
					<div class="col-sm-9 col-xs-9">
						<div class="search-action clearfix">
							<form class="">
								<div class="form-group">
									<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
								</div>
								<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">Search</button>
							</form>
						</div>
					</div>
					<div class="col-sm-2 col-xs-2" ng-controller="DownloadReportController as Download">
						<div class="form-group">
							<button ng-if="List.ListService.results.length > 0" type="button" class="btn btn-warning"
								ng-click="Download.triggerDownload('schooladmin/enrolled-students/cycle/'+[[Student.selectedCycle]]+'/class/'+[[Student.selectedClass]]+'/download')"><i
									class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</button>
						</div>
					</div>
				</div>
				<div ng-if="List.ListService.results.length > 0" class="mrt-20">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<table class="table table-responsive custom-table">
								<thead class="thead-cls">
									<tr>
										<th>ID</th>
										<th>Student Name</th>
										<th>Dob</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tr ng-repeat="student in List.ListService.results">
									<td>[[student.basic_details.registration_no]]</td>
									<td><a ng-href="student-details/[[student.basic_details.id]]">[[student.basic_details.first_name]]</a></td>
									<td>[[student.basic_details.dob | date:'mediumDate']]</td>
									<td>[[student.fmt_status]]</td>
									<td>
										<button href="" class="btn btn-primary bt" ng-really-action="Un-enroll" ng-really-message="Do you want to un-enroll this student?" ng-really-click="create('schooladmin/student/un-enroll/'+[[student.basic_details.id]])" >
											Didn't turn up
										</button>
									</td>
								</tr>
							</table>

							<div class="t-footer">
								<div class="row">
									<div class="col-sm-6 col-xs-6">
										<p>
											Showing [[List.ListService.currentPage]] of [[List.ListService.totalPage]] pages.
										</p>
									</div>
									<div class="col-sm-6 col-xs-6">
										<div class="prev-next pagination-custom tb-pagination pull-right">
											<table class="table">
												<td class="no-border">
													<ul class="list-unstyled list-inline text-left" ng-class="{ 'hide-pagination': !List.ListService.pagination }">
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
				</div>
				<div class="row">
					<div  class="col-sm-12 col-xs-12">
						<p ng-if="List.ListService.results.length == 0">No Students to display</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
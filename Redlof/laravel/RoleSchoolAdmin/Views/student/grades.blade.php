@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div ng-controller="StudentController as Student" class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="all-admin-link">
					<h2>Grades</h2>
					<p>Please select the class and start adding students' attendance</p>
				</div>
			</div>
			<div ng-controller="ListController as List"  ng-cloak>
				<div >
					<div class="col-sm-12 col-xs-12">
						<div class="search-action clearfix">
							<form class="search-action clearfix">
								<div class="row">
										<div class="form-group">
											<div class="dropdown" ng-init="Student.initClass()">
												<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Select Class
													<span class="caret"></span></button>
													<ul class="dropdown-menu">
														<li ng-repeat="class in Student.classData">
															<a href="" ng-click="Student.selectedClass=class.id;List.init('student-list', {'getall': 'schooladmin/get/students/'+Student.selectedClass,'search': 'nodaladmin/schools/search-registered'})" >[[class.level]]</a>
														</li>
													</ul>
												</div>
										</div>
											<div class="form-group">
												<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
										</div>
										<div class="form-group">
											<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">Search Student</button>
											</div>
									</div>



								</form>
							</div>
						</div>
						<div ng-if="List.ListService.results.length > 0">
							<table class="table table-responsive custom-table">
								<thead class="thead-cls">
									<tr>
										<th>ID</th>
										<th>Student Name</th>
										<th>Class</th>
										<th>Dob</th>
										<th>Action</th>
									</tr>
								</thead>
								<tr ng-repeat="student in List.ListService.results">
									<td>[[student.registration_no]]</td>
									<td><a ng-href="student-details/[[student.id]]">[[student.first_name]]</a></td>
									<td>[[student.level.level]]</td>
									<td>[[student.dob | date:'mediumDate']]</td>
									<td><a ng-href="/schooladmin/[[student.id]]/add-grade">Add grades ></a></td>
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
					<div class="row">
						<div  class="col-sm-12 col-xs-12">
							<p ng-if="List.ListService.results.length == 0">No Students to display</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endsection
@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="all-admin-link">
					School Admin | Subjects
					<div class="rt-action  pull-right">
						<button class="btn-theme btn-blue" ng-click="openPopup('schooladmin', 'student', 'subject', 'create-popup-style')">
						Add Subject
						</button>
					</div>
				</div>
			</div>
			<div ng-controller="ListController as List" ng-init="List.init('subject-list', {'getall': 'schooladmin/get/subjects','search': 'nodaladmin/schools/search-registered'})" ng-cloak>
				<div>
					<div class="col-sm-12 col-xs-12">
						<div class="search-action clearfix">
							<form class="">
								<div class="form-group">
									<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
								</div>
								<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">Search</button>
							</form>
						</div>
					</div>
					<div ng-if="List.ListService.results.length > 0">
						<table class="table table-responsive custom-table">
							<thead class="thead-cls">
								<tr>
									<th>Sl.no</th>
									<th>Class</th>
									<th>Subject Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tr ng-repeat="subject in List.ListService.results">
								<td>[[$index+1]]</td>
								<td>[[subject.level.level]]</td>
								<td>[[subject.subject.name]]</td>
								<td>
									<button ng-really-action="Delete" ng-really-message="Do you want to delete this subject?" ng-really-click="create('schooladmin/subject/delete/'+[[subject.subject.id]],  subject, 'delete')" class="btn btn-danger btn-xs city-action-btn">Delete</button>
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
				<div class="row">
					<div align="center" class="col-sm-12 col-xs-12">
						<p ng-if="List.ListService.results.length == 0">No subjects to display</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection
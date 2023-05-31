@include('state::includes.head')
@include('state::includes.header')
<section class="header-secondary">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<ul class="list-unstyled list-inline">
						<li>
							<a href="{{route('state', $state->slug)}}">
								<i class="fa fa-home home" aria-hidden="true"></i>
								Home
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="{{route('state.general.information', $state->slug)}}">
								General Information
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="{{route('state.student.general.information', $state->slug)}}">
								Student General Information
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="{{route('state.student.general.information.registered', $state->slug)}}">
								{{$title}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="page-height section-spacing cm-content bg-grey">
	<div class="container" ng-controller="AppController" ng-init="getAPIData('{{$state->id}}/applicationcycle/get', 'applicationCycle');selectedCycle='{{$current_cycle}}'">
		<div class="rte-container"  ng-controller="ListController as List" ng-init="List.init('student-list', {'getall': '{{$state->id}}/general-information/students/enrolled/'+[[selectedCycle]], 'search':'{{$state->id}}/general-information/students/enrolled/'+[[selectedCycle]]+'/search'})">
			<div class="row">
				<div class="col-sm-7 col-xs-12">
					<div class="heading-strip">
						<h2>
						Enrolled Students
						<span class="info-icon">
							<i class="fa fa-info-circle" aria-hidden="true" uib-tooltip="List of enrolled students" tooltip-class="ttc-verified" tooltip-placement="right"></i>
						</span>
						</h2>
					</div>
				</div>
				<div class="col-sm-5 col-xs-12">
					<div class="pull-right">
						<div class="select-option">
							<i class="fa fa-calendar-o icon" aria-hidden="true"></i>
							<select class="form-control" ng-model="selectedCycle" id="applicationcycle" name="applicationcycle" ng-click="List.init('student-list', {'getall': '{{$state->id}}/general-information/students/enrolled/'+[[selectedCycle]], 'search':'{{$state->id}}/general-information/students/enrolled/'+[[selectedCycle]]+'/search'})" >
												<option value="null">Admission Cycle</option>
												<option value="[[cycle.session_year]]" ng-repeat="cycle in applicationCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
											</select>
						</div>
					</div>
				</div>
			</div>
			<div ng-cloak>
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
						<table class="table table-responsive custom-table table-bordered">
							<thead class="thead-cls">
								<tr>
									<th>ID</th>
									<th>Student Name</th>
								</tr>
							</thead>
							<tr ng-repeat="student in List.ListService.results">
								<td>[[student.registration_no]]</td>
								<td>[[student.first_name]]</td>
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
					<div class="row">
			<div align="center" class="col-sm-12 col-xs-12">
				<p ng-if="List.ListService.results.length == 0">No Students to display</p>
			</div>
		</div>
				</div>

			</div>
		</div>
	</div>
</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
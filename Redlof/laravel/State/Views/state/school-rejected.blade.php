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
							<a href="{{route('state.school.general.information.registered', $state->slug)}}">
								{{$title}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="page-height section-spacing cm-content bg-grey" ng-controller="AppController" ng-init="getAPIData('{{$state->id}}/applicationcycle/get', 'applicationCycle');selectedCycle='{{$current_cycle}}'">
	<div class="container" ng-controller="ListController as List" ng-cloak ng-init="List.init('school-list', {'getall': '{{$state->slug}}/get/schools/rejected/'+[[selectedCycle]], 'search': '{{$state->slug}}/schools/rejected/'+[[selectedCycle]]+'/search'})">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-7 col-xs-12">
					<div class="heading-strip">
						<h2>
						Rejected Schools
						<span class="info-icon">
							<i class="fa fa-info-circle" aria-hidden="true" uib-tooltip="List of rejected schools" tooltip-class="ttc-verified" tooltip-placement="right"></i>
						</span>
						</h2>
					</div>
				</div>
				<div class="col-sm-5 col-xs-12">
					<div class="pull-right">
						<div class="select-option">
							<i class="fa fa-calendar-o icon" aria-hidden="true"></i>
							<select class="form-control" ng-model="selectedCycle" id="applicationcycle" name="applicationcycle" ng-click="List.init('school-list', {'getall': '{{$state->slug}}/get/schools/rejected/'+[[selectedCycle]], 'search': '{{$state->slug}}/schools/rejected/'+[[selectedCycle]]+'/search'})">
								<option value="null">Admission Cycle</option>
								<option value="[[cycle.session_year]]" ng-repeat="cycle in applicationCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
							</select>
						</div>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="search-action clearfix">
						<form class="">
							<div class="form-group">
								<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or UDISE" table-list-search="[[List.ListName]]">
							</div>
							<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">Search</button>
						</form>
					</div>
				</div>
			</div>
			<div ng-if="List.ListService.results.length > 0">
				<div class="tb-container">
					<div class="table-responsive bg-wht">
						<div class="rte-table"  style="border: 0;">
							<table class="table">
								<thead class="">
									<tr>
										<th class="">S.No.</th>
										<th class="">UDISE Code</th>
										<th class="">School Name</th>
										<th class="">Address</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="school in List.ListService.results">
										<td class="">[[$index+1]]</td>
										<td class="">[[school.udise]]</td>
										<td class="">[[school.name]]</td>
										<td class="">[[school.address]]</td>
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
						<p ng-if="List.ListService.results.length == 0">No Schools to display</p>
					</div>
				</div>
			</div>
		</section>
		@include('state::includes.footer')
		@include('state::includes.foot')
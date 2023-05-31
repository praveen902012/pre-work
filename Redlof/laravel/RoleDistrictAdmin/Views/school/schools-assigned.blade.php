@extends('districtadmin::includes.layout')
@section('content')
<section class="districtadmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-init="List.cycle ='Admission Cycle';List.year=null">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip">
					<h2>
						Assigned Schools
					</h2>
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="all-admin-link pull-right">
					<span class="form-group">
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    [[List.cycle]]
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1"  id="addmission-cyle-dropdown">
						  	@foreach($years as $year)
                                <li>
                                    <a href="#"
                                        ng-click="List.year={{$year}};List.cycle='{{$year}} - {{$year+1}}'; List.init('student-list', {'getall': 'districtadmin/get/schools/assigned/{{$district->id}}?selectedCycle={{$year}}','search': 'districtadmin/search/schools/assigned/{{$district->id}}?selectedCycle={{$year}}'})">
                                        {{$year}} - {{$year+1}}
                                    </a>
                                </li>
                            @endforeach
						  </ul>
						</div>
					</span>
					<a href="{{route('schools.all')}}" class="btn btn-blue-outline">
						All Schools
					</a>
					<a href="{{route('schools.registered')}}" class="btn btn-blue-outline">
						Registered Schools
					</a>
					<a href="" class="btn btn-blue">
						Assigned Schools
					</a>
					<a href="{{route('schools.verified')}}" class="btn btn-blue-outline">
						Verified Schools
					</a>
					<a href="{{route('schools.rejected')}}" class="btn btn-blue-outline">
						Rejected Schools
					</a>
					<a href="{{route('schools.banned')}}" class="btn btn-blue-outline">
						Banned Schools
					</a>
				</div>
			</div>
		</div>
		<div ng-cloak ng-init="List.init('school-list', {'getall': 'districtadmin/get/schools/assigned/{{$district->id}}','search': 'districtadmin/search/schools/assigned/{{$district->id}}'}); latest_session_year={{$latest_application_cycle->session_year}}">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="search-action clearfix">
						<form class="">
							<div class="form-group">
								<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or UDISE" table-list-search="[[List.ListName]]">
							</div>
							<button ng-disabled="List.appTableService.inProcess" class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">
								<span ng-if="!List.appTableService.inProcess">खोज</span>
								<span ng-if="List.appTableService.inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
						</form>
					</div>
				</div>
				<div class="col-sm-5 col-xs-12">
				</div>
			</div>
			<div ng-if="List.ListService.results.length > 0">
				<table class="table table-responsive custom-table">
					<thead class="thead-cls">
						<tr>
							<th>Sl.no</th>
							<th>नाम</th>
							<th>U-डाइस</th>
							<th>एक्शन</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="school in List.ListService.results">
							<td>[[$index+1]]</td>
							<td>[[school.name]]</td>
							<td>[[school.udise]]</td>
							<td>
								<button ng-if="latest_session_year==school.session_year" class="btn-theme btn-sm" ng-click="helper.school_id=school.id;helper.district_id={{$district->id}};openPopup('districtadmin', 'school', 're-assign-school', 'create-popup-style')">
								Re-Assign
								</button>
							</td>
						</tr>
					</tbody>
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
					<p ng-if="List.ListService.results.length == 0">No Schools to display</p>
				</div>
			</div>
		</div>
	</div>
</section>

{{-- 
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
    setTimeout(function(){
        $('#addmission-cyle-dropdown :first-child').trigger('click');
     }, 2000);
});
</script> --}}

@endsection
@extends('admin::includes.layout')
@section('content')
<div class="state-single cm-content" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="getAPIData('admin/state/details/{{$state->id}}', 'state_details')">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<a ng-href="{{ route('admin.state.single', $state->slug) }}">
							<img src="{{$state->fmt_logo}}" height="50" alt="{{$state->name}}">
						</a>
						<h2>
						{{ $state->name }} - {{ $title }}
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<button class="btn-theme btn-blue pull-right" ng-click="helper.state_id={{$state->id}};openPopup('admin', 'state', 'update-state', 'create-popup-style')">Update Info</button>
				</div>
			</div>
		</div>
		<div class="all-admin-link">
			<a class="btn btn-outline-blue" href="{{route('admin.state.state-admin', $state->slug)}}">
				<span ng-if="state_details.total_state_admins.total" ng-bind="state_details.total_state_admins.total"></span>
				<span ng-if="!state_details.total_state_admins.total" >0</span>
				<i class="ion-ios-arrow-right arrow-icon"></i>State Admins
			</a>
			<a class="btn btn-outline-blue" href="{{route('admin.single.district-admin', $state->slug)}}">
				<span ng-if="state_details.total_district_admins.total" ng-bind="state_details.total_district_admins.total"></span>
				<span ng-if="!state_details.total_district_admins.total" >0</span>
				<i class="ion-ios-arrow-right arrow-icon"></i>District Admins
			</a>
			<a  class="btn btn-outline-blue" href="{{route('admin.nodal.nodal-admin-districts', $state->slug)}}">
				<span ng-if="state_details.total_nodal_admins.total" ng-bind="state_details.total_nodal_admins.total"></span>
				<span ng-if="!state_details.total_nodal_admins.total" >0</span>
				<i class="ion-ios-arrow-right arrow-icon"></i>Nodal Admins
			</a>
			<a class="btn btn-outline-blue no-margin" href="{{route('admin.school.get', $state->slug)}}">
				<span ng-if="state_details.total_schools.total" ng-bind="state_details.total_schools.total"></span>
				<span ng-if="!state_details.total_schools.total">0</span>
				<i class="ion-ios-arrow-right arrow-icon"></i>Schools
			</a>
			<a class="btn btn-outline-blue no-margin" href="{{route('admin.students.allotted', $state->slug)}}">
				<span ng-if="state_details.total_students.total" ng-bind="state_details.total_students.total"></span>
				<span ng-if="!state_details.total_students.total">0</span>
				<i class="ion-ios-arrow-right arrow-icon"></i>Students
			</a>
		<!-- 	<button ng-really-action="Delete" ng-really-message="Do you want to delete this state?" ng-really-click="create('admin/state/delete/{{$state->id}}',  state, 'delete')" class="btn btn-danger btn-xs city-action-btn"><i class="fa fa-trash-o"></i></button> -->
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Heatmap - School density per district
						</h4>
					</div>
					<div class="bg-wht">
						<img src="https://uc.uxpin.com/files/91911/99228/uxpmod_4507936d646830f470ffec2525bdd765_78026988_geographic-heat-map-of-financial-investment-in-technology-companies-in-india-and-china-2010-11-c2a9-2011-quid-inc-1.jpg" class="img-responsive" alt="name">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Overall State Statistics
						</h4>
					</div>
					<div class="card-content bg-wht">
						<div class="state-statistics">
							<span>
								<i class="fa icon fa-user-circle-o" aria-hidden="true"></i>
							</span>
							<h2>
							[[state_details.total_students.total]]
							</h2>
							<p>
								Total student registrations for 2019-2020
							</p>
						</div>
						<div class="state-statistics">
							<span>
								<i class="fa icon fa-building-o" aria-hidden="true"></i>
							</span>
							<h2>
							[[state_details.total_schools.total]]
							</h2>
							<p>
								Total school registrations
							</p>
						</div>
						<div class="state-statistics">
							<span>
								<i class="fa fa-user-o icon" aria-hidden="true"></i>
							</span>
							<h2>
							[[state_details.total_nodal_admins.total]]
							</h2>
							<p>
								Total registered nodal admins
							</p>
						</div>
						<div class="state-statistics">
							<span>
								<i class="fa icon fa-money" aria-hidden="true"></i>
							</span>
							<h2>
							Rs. 4,25,22,324
							</h2>
							<p>
								Total reimbursement due
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Top 5 districts with most school registrations
						</h4>
					</div>
					<div class="bg-wht graph-img">
						<img src="https://uc.uxpin.com/files/91911/99228/figure_barchar.png" class="img-responsive" alt="name">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Top 5 districts with most student registrations
						</h4>
					</div>
					<div class="bg-wht  graph-img">
						<img src="https://uc.uxpin.com/files/91911/99228/figure_barchar.png" class="img-responsive" alt="name">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Top 5 districts with most school registrations
						</h4>
					</div>
					<div class="card-content bg-wht">
						<div class="top-list">
							<img src="{!! asset('img/form-loading.gif') !!}" class="img-responsive" alt="name">
							<h3>
							Arjun Dhyanyal
							</h3>
							<p>
								from Ujjain, manages 15 schools
							</p>
							<a href="">
								View
							</a>
						</div>
						<div class="top-list">
							<img src="{!! asset('img/form-loading.gif') !!}" class="img-responsive" alt="name">
							<h3>
							Arjun Dhyanyal
							</h3>
							<p>
								from Ujjain, manages 15 schools
							</p>
							<a href="">
								View
							</a>
						</div>
						<div class="top-list">
							<img src="{!! asset('img/form-loading.gif') !!}" class="img-responsive" alt="name">
							<h3>
							Arjun Dhyanyal
							</h3>
							<p>
								from Ujjain, manages 15 schools
							</p>
							<a href="">
								View
							</a>
						</div>
						<div class="top-list">
							<img src="{!! asset('img/form-loading.gif') !!}" class="img-responsive" alt="name">
							<h3>
							Arjun Dhyanyal
							</h3>
							<p>
								from Ujjain, manages 15 schools
							</p>
							<a href="">
								View
							</a>
						</div>
						<div class="top-list">
							<img src="{!! asset('img/form-loading.gif') !!}" class="img-responsive" alt="name">
							<h3>
							Arjun Dhyanyal
							</h3>
							<p>
								from Ujjain, manages 15 schools
							</p>
							<a href="">
								View
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="hm-card graph-card registered-student">
					<div class="heading-header">
						<h4 class="text-center">
						Top 5 districts with most student registrations
						</h4>
					</div>
					<div class="card-content bg-wht graph-content">
						<img src="https://uc.uxpin.com/files/91911/99228/Graphs-and-Chatrs-Pie-Chart-Europe-Browser-Usage-Share-1.png" class="img-responsive" alt="name">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="hm-card graph-card">
					<div class="heading-header">
						<h4 class="text-center">
						EWS vs DG Percentage distribution of registered students
						</h4>
					</div>
					<div class="card-content bg-wht  registered-student">
						<div class="row">
							<div class="col-sm-7 col-xs-12">
								<div class="lt-graph ">
									<img src="https://uc.uxpin.com/files/91911/99228/screenshot-bl.ocks.org-2017-12-01-16-26-19-603.png" class="img-responsive center-block" alt="name">
								</div>

							</div>
							<div class="col-sm-5 col-xs-12">
								<div class="rt-percent">
									<div class="distribution-card">
										<h2>
										55%
										</h2>
										<p>
											Economically Weaker Section (EWS)
										</p>
									</div>
									<div class="distribution-card">
										<h2 class="purple">
										45%
										</h2>
										<p>
											Disadvanted Group (DG)
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
@endsection
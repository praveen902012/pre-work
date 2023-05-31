@extends('admin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid"  ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'admin/nodal/{{$district->id}}','search': 'admin/nodal/search/{{$district->id}}'})">
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
					<div class="rt-action pull-right">
						<a class="btn-theme btn-blue" href="{{ route('admin.state.single', $state->slug) }}">
							{{ $state->name }}
						</a>
						<a class="btn-theme btn-blue" href="{{ route('admin.nodal.deactivated-nodal-admin', $district->id) }}">
							Deactivated Nodals
						</a>
						<button class="btn-theme btn-blue" ng-click="helper.state_id={{$state->id}};helper.state_slug='{{$state->slug}}';helper.district_id='{{$district->id}}';openPopup('admin', 'state', 'add-nodal-admin', 'create-popup-style')">
						Add Nodal Admin
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				@include('page::app.pagination')
				<table ng-if="List.ListService.results.length > 0" class="table table-responsive custom-table">
					<thead class="thead-cls">
						<tr>
							<th>Sl.no</th>
							<th>User</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="statenodal in List.ListService.results" ng-cloak>
							<td>[[$index+1]]</td>
							<td>[[statenodal.user.first_name]]</td>
							<td>
									<button class="btn-brief" dynamic-content="[[ 'admin/nodaladmin/brief/'+statenodal.id ]]" dynamic-content-url="true">
									Brief
									</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="">
					<div class="dynamic-content-container">
					</div>
				</div>
			</div>
		</div>
		<p ng-if="List.ListService.results.length == 0">No Nodal Admin to display</p>
	</div>
</div>
</section>
@endsection
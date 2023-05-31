@extends('admin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('stateadmin-list', {'getall': 'admin/deactivated-stateadmin/{{$state->id}}','search': 'admin/stateadmin/search/{{$state->id}}'})">
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
					<div class="rt-action  pull-right">
						<a class="btn-theme btn-blue mrgn-rt10" href="{{ route('admin.state.single', $state->slug) }}">
						{{ $state->name }}
						</a>
						<a class="btn-theme btn-blue mrgn-rt10" href="{{ route('admin.state.state-admin', $state->slug) }}">
						Active Admins
						</a>
						<button class="btn-theme btn-blue" ng-click="helper.state_id='{{$state->id}}';helper.state_slug='{{$state->slug}}';openPopup('admin', 'state', 'add-stateadmin', 'create-popup-style')">
						Add State Admin
						</button>
					</div>
				</div>
			</div>
		</div>
		<div ng-if="List.ListService.results.length > 0" ng-cloak>
			<div class="row">
				<div class="col-sm-6 col-xs-6">
					@include('page::app.pagination')
					<table class="table table-responsive custom-table" >
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="stateadmin in List.ListService.results">
								<td>[[$index+1]]</td>
								<td>[[stateadmin.user.first_name]]</td>
								<td>
									<button class="btn-brief" dynamic-content="[[ 'admin/stateadmin/brief/'+stateadmin.id ]]" dynamic-content-url="true">
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
		</div>
		<div ng-if="List.ListService.results.length == 0" ng-cloak>
			<div class="add-state-admin">
				<p>No admin has been mapped to this state yet</p>
			</div>
		</div>
	</div>
</div>
@endsection
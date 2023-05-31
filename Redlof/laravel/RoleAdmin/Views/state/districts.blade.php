@extends('admin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('district-list', {'getall': 'admin/districts/{{$state->id}}','search': 'admin/districts/search/{{$state->id}}', 'search':'admin/districts/search/{{$state->id}}'})">
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
						<button class="btn-theme btn-blue" ng-click="helper.state_id='{{$state->id}}';helper.state_slug='{{$state->slug}}';openPopup('admin', 'state', 'add-district', 'create-popup-style')">Add District</button>
					</div>

				</div>
			</div>
		</div>
		<div >
			<div class="row">
				<div class="col-sm-6 col-xs-6">
					@include('page::app.pagination')
					<table ng-if="List.ListService.results.length > 0" ng-cloak class="table table-responsive custom-table" >
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="district in List.ListService.results">

								<td>[[$index+1]]</td>
								<td>[[district.name]]</td>
								<td><button ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this district?" ng-really-click="create('admin/district/deactivate/'+[[district.id]],  district, 'deactivate')" class="btn btn-warning btn-xs city-action-btn"><i class="fa fa-ban"></i></button>
									<button class="btn-brief" dynamic-content="[[ 'admin/district/brief/'+district.id ]]" dynamic-content-url="true">
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
				<div ng-if="List.ListService.results.length == 0" ng-cloak>
					<div class="add-state-admin">
						<p>No districts has been mapped to this state</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
@extends('stateadmin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('district-list', {'getall': 'stateadmin/districts/{{$state_id}}','search': 'stateadmin/districts/{{$state_id}}/search'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<h2>
							{{ $title }} - {{ $state_slug }}
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="rt-action  pull-right">
						<button class="btn-theme btn-blue" ng-click="helper.state_id='{{$state_id}}';openPopup('stateadmin', 'district', 'add-district', 'create-popup-style')">Add District</button>
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
								<th>नाम</th>
								<th>एक्शन</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="district in List.ListService.results">

								<td>[[$index+1]]</td>
								<td>[[district.name]]</td>
								<td>
									<button ng-disabled="inProcess" ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this district?" ng-really-click="create('stateadmin/district/deactivate/'+[[district.id]],  district, 'deactivate')" class="btn btn-warning btn-xs city-action-btn">
										<span ng-if="!inProcess" class="font-size-11 pos-rel"><i class="fa fa-ban"></i></span>
										<span ng-if="inProcess" class="font-size-11 pos-rel"><i class="fa fa-spinner fa-spin"></i></span>
									</button>
									<button class="btn-brief" dynamic-content="[[ 'stateadmin/district/brief/'+district.id ]]" dynamic-content-url="true">
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
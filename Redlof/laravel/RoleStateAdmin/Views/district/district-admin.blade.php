@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('districtadmin-list', {'getall': 'stateadmin/districtadmin/{{$district->id}}'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<a ng-href="{{ route('admin.state.single', $state->slug) }}">
							<img src="{{$state->fmt_logo}}" height="50" alt="{{$state->name}}">
						</a>
						<h2>
						{{ $title }} - {{ $district->name }}
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="rt-action pull-right">
						<button class="btn-theme btn-blue" ng-click="helper.state_id={{$state->id}};helper.district_id='{{$district->id}}';openPopup('stateadmin', 'district', 'add-district-admin', 'create-popup-style')">
						Add District Admin
						</button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div>
				<div class="row" ng-if="List.ListService.results.length > 0">
					<div class="col-sm-6 col-xs-12">
						@include('page::app.pagination')
						<div >
							<table class="table table-responsive custom-table" >
								<thead class="thead-cls">
									<tr>
										<th>Sl.no</th>
										<th>Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="districtadmin in List.ListService.results">
										<td>[[$index+1]]</td>
										<td>[[districtadmin.user.first_name]]</td>
										<td>
											<button class="btn-brief" dynamic-content="[[ 'stateadmin/districtadmin/brief/'+districtadmin.id ]]" dynamic-content-url="true">
											Brief
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="">
							<div class="dynamic-content-container">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p ng-if="List.ListService.results.length == 0">No District Admin to display</p>
	</div>
</div>
</section>
@endsection
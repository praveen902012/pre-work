@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid"  ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'stateadmin/deactivated-nodal/{{$state_id}}', 'search':'stateadmin/deactivated-nodal/search/all'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<a ng-href="">
							<img src="" height="50" alt="">
						</a>
						<h2>
							Nodal Admin
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
				<div class="rt-action pull-right">
						<a class="btn-theme btn-sm" href="{{ route('stateadmin.nodal.nodal-admin', $state_id)}}">
							Active Nodal Admins
						</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-sm-6 col-xs-12">
				@include('page::app.tablelist-pagination')
				</div>
				</div>
		<div class="row" ng-if="List.ListService.results.length > 0">
			<div class="col-sm-6 col-xs-12">
				<!-- @include('page::app.pagination') -->
				<table class="table table-responsive custom-table">
					<thead class="thead-cls">
						<tr>
							<th>Sl.no</th>
							<th>User</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="districtnodal in List.ListService.results" ng-cloak>
							<td>[[$index+1]]</td>
							<td>[[districtnodal.user.first_name]]</td>
							<td>
									<button class="btn-brief" dynamic-content="[[ 'stateadmin/nodaladmin/brief/'+districtnodal.id ]]" dynamic-content-url="true">
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
		<div align="center" ng-if="List.ListService.results.length == 0">
				<p>No nodal admin to display</p>
				</div>
	</div>
</div>
</section>
@endsection
@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'stateadmin/nodal', 'search':'stateadmin/nodal/search/all'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">

						<h2>
							Nodal Admin
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="rt-action pull-right">
					<a class="btn-theme btn-sm" href="{{ route('stateadmin.nodal.deactivated-nodal-admin', $state_id) }}">
							Deactivated Nodal Admins
						</a>
						<button class="btn-theme btn-sm" ng-click="helper.state_id={{$state_id}};openPopup('stateadmin', 'nodal', 'add-nodal-admin', 'create-popup-style')">
							Add Nodal Admin
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				@include('page::app.tablelist-pagination')
			</div>
		</div>
		<div >
			<div class="row">
				<div  ng-if="List.ListService.results.length > 0" class="col-sm-6 col-xs-6">
					<table class="table table-responsive custom-table">
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>नाम</th>
								<th>एक्शन</th>
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
				<div align="center" ng-if="List.ListService.results.length == 0">
				<p>No nodal admin to display</p>
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
</div>
</section>
@endsection
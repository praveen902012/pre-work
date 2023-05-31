@extends('districtadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">

						<h2>
						Bulk upload
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					@if(!$nodal_requested)
					<div class="rt-action pull-right">
						@if(!$udise_added)
						<button class="btn-theme btn-sm" ng-really-action="Request" ng-really-message="Do you want to request the nodal admin's to upload udise?" ng-really-click="create('districtadmin/request/nodal/upload',  nodal, 'request')">
						Request Nodal Admin
						</button>
						@endif
						<button class="btn-theme btn-sm" ng-click="helper.district_id={{$district->id}};openPopup('districtadmin', 'nodal', 'upload-csv', 'create-popup-style')">
								सी एस वी को अपलोड करे 
						</button>
					</div>
					@endif
				</div>
			</div>
		</div>
		<div ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'districtadmin/nodaladmin/bulk/{{$district->id}}', 'search':'districtadmin/search/nodaladmin/bulk/{{$district->id}}'})">
			<div class="row">
				<div class="col-sm-12 col-xs-12" ng-if="List.ListService.results.length>0">
					@include('page::app.tablelist-pagination')
					<table class="table table-responsive custom-table">
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>ईमेल</th>
								<th>U-डाइस</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="districtnodal in List.ListService.results" ng-cloak>
								<td>[[$index+1]]</td>
								<td>[[districtnodal.email]]</td>
								<td>[[districtnodal.udise]]</td>
							</tr>
						</tbody>
					</table>
				</div>
				@if(!$nodal_requested)
				<div ng-if="List.ListService.results.length==0" class="col-sm-12 col-xs-12 text-center">
					<p>No entries added yet.</p>
				</div>
				@else

				<div class="col-sm-12 col-xs-12 text-center">
					<p>You have requested your nodal admin's to upload udise.</p>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
</section>
@endsection
@extends('nodaladmin::includes.layout')
@section('content')

<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<a ng-href="">
							<img src="" height="50" alt="">
						</a>
						<h2>
						Bulk upload
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">

					<div class="rt-action pull-right">
						<a class="btn btn-primary" ng-href="upload-udise">
						All Udise
						</a>

						<button class="btn-theme btn-sm" ng-click="openPopup('nodaladmin', 'role', 'upload-udise', 'create-popup-style')">
						Add Udise
						</button>
						<button class="btn-theme btn-sm" ng-click="openPopup('nodaladmin', 'role', 'udise-bulk', 'create-popup-style')">
						Upload CSV
						</button>
					</div>
				</div>
			</div>
		</div>
		<div ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'nodaladmin/get/udise/pending'})">
			<div class="row">

				<div class="col-sm-12 col-xs-12" ng-if="List.ListService.results.length>0">
					@include('page::app.tablelist-pagination')
					<h4>Pending Udise Numbers</h4><br>
					<table class="table table-bordered table-responsive custom-table">
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Email</th>
								<th>Udise</th>
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
				<div ng-if="List.ListService.results.length==0" class="col-sm-12 col-xs-12 text-center">
					<p>No pending udise.</p>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
@endsection
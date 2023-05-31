@extends('districtadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid"  ng-controller="ListController as List" ng-cloak ng-init="List.init('nodaladmin-list', {'getall': 'districtadmin/deactivated-nodal/{{$district->id}}'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">

						<h2>
								नोडल एडमिन
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
				<div class="rt-action pull-right">
						<a class="btn-theme btn-sm" href="{{ route('districtadmin.nodal.nodal-admin', $district->id)}}">
							Active Nodal Admins
						</a>
						</div>
					</div>
				</div>
			</div>
		<div class="row" ng-if="List.ListService.results.length > 0">
			<div class="col-sm-6 col-xs-12">
				@include('page::app.pagination')
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
									<button class="btn-brief" dynamic-content="[[ 'districtadmin/nodaladmin/brief/'+districtnodal.id ]]" dynamic-content-url="true">
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
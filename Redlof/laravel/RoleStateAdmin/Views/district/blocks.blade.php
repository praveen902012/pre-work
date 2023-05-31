@extends('stateadmin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('district-list', {'getall': 'stateadmin/districts/{{$district->id}}/blocks','search': 'stateadmin/districts/search/{{$state_id}}'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<h2>
						{{ $title }} {{ $district->name }}
						</h2>
					</div>
				</div>
			</div>
		</div>
		<div >
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					@include('page::app.pagination')
					<table ng-if="List.ListService.results.length > 0" ng-cloak class="table table-responsive custom-table" name="block_list" >
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Name</th>
								<th>Type</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="block in List.ListService.results">
								<td ng-init="block.drop[block.id] = false">[[$index+1]]</td>
								<td>[[block.name]]</td>
								<td ng-if="block.type && !block.drop[block.id] " ><span ng-if="block.type=='ward'">Ward</span><span ng-if="block.type=='panchayat'">Gram Panchayat</span></td>
								<td ng-if="!block.type && !block.drop[block.id]" >-</td>
								<td ng-if="block.drop[block.id]" >
									<select ng-model="block.new_type" class="form-control" id="type">
										<option value="ward">Ward</option>
										<option value="panchayat">Gram Panchayat</option>
									</select>
								</td>
								<td ng-if="!block.drop[block.id]">
									<button class="btn btn-primary"  ng-click="block.drop[block.id] = true;">
									Edit Type
									</button>
								</td>
								<td  ng-if="block.drop[block.id]">
									<button class="btn btn-success" ng-disabled="inProcess" ng-click="create('stateadmin/district/update/block/'+[[block.id]]+'/type/'+[[block.new_type]],  'block_list', 'refresh')">
										<span ng-if="!inProcess">Save</span>
										<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
									</button>
									<button class="btn btn-danger" ng-click="block.drop[block.id] = false;">
									Cancel
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
						<p>No blocks found</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
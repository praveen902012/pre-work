@extends('admin::includes.layout')
@section('content')
<section  class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('schools-list', {'getall': 'admin/schools/{{$state->id}}', 'search':'admin/schools/search/'})">
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
					<div class="rt-action pull-right">
					<a class="btn-theme btn-blue mrgn-rt10" href="{{ route('admin.state.single', $state->slug) }}">
						{{ $state->name }}
						</a>
						{{-- <a class="btn-theme btn-blue no-margin" href="{{ route('admin.school.add', $state->slug ) }}">
							Add Schools
						</a> --}}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-xs-12">
				@include('page::app.pagination')

				<table class="table table-responsive custom-table">
					<thead class="thead-cls">
						<tr>
							<th>Sl.no</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tr ng-repeat="school in List.ListService.results">
						<td>[[$index+1]]</td>
						<td class="admin-school-nm">[[school.name]]</td>
						<td><button ng-really-action="Delete" ng-really-message="Do you want to delete this school?" ng-really-click="create('admin/school/delete/'+[[school.id]],  school, 'delete')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
							<button class="btn-brief" dynamic-content="[[ 'admin/school/brief/'+school.id ]]" dynamic-content-url="true">
								Brief
							</button>
						</td>
					</tr>
				</table>
			</div>

			<div class="col-sm-6 col-xs-12">
				<div class="">
					<div class="dynamic-content-container">
					</div>
				</div>
			</div>
			<p ng-if="List.ListService.results.length == 0">No Schools to display</p>
		</div>
	</div>
</div>
</section>
@endsection
@extends('admin::includes.layout')
@section('content')
<section  class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('schools-list', {'getall': 'admin/students/{{$state->id}}', 'search':'admin/search/students/{{$state->id}}'})">
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
						</tr>
					</thead>
					<tr ng-repeat="student in List.ListService.results">
						<td>[[$index+1]]</td>
						<td class="admin-student-nm">[[student.first_name]]</td>
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
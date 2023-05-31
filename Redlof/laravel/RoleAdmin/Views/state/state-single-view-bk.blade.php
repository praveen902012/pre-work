@extends('admin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('stateadmin-list', {'getall': 'admin/stateadmin/{{$state->id}}'})">
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
					<button class="btn-theme btn-sm  pull-right" ng-click="helper.state_id={{$state->id}};openPopup('admin', 'state', 'update-state', 'create-popup-style')">Update State</button>
				</div>
			</div>
		</div>
		<div class="all-admin-link">
			<a href="{{route('admin.state.state-admin', $state->slug)}}">
				<button class="btn btn-grn-outline">State Admins</button>
			</a>

			<a href="{{route('admin.single.district-admin', $state->slug)}}">
				<button class="btn btn-grn-outline">Districts</button>
			</a>

			<a href="{{route('admin.role.district-admin', $state->slug)}}">
				<button class="btn btn-grn-outline">District Admins</button>
			</a>
			<a href="{{route('admin.nodal.nodal-admin', $state->slug)}}">
				<button class="btn btn-grn-outline">Nodal Admins</button>
			</a>




			<a href="{{route('admin.school.get', $state->slug)}}">
				<button class="btn btn-grn-outline">Schools</button>
			</a>
			<button ng-really-action="Delete" ng-really-message="Do you want to delete this state?" ng-really-click="create('admin/state/delete/{{$state->id}}',  state, 'delete')" class="btn btn-danger btn-xs city-action-btn"><i class="fa fa-trash-o"></i></button>
		</div>
	</div>
</div>
</div>
@endsection
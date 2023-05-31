@extends('admin::includes.layout')
@section('content')
<section class="admin_dash" ng-cloak>
	<div class="page-header-custom page-title-ad">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="">
					<h2>
					States
					</h2>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<button class="btn-theme btn-blue pull-right" ng-click="openPopup('admin', 'state', 'add-state', 'create-popup-style')">
				Add State
				</button>
			</div>
		</div>
	</div>
	<div class="" ng-controller="AppController" >
		<div class="" ng-controller="ListController as List" ng-cloak ng-init="List.init('state-list', {'getall': 'admin/states/all','search': 'admin/states/all/search'})">
			<div class="list-wrapper">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						@include('page::app.pagination')
						<div class="ad-state-card" ng-repeat="state in List.ListService.results">
							<img ng-src="[[state.fmt_logo]]" height="50" alt="[[state.name]]">
							<h2>
							[[state.name]]
							</h2>
							<button class="btn-brief" dynamic-content="[[ 'admin/states/brief/'+state.id ]]" dynamic-content-url="true">
							Brief
							</button>
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
	</div>
</section>
@endsection
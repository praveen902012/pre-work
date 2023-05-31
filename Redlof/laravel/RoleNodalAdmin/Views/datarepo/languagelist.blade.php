@extends('nodaladmin::includes.layout')
@section('content')
<section class="admin_dash cm-content" ng-cloak>
	<div class="page-header-custom">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip">
					<h2>
					Languages
					</h2>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="rt-action pull-right">
					<a href=""> All State</a>
					<button class="btn-theme btn-blue btn-sm">
					Add Languages
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="" ng-controller="AppController" >
	<div ng-controller="ListController as List" ng-cloak ng-init="List.init('state-list', {'getall': 'get/languages/all'})">
		<div class="list-wrapper">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					@include('page::app.pagination')
					<div class="ad-state-card"  ng-repeat="state in List.ListService.results">
						<img ng-src="[[state.fmt_logo]]" height="50" alt="[[state.name]]">
						<h2>
						[[language.name]]
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class=" ">
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
@extends('admin::includes.layout')
@section('content')
<section class="admin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="">
						<h2>
						Language
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<button class="btn-theme btn-blue pull-right" ng-click="openPopup('admin', 'datarepo', 'add-language', 'create-popup-style')">
					Add Languages
					</button>
				</div>
			</div>
		</div>
		
		<div ng-controller="ListController as List" ng-cloak ng-init="List.init('language-list', {'getall': 'admin/get/languages/all', 'search':'admin/get/languages/search'})">
			@include('page::app.pagination-language')
			<table class="table table-responsive custom-table">
				<thead class="thead-cls">
					<tr>
						<th>Sl.no</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
					<tr ng-repeat="language in List.ListService.results">
						<td>[[$index+1]]</td>
						<td>[[language.name]]</td>
						<td><button ng-really-action="Delete" ng-really-message="Do you want to delete this Language?" ng-really-click="create('admin/language/delete/'+[[language.id]],  language, 'delete')" class="btn btn-danger btn-xs city-action-btn"><i class="fa fa-trash-o"></i></button></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</section>
@endsection
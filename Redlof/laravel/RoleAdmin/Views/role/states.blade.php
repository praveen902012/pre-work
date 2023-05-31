@extends('admin::includes.layout')
@section('content')
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="label-admin">
					<h4>
					{{ $state }}
						States

					</h4>
					<span class="pull-right">
						<button class="btn btn-default btn-xs" ng-click="openPopup('admin', 'role', 'add-state', 'create-popup-style')">
							Add
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<table class="table table-responsive custom-table">
					<thead class="thead-cls">
						<tr class="tr-right">
							<th>Name</th>
						</tr>
					</thead>
					<tbody class="right-align-col">
						<tr class="tr-right" ng-repeat="category in List.ListService.results"  ng-cloak>
							[[ category ]]
							<td ng-bind="category.name">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@endsection

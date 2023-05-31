@extends('admin::includes.landing')
@section('content')
@include('admin::notifications.menu')
<div class="gallery-library" ng-controller="GalleryListController as List">
	<div class="row" >
		<div class="col-lg-6" >
			<div class="pull-left notification-gallery-nav">
				<a href="{{ route('admin.notifications-gallery-upload') }}" class="btn btn-default btn-xs ">
					Upload
				</a>
				<a href="{{ route('admin.notifications-gallery-library') }}" class="btn btn-default btn-xs active">
					Library
				</a>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="filter-library" ng-init="List.access='all'">
				<div class="row">
					<div class="col-sm-4 col-xs-12">
						<select ng-model="List.access" class="form-control">
							<option selected value="all">All</option>
							<option value="public">Public</option>
							<option value="private">Private</option>
						</select>
					</div>
					<div class="col-sm-4 col-xs-12">
						<select ng-model="List.order_by" ng-init="List.order_by='desc'" class="form-control">
							<option selected value="desc">Latest first</option>
							<option value="asc">Oldest first</option>
						</select>
					</div>
					<div class="col-sm-4 col-xs-12">
						<button type="button" ng-click="List.applyFilters()" class="btn theme-btn bg-theme-btn btn-sm">Apply</button>
					</div>
				</div>	

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>
							<p >Name</p>
						</th>
						<th>
							<p >Url</p>
						</th>
						<th>
							<p >Uploaded On</p>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr  ng-repeat="image in List.ListService.results">
						<td>
							<p  ng-bind="image.orig_name"></p>
						</td>
						<td>
							<p  ng-bind="image.url"></p>
						</td>
						<td>
							<p  ng-bind="image.created_at"></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
@endsection
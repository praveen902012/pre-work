@extends('stateadmin::includes.layout')
@section('content')
<section  class="stateadmin_dash"  ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-init="List.init('school-list', {'getall': 'stateadmin/gallery'})" ng-cloak>
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">

						<h2>
						Gallery
						</h2>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<button class="btn-theme btn-sm pull-right" ng-click="helper.state_id={{$state}};openPopup('stateadmin', 'gallery', 'add-image', 'create-popup-style')">
					Add Image
					</button>
					<div class="all-admin-link pull-right">
						<a href="{{route('stateadmin.state.featured-gallery')}}">
							<button class="btn btn-blue-outline">Featured Images</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div ng-if="List.ListService.results.length > 0">
			<div class="row">
				<div class="col-sm-3 col-xs-12" ng-repeat="pic in List.ListService.results">
					<div class="panel panel-info" id="prjoect-detail">
						<a class="dblockmrb-30" href=[[pic.name]]>
							<img class="img-thumbnail gallery-img" src=[[pic.name]] alt="name">
						</a>
						<div class="panel-body">
							<button ng-disabled="inProcess" ng-really-action="Delete" ng-really-message="Do you want to delete this image?" ng-really-click="create('stateadmin/gallery/delete/'+[[pic.id]],  pic, 'delete')" class="btn btn-danger">
								<span ng-if="!inProcess">Delete</span>
								<span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="t-footer">
				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<p>
							Showing [[List.ListService.currentPage]] of [[List.ListService.totalPage]] pages.
						</p>
					</div>
					<div class="col-sm-6 col-xs-6">
						<div class="prev-next pagination-custom tb-pagination pull-right">
							<table class="table">
								<td class="no-border">
									<ul class="list-unstyled list-inline text-left" ng-class="{ 'hide-pagination': !List.ListService.pagination }">
										<li>
											<a href="" ng-click="List.prevPage()" class="next-prev-link">
												<i class="fa ion-ios-arrow-left" aria-hidden="true"></i>
												<span>
													Prev [[List.ListService.pagesize]]
												</span>
											</a>
										</li>
										<li>
											<a href="" ng-click="List.nextPage()" class="next-prev-link">
												<span>
													Next [[List.ListService.pagesize]]
												</span>
												<i class="fa ion-ios-arrow-right" aria-hidden="true"></i>
											</a>
										</li>
									</ul>
								</td>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p ng-if="List.ListService.results.length == 0">No pics to display</p>
	</div>
</section>
@endsection
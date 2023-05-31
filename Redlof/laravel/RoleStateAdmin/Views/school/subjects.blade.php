@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController">
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('subject-list', {'getall': 'stateadmin/subjects'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<h2>
					{{ $title }}
					</h2>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="rt-action pull-right">
						<button class="btn-theme btn-blue" ng-click="openPopup('stateadmin', 'school', 'add-subject', 'create-popup-style')">
						Add Subject
						</button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div>
				<div class="row" ng-if="List.ListService.results.length > 0">
					<div class="col-sm-12 col-xs-12">
						@include('page::app.pagination')
						<div >
							<table class="table table-responsive custom-table table-bordered" >
								<thead class="thead-cls">
									<tr>
										<th>Sl.no</th>
										<th>Class</th>
										<th>Subject Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="subject in List.ListService.results">
										<td>[[$index+1]]</td>
										<td>[[subject.level.level]]</td>
										<td>[[subject.subject.name]]</td>
										<td>
											<button ng-really-action="Delete" ng-really-message="Do you want to delete this subject?" ng-really-click="create('stateadmin/subject/delete/'+[[subject.id]],  subject, 'delete')" class="btn btn-danger btn-xs city-action-btn">Delete</button>

										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p class="text-center" ng-if="List.ListService.results.length == 0">No Subjects to display</p>
	</div>
</div>
</section>
@endsection
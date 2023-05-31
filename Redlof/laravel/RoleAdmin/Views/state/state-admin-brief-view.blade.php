<section class="bg-rt dy-content-slide">
	<div class="">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="detail-card-st">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							@if(!is_null($state_admin->user->photo))
							<img class="img-responsive" src="{$state_admin->user->photo}}">
							@else
							<img class="img-responsive" src="{!! asset('img/user_photo.jpg') !!}">
							@endif
						</div>
						<div class="col-sm-5 col-xs-12 no-padding">
							<h2 class="">{{$state_admin->user->display_name}}</h2>
						</div>
						<div class="col-sm-3 col-xs-12">
							@if($state_admin->status == 'active')
							<a ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this state admin?" ng-really-click="create('admin/stateadmin/deactivate/'+[[stateadmin.id]],  stateadmin, 'deactivate')"  class="btn btn-danger pull-right">Deactivate</a>
							@else
							<a ng-really-action="Activate" ng-really-message="Do you want to activate this state admin?" ng-really-click="create('admin/stateadmin/activate/'+[[stateadmin.id]],  stateadmin, 'Activate')"  class="btn btn-success pull-right">Activate</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="st-ad-dt-heading ">
					<h2>
					Basic Details:
					</h2>
				</div>
				<div class="st-admin-detail">
					<ul class="list-unstyled">
						<li><b>Email: </b>{{$state_admin->user->email}}</li>
						<li><b>Phone: </b>{{$state_admin->user->phone}}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
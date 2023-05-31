<section class="bg-rt dy-content-slide">
	<div class="">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="detail-card-st">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							@if(!is_null($nodal_admin->user->photo))
							<img class="img-responsive" src="{$nodal_admin->user->photo}}">
							@else
							<img class="img-responsive" src="{!! asset('img/user_photo.jpg') !!}">
							@endif
						</div>
						<div class="col-sm-5 col-xs-12 no-padding">
							<h2 class="">{{$nodal_admin->user->display_name}}</h2>
						</div>
						<div class="col-sm-3 col-xs-12">
							@if($nodal_admin->status == 'active')
							<button ng-disabled="inProcess" ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this nodal?" ng-really-click="create('stateadmin/nodal/deactivate/'+[[districtnodal.id]],  nodal, 'deactivate')" class="btn btn-danger btn-xs city-action-btn" >
								<span ng-if="!inProcess" class="font-size-11"><i class="fa fa-ban"></i>  Deactivate</span>
								<span ng-if="inProcess" class="font-size-11">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
							@else
							<button ng-disabled="inProcess" ng-really-action="Activate" ng-really-message="Do you want to activate this nodal?" ng-really-click="create('stateadmin/nodal/activate/'+[[districtnodal.id]],  nodal, 'activate')" class="btn btn-success btn-xs city-action-btn">
								<span ng-if="!inProcess" class="font-size-11"><i class="fa fa-check"></i>  Activate</span>
								<span ng-if="inProcess" class="font-size-11">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
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
						<li><b>Email: </b>{{$nodal_admin->user->email}}</li>
						<li><b>Phone: </b>{{$nodal_admin->user->phone}}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
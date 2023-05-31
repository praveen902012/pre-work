<section class="bg-rt dy-content-slide">
	<div class="">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="detail-card-st">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							@if(!is_null($district_admin->user->photo))
							<img class="img-responsive" src="{$district_admin->user->photo}}">
							@else
							<img class="img-responsive" src="{!! asset('img/user_photo.jpg') !!}">
							@endif
						</div>
						<div class="col-sm-5 col-xs-12 no-padding">
							<h2 class="">{{$district_admin->user->display_name}}</h2>
						</div>
						<div class="col-sm-3 col-xs-12">
							<a ng-disabled="inProcess" ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this District Admin?" ng-really-click="create('stateadmin/districtadmin/deactivate/{{$district_admin->id}}',  districtadmin, 'deactivate')" class="btn btn-danger pull-right">
								<span ng-if="!inProcess">Deactivate</span>
								<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</a>
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
						<li><b>Email: </b>{{$district_admin->user->email}}</li>
						<li><b>Phone: </b>{{$district_admin->user->phone}}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
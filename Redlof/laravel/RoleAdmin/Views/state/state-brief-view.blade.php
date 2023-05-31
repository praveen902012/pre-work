<section class="bg-rt dy-content-slide">
	<div class="">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="detail-card-st">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							<img src="{{$state->fmt_logo}}"  alt="{{$state->name}}" class="img-responsive">
						</div>
						<div class="col-sm-5 col-xs-12 no-padding">
							<h2 class="">{{$state->name}}</h2>
							<ul>
								<li>No of distict admins:
									@if(!is_null($state->total_district_admins))
									<span>
										{{ $state->total_district_admins->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
								<li>No of nodal admins:
									@if(!is_null($state->total_nodal_admins))
									<span>
										{{ $state->total_nodal_admins->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
								<li>No of schools:
									@if(!is_null($state->total_schools))
									<span>
										{{ $state->total_schools->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
							</ul>
						</div>
						<div class="col-sm-3 col-xs-12">
							<a ng-href="{{ route('admin.state.single', $state->slug) }}" class="btn-theme btn-sm pull-right">Details</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(!is_null($state->stateadmin))
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="st-ad-dt-heading ">
					<h2>
					State Admin Details
					</h2>
				</div>
				<div class="st-admin-detail">
					<ul class="list-unstyled">
						<li>{{$state->stateadmin->user->display_name}}</li>
						<li><a href="mailto:{{$state->stateadmin->user->email}}">
							{{$state->stateadmin->user->email}}
						</a></li>
					</ul>
					@if(!is_null($state->stateadmin->user->photo_thumb))
					<img src="{{$state->stateadmin->user->photo_thumb}}">
					@else
					<img src="{!! asset('img/user_photo.jpg') !!}">
					@endif
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
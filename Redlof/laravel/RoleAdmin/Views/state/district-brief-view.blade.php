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
							<h2 class="">{{$district->name}}</h2>
							<ul>
								<li>No of distict admins:
									@if(!is_null($district->total_district_admins))
									<span>
										{{ $district->total_district_admins->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
								<li>No of schools:
									@if(!is_null($district->total_schools))
									<span>
										{{ $district->total_schools->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
								<li>No of students:
									@if(!is_null($district->total_students))
									<span>
										{{ $district->total_students->total }}
									</span>
									@else
									<span>0</span>
									@endif
								</li>
							</ul>
						</div>
						<div class="col-sm-3 col-xs-12">
							<a ng-href="{{ route('admin.role.district-admin', $district->id) }}" class="btn-theme btn-sm pull-right">Details</a>
						</div>
					</div>
				</div>
			</div>
		</div>
			</div>
		@if(!is_null($district->districtadmin))
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="st-ad-dt-heading ">
					<h2>
					Recently Added District Admins
					</h2>
				</div>
				<div class="st-admin-detail">
					<ul class="list-unstyled">
						<li>{{$district->districtadmin->user->display_name}}</li>
						<li><a href="mailto:{{$district->districtadmin->user->email}}">
							{{$district->districtadmin->user->email}}
						</a></li>
					</ul>
					@if(!is_null($district->districtadmin->user->photo_thumb))
					<img src="{{$district->districtadmin->user->photo_thumb}}">
					@else
					<img src="{!! asset('img/user_photo.jpg') !!}">
					@endif
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
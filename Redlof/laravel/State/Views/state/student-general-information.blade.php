@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content  section-spacing">
	<div class="container">
		<div class="rte-container">

			<div class="">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="hm-card hm-hero-card bg-hm-theme">
							<div class="heading-header">
								<h4>
								Student Information
								</h4>
								<span>
									<i class="fa fa-users" aria-hidden="true"></i>
								</span>
							</div>
							<div class="card-content notification-content">
								<ul class="list-unstyled">
									<li>
										<a href="{{route('state.student.general.information.registered', $state->slug)}}">Registered Students
											<span>
												<i class="ion-ios-arrow-right"></i>
											</span>
										</a>
									</li>
									<li>
										<a href="{{route('state.student.general.information.allotted', $state->slug)}}">Allotted Students
											<span>
												<i class="ion-ios-arrow-right"></i>
											</span>
										</a>
									</li>
									<li>
										<a href="{{route('state.student.general.information.enrolled', $state->slug)}}">Enrolled Students
											<span>
												<i class="ion-ios-arrow-right"></i>
											</span>
										</a>
									</li>
									<li>
										<a href="{{route('state.student.general.information.rejected', $state->slug)}}">Rejected Students
											<span>
												<i class="ion-ios-arrow-right"></i>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
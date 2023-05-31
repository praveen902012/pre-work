@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-sp-success" ng-controller="AppController" ng-init="Registration = {}">
	<div class="container" ng-controller="Step4Controller as Step4" ng-init="Registration.registration_no = helper.findIdFromUrl()">
		<div class="sp-form-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
					<h3 class="text-theme-green">Congratulations! You have succesfully submitted your application.</h3>

					<p class="text-lightgrey">
						Your Registration ID is {{$registration_no}}
					</p>

					<p class="text-lightgrey">
						Once the results are announced you can check your results using your Registration ID sent to you.
					</p>

					<p class="text-lightgrey">
					</p>

					<a href="/api/{{$state->slug}}/download/registration-form/{{$registration_no}}" class="btn btn-blue mrt-20">
						<i class="fa fa-print" aria-hidden="true"></i> &nbsp;&nbsp; Print application
					</a>

					<a href="{{route('state.registration.logout',[$state->slug,$registration_no])}}" class="btn btn-blue mrt-20">
						<i class="fa fa-power-off" aria-hidden="true"></i> &nbsp;&nbsp; Logout
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
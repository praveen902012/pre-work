@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing" ng-controller="AppController" >
	<div class="container" ng-controller="SchoolController as School">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="">
						<h2 class="text-theme-green">
							साइन अप करने के लिए धन्यवाद
						</h2>
						<p>
							You should recieve a confirmation sms and email with login crendentials for your school dashboard.
						</p>

						<div class="thanks-back">
							<a href="{{route('state', $state->slug)}}" class="btn-theme btn-blue">
								Back to homepage
							</a>

							<a href="/api/{{$state->slug}}/get/school/{{$udise}}/application/download" class="btn-theme btn-blue">
								<i class="fa fa-print" aria-hidden="true"></i> &nbsp;&nbsp; Print application
							</a>
						</div>
						<p>SMS not recieved? <a ng-click="School.sendSmsAgain('{{$state->slug}}','{{$udise}}')" href="">Click here to send again.</a></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	@include('state::includes.footer')
	@include('state::includes.foot')
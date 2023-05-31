@extends('schooladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
						<h2>
						Edit school details
						</h2>
						<p>
							Register here for filling up Application Form for EWS/DG Admission for session 2019-2020
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">

					<div id="exTab1">
						<ul  class="nav nav-pills reg-nav-block ">
							<li class="active">
								<a ng-click="School.resetAllSchool()" class="step-link">Reset</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
</section>
@endsection
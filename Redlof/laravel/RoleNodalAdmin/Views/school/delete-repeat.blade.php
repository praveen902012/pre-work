@extends('nodaladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController" >
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
						<h2>
						Delete School
						</h2>
						<p>
							<a ng-click="School.deleteSchool()" class="btn btn-primary">Delete School</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
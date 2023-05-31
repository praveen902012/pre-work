@extends('stateadmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12" ng-init="formData = {}">
				<div class="all-admin-link">
					<form name="message">
						<div class="form-group">
							<label for="message">Message:</label>
							<textarea ng-model="formData.message" required placeholder="Write your message here..." class="form-control" rows="5" id="message"></textarea>
						</div>
						<div class="form-group">
							<label for="recievers">Send to:</label>
							<label class="radio-inline"><input type="radio" ng-model="formData.student_type" value="applied"  name="optradio">Applied Students</label>
							<label class="radio-inline"><input type="radio" ng-model="formData.student_type"  value="allotted" name="optradio">Allotted Enrolled</label>
							<label class="radio-inline"><input type="radio" ng-model="formData.student_type" value="enrolled" name="optradio">Enrolled Enrolled</label>
						</div>
						<button ng-really-action="Send" ng-really-message="Do you really want to send? Once sent cannot be reverted!" ng-really-click="create('stateadmin/message/send/students', formData, 'message')" class="btn btn-primary">Send Message</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
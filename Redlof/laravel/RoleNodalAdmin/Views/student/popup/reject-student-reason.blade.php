<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Confirm rejection
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="ToBeVerifiedStudent as DocVerify">
		Reason for rejection
		<form name="reject"  ng-submit="DocVerify.documentRejectStudent(helper.registration_id, 'nodaladmin/students/rejectdoc', formData)" ng-init="formData.registration_id=helper.registration_id">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<br><input type="text" ng-model="formData.rejected_reason" name="rejected_reason" required class="form-control"><br>
					<button type="submit" class="btn btn-danger">Reject</button>
					<button ng-click="closeThisDialog()" class="btn btn-default">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</section>
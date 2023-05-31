<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Confirm dropout
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-init="formData.student_id=helper.student_id">
		<p>Please make sure you have saved the student attendance details before proceeding to dropout.</p>
		<form name="reject" class="common-form add-area form-add-school" ng-submit="create('schooladmin/mark-student/dropout/'+[[helper.student_id]],  formData, 'dropout')">
			<div class="form-group form-field">
				<label>
					Please write your reason.
				</label>
				<textarea spellcheck="true" rows="4"  name="description" ng-model="formData.reason"  class="form-control"></textarea>
			</div>
			<button type="submit" class="btn btn-danger city-action-btn">Proceed to dropout</button>
		</form>
	</div>
</section>
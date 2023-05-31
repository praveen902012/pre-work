<section ng-controller="AppController" ng-cloak>
	<div class="header-popup-ad">
		<h2>
		Reject School
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<form name="reject" class="common-form add-area form-add-school" ng-submit="create('nodaladmin/school/reject/'+[[helper.school_id]],  formData, 'reject')">
					<div class="form-group form-field">
						<label>
							Please write your reason for rejecting this school.
						</label>
						<textarea spellcheck="true" rows="4"  name="description" ng-model="formData.reject_reason"  class="form-control"></textarea>
					</div>
					<button type="submit" class="btn btn-danger city-action-btn">Reject School</button>
				</form>
			</div>
		</div>
	</div>
</section>
<section class="cm-content" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Report School
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<form name="report" class="common-form add-area form-add-school">
		<div ng-init="formData.registration_no = helper.registration_no" class="popup-content-ad">
			<div class="row">
				<div class="col-md-12">
					<p>
						Did not find your school? Please report the school name.
					</p>
					<div class="form-group">
						<div class="form-group">
							<input validator="required" valid-method="blur" type="text" name="school_name" ng-model="formData.school_name" ng-required="true" class="form-control" placeholder="Enter school name">
						</div>
					</div>
					<div class="form-group">
						<button ng-disabled="inProcess" ng-click="create(helper.slug+'/report-school',  formData, 'report');closeThisDialog();" type="button" class="btn-theme">
							<span ng-if="!inProcess">Report</span>
							<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
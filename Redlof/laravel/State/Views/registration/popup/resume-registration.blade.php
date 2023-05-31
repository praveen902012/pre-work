<section ng-controller="ResumeRegistrationController as Registration" class="cm-content">
	<div class="header-popup-ad">
		<h2>
			Please enter your Registration number
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
		<div class="row">
			<div class="col-md-12">
				<p>
					Enter your Registration ID that was sent to your mobile when you submitted your personal details from the step 1.
				</p>
				<div class="form-group">
					<div class="form-group" ng-if="Registration.is_validApplicant">
						<input validator="required" valid-method="blur" type="text" name="registration_id" ng-model="Registration.registrationData.registration_id" ng-required="true" class="form-control" disabled placeholder="Enter your registration number">
					</div>
					<div class="form-group" ng-if="!Registration.is_validApplicant">
						<input validator="required" valid-method="blur" type="text" name="registration_id" ng-model="Registration.registrationData.registration_id" ng-required="true" class="form-control" placeholder="Enter your registration number">
					</div>
				</div>
				<div class="form-group" ng-if="!Registration.is_validApplicant">
					<button ng-disabled="Registration.inProcess" type="submit" class="btn-theme" ng-click="Registration.resumeRegistration([[helper.state_slug]]+'/resume/registration')">
						<span ng-if="!Registration.inProcess">Send OTP</span>
						<span ng-if="Registration.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
				<div class="form-group" ng-if="Registration.is_validApplicant">
					<button ng-disabled="Registration.inProcess" type="submit" class="btn-theme" ng-click="Registration.resumeRegistration([[helper.state_slug]]+'/resend/otp')">
						<span ng-if="!Registration.inProcess">Resend OTP</span>
						<span ng-if="Registration.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
				<div class="form-group" ng-init="">
					<div class="form-group" ng-if="Registration.is_validApplicant">
						<input validator="required" valid-method="blur" type="text" name="registration_id" ng-model="Registration.registrationData.otp" ng-required="true" class="form-control" placeholder="Enter OTP here">
					</div>
					<div class="form-group" ng-if="Registration.is_validApplicant && Registration.registrationData.otp.length==4">
						<button ng-disabled="Registration.inProcess" ng-click="Registration.verifyRegistration([[helper.state_slug]]+'/verify/otp')" class="btn-theme">
							<span ng-if="!Registration.inProcess">Verify OTP</span>
							<span ng-if="Registration.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
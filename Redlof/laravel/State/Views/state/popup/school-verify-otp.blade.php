<section ng-controller="SchoolController as School" class="cm-content">
	<div class="header-popup-ad">
		<h2>
		OTP verification.
		</h2>

	</div>
	<div class="popup-content-ad">
		<div class="row">
			<div class="col-md-12">
				<p>
					Please enter otp received on your admin mobile number.
				</p>
				<div class="form-group" ng-init="">
					<div class="form-group">
						<input validator="required" valid-method="blur" type="text" name="registration_id" ng-model="School.otp" ng-required="true" class="form-control" placeholder="Enter OTP here">
					</div>
					<div class="text-center form-group">
						<a href="" ng-click="School.resendSchoolOtp()">OTP को पुनः भेजें</a>
					</div>
					<div class="text-center form-group">
						<button ng-disabled="School.inProcess" ng-click="School.verifySchoolOtp(School.otp)" class="btn-theme">
							<span ng-if="!School.inProcess">OTP को सत्यापन करे</span>
							<span ng-if="School.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Please add student bank details
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div ng-controller="SchoolController as School" class="popup-content-ad">
		<div class="tab-content clearfix">
			<div class="col-sm-12 col-xs-12">
				<form ng-submit="create('schooladmin/student/enroll/'+ helper.registration_id, School.bankdetail, 'updatebankDetail')" name="updatebankDetail" class="common-form operator_signin_form">

					<div class="form-group form-field text-right">
						<div class="checkbox">
							<label>
								<input type="checkbox" ng-model="School.bankdetail.suspicious">Flag this student as suspicious
							</label>
						</div>
					</div>
					<div ng-if="School.bankdetail.suspicious" class="form-group form-field">
						<div class="">
							<label>
								Reason for marking this student as suspicious (optional)
							</label>
							<textarea   type="text" class="form-control" ng-model="School.bankdetail.suspicious_reason"  placeholder="Write your reason for marking this student as suspicious" ></textarea>
						</div>
					</div>
					<div class="form-group form-field">
						<div class="">
							<label>
								Account holder name*
							</label>
							<input   type="text" class="form-control" ng-model="School.bankdetail.account_holder_name" id="account_holder_name" placeholder="Account holder name" >
						</div>
					</div>
					<div class="form-group form-field">
						<div class="">
							<label>
								Account number*
							</label>
							<input  min="0" type="text" class="form-control" ng-model="School.bankdetail.account_number" id="account_number" placeholder="Account number" >
						</div>
					</div>
					<div class="form-group form-field">
						<div class="">
							<label>
								Confirm account number*
							</label>
							<input  min="0" type="text" class="form-control" ng-model="School.bankdetail.account_number_confirmation" id="account_number" placeholder="Account number" >
						</div>
					</div>
					<div class="form-group form-field">
						<div class="">
							<label>
								IFSC code*
							</label>
							<input ng-change="School.clearBankDetails()" type="text" class="form-control" ng-model="School.bankdetail.ifsc_code" id="ifsc_code" placeholder="IFSC code" >
						</div>
					</div>
					<div class="form-group form-field">
						<a ng-click="School.getBankDetails(School.bankdetail.ifsc_code)" type="button" class="btn btn-primary"> Verify IFSC code</a>
						<button ng-show="!School.bankdetail.bankcount.length" type="submit" class="btn btn-theme pull-right">Skip & Enroll Student</button>
					</div>
					<div ng-show="School.bankdetail.bankcount.length>0">
						<div class="form-group form-field" ng-init="banks = helper.allBanks()">
							<div class="">
								<label>
									Bank name
								</label>
								<input type="text" class="form-control" ng-model="School.bankdetail.bank_name" id="account_number" placeholder="Account number" >
							</div>
						</div>
						<div class="form-group form-field">
							<div class="">
								<label>
									Branch
								</label>
								<input type="text" class="form-control" ng-model="School.bankdetail.branch" id="account_number" placeholder="Bank branch" >
							</div>
						</div>
						<button ng-disabled="updatebankDetail.$invalid" type="submit" class="btn btn-theme">Save & Enroll Student</button>
						<button type="submit" class="btn btn-theme pull-right">Skip & Enroll Student</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
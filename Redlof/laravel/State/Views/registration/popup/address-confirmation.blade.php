<section ng-controller="ResumeRegistrationController as Registration" class="cm-content">
	<div class="header-popup-ad">
		<h2>
			Please click on "I agree" to continue
		</h2>
	</div>
	<div class="popup-content-ad">
		<div class="row">
			<div class="col-md-12" style="color: red;margin-top: 20px;margin-bottom: 20px;">
				<b>
                    पते में अपना वही पता डालें जो आपके प्रमाण पत्र में है, गलत पाए जाने पर आवेदन खारिज कर दिया जायेगा!
                </b>
			</div>
            <div class="col-md-12" style="margin-top: 15px;text-align: center;">
				<button ng-click="closeThisDialog()" class="btn-theme">
                    I agree
                </button>
			</div>
		</div>
	</div>
</section>
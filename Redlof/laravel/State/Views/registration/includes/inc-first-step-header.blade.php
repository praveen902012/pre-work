<div class="reg-nav-block mrt-20" ng-controller="ResumeRegistrationController as Registration">
	<div class="row">
        <div class="col-md-10" style="margin-left: 40px;">
            <marquee id="tar_get" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" style="color: red;">

                <span>{{ googletrans('फॉर्म भरते हुए बीच मे अधूरा रह जाये तोह बाद में "Resume Registration" बटन दबाकर वापिस उस जगह से फॉर्म को आरम्भ करे। नया फॉर्म भरने से पंजीकरण में बाधा आ सकती हैं।', $_COOKIE['lang']) }}</span>

            </marquee>  
        </div> 
	</div>
	<div class="text-right" ng-init="helper.state_slug='{{$state->slug}}'">
		<a href="" style="position: relative; top: -27px;" class="btn btn-green-outline btn-marque-adjust" ng-click="openPopup('state', 'registration', 'resume-registration', 'create-popup-style sm-popup-style')">
			Resume Registration
		</a>
	</div>
	<h3>Student/Parent Registration</h3>
	<p>Register here for filling up Application Form for EWS/DG Admission for session {{date("Y")}}-{{date("y")+1}} ( <a href="{{ route('state.student-registration-instruction', $state->slug) }}" target="_blank" class="text-dred">See Instruction</a> )</p>

	<ul class="list-inline list-unstyled">
		<li class="nopd-left">
			<a href="" class="btn step-link active">
				1. Personal Details
			</a>
		</li>
		<li>
			<a href="" class="btn step-link" ng-disbled="true">
				2. Parent Details
			</a>
		</li>
		<li>
			<a href="" class="btn step-link" ng-disbled="true">
				3. Address Details
			</a>
		</li>
		<li>
			<a href="" class="btn step-link" ng-disbled="true">
				4. Documents
			</a>
		</li>
		<li>
			<a href="" class="btn step-link" ng-disbled="true">
				5. Select Schools
			</a>
		</li>
	</ul>
</div>

<script>
	window.addEventListener('DOMContentLoaded', (event) => {
		setTimeout(function(){
			$('#tar_get').trigger('mouseout');
		}, 2000);
	});
</script>
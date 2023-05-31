<div class="reg-nav-block mrt-20">
	<div class="text-right" ng-init="helper.state_slug='{{$state->slug}}'">
		<span class="text-theme-green">Registration ID : {{$registration_no}}</span>
	</div>
	<h3>Student/Parent Registration</h3>
	<p>Register here for filling up Application Form for EWS/DG Admission for session {{date("Y")}}-{{date("y")+1}} ( <a href="{{ route('state.student-registration-instruction', $state->slug) }}" target="_blank" class="text-dred">See Instruction</a> )</p>

	<ul class="list-inline list-unstyled">
		<li class="nopd-left">
			<a href="{{ route('state.registration.update', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\Helpers\RegistrationAccessHelperClass::checkAccessSansException($registration, 'step1')}} {{\AppHelper::isActive(['personal'], 'active')}}">
				1. Personal Details
			</a>
		</li>
		<li>
			<a href="{{ route('state.registration.parent', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\Helpers\RegistrationAccessHelperClass::checkAccessSansException($registration, 'step2')}} {{\AppHelper::isActive(['parent'], 'active')}}">
				2. Parent Details
			</a>
		</li>
		<li>
			<a href="{{ route('state.registration.address', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\Helpers\RegistrationAccessHelperClass::checkAccessSansException($registration, 'step3')}} {{\AppHelper::isActive(['address'], 'active')}}">
				3. Address Details
			</a>
		</li>
		<li>
			<a href="{{ route('state.registration.documents', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\Helpers\RegistrationAccessHelperClass::checkAccessSansException($registration, 'step4')}} {{\AppHelper::isActive(['documents'], 'active')}}">
				4. Documents
			</a>
		</li>
		<li>
			<a href="{{ route('state.registration.schools', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\Helpers\RegistrationAccessHelperClass::checkAccessSansException($registration, 'step5')}} {{\AppHelper::isActive(['school'], 'active')}}">
				5. Select Schools
			</a>
		</li>
		@if(!empty($show_preview))
		@if($show_preview)
		<li>
			<a href="{{ route('state.registration.preview', [$state->slug, $registration_no]) }}" class="btn step-link zero-pad {{\AppHelper::isActive(['preview'], 'active')}}">
				6. Preview Details
			</a>
		</li>
		@endif
		@endif
	</ul>
</div>
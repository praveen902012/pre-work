@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="bg-grey section-spacing" ng-app="app" ng-controller="AccountController as nodaladmin">
	<div class="container">
		<div  class="reg-form-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
						<h2>
						Nodal Admin Sign In
						</h2>
						<form ng-submit="nodaladmin.signin(nodaladmin.signInData, 'nodaladmin/signin')" name="operator_signin_form">
							<div class="form-group">
								<label>
									Email <span>(ईमेल)</span><span class="mand-field">&nbsp; *</span>
								</label>
								<input validator="required" valid-method="blur" type="email" class="form-control" ng-model="nodaladmin.signInData.email" required>
							</div>
							<div class="form-group">
								<label>
									Password <span>(पासवर्ड)</span><span>&nbsp;*</span>
								</label>
								<input validator="required" valid-method="blur" type="password" class="form-control" id="password-input" ng-model="nodaladmin.signInData.password" required>
							</div>
							<div class="form-group">
							<p class="terms-txt">
								By logging into RTE Paradarshi, you agree to our <a href="{{ route('state.terms', $state->slug) }}" target="_blank">Terms of use</a> and <a href="{{ route('state.privacy', $state->slug) }}" target="_blank">Privacy policy</a>.
							</p>
						</div>
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<button ng-disabled="nodaladmin.authService.inProcess" type="submit" class="btn-theme">
										<span ng-if="!nodaladmin.authService.inProcess">Sign In</span>
										<span ng-if="nodaladmin.authService.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
									</button>
								</div>
								<div class="col-md-6 col-xs-12">
									<a class="frgt-pass" href="{{ route('state.forgotpassword.get', $state->slug) }}">Forgot Password?</a>
								</div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('page::includes.foot')
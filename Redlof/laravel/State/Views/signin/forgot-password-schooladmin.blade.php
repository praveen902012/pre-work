@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="bg-grey section-spacing" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div  class="reg-form-container">
			<div class="row">
				<div class="col-md-12 col-xs-12"  ng-init="formData.state = '{{$state->slug}}'">
					<div class="">
						<h2>
						Forgot Password
						</h2>
						<form name="forgotPassword" id="forgotPassword" ng-submit="create('password/phone', formData, '')">
							<div class="form-group">
								<label>
									Phone <span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">&nbsp; *</span>
								</label>
								<input validator="required" valid-method="blur" type="phone" class="form-control" ng-model="formData.phone" required>
							</div>
							<div class="form-group">
								<p class="terms-txt">
									A reset password  will be sent to your registered
									phone number.
								</p>
							</div>
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<button type="submit" class="btn-theme">Submit</button>
								</div>
								<!-- <div class="col-sm-6 col-xs-12">
									<a class="frgt-pass" href="{{ route('state.forgotpassword.get', $state->slug) }}">back to sign in</a>
								</div> -->
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
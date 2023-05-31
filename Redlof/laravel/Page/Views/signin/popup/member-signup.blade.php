<section class="signin custom-popup pp-reg" ng-app="app" ng-controller="MemberAccountController as member">
	<div class="container-fluid">
		<div class="row">
			<div class="text-center">
				<div class="margin-b-30">
					<img src="{!! asset('img/rte-logo-blue.png') !!}" class="img-responsive center-block">
					<i class="ion-ios-close-empty close" aria-hidden="true" ng-click="closeThisDialog(0)"></i>
					<h3>
						Create an account
					</h3>
				</div>
			</div>
			<div class="col-md-12 col-xs-12">
				<div class="form-fields">
					<form ng-submit="member.signup(member.signUpData, 'signup-form')" class="form-horizontal" name="signup-form" show-msg="false">
						<div class="form-group input-placeholder">
							<label class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input name="first_name" type="text" class="form-control" placeholder="First Name"  ng-model="member.signUpData.first_name" required>
							</div>
						</div>
						<div class="form-group input-placeholder">
							<label class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input name="last_name" type="text" class="form-control" placeholder="Last Name"  ng-model="member.signUpData.last_name" required>
							</div>
						</div>
						<div class="form-group input-placeholder">
							<label  class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input name="email" type="email" class="form-control"  placeholder="Email" ng-model="member.signUpData.email" required>
							</div>
						</div>
						<div class="form-group input-placeholder">
							<label  class="col-sm-3 control-label">Password</label>
							<div class="col-sm-9">
								<input name="pass" type="password" class="form-control"  placeholder="Password"  id="password-input" ng-model="member.signUpData.password" required>
							</div>
						</div>
						<div class="text-center signup-option">
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<p>
										<a href="" class="terms">
											I agree to the terms &amp; conditions by signing up
										</a>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<a href="" ng-click="openPopup('page', 'signin', 'member-signin', 'popup-lg')">
										Or sign in with Facebook, Twitter, Google or Email
									</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<div class="text-center">
									<button ng-disabled="member.activeAction" type="submit" class="btn-rounded btn-rounded-lg btn-signup">Sign Up</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="help-text text-center">
							<p>
								The Company can be contacted by mail at
								<a class="link-normal" href="mailto:pr@rte.com">[pr@rte.com]</a>.
							</p>
							<p>
								By Signing up, you agree to our
								<a class="text-theme" href="">
									Terms &amp; Conditions
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="signin pp-reg custom-popup" ng-app="app" ng-controller="AccountController as member">
	<div class="container-fluid">
		<div class="row">
			<div class="text-center">
				<div class="">
					<img src="{!! asset('img/rte-logo-blue.png') !!}" class="img-responsive center-block">
					<i class="ion-ios-close-empty close" aria-hidden="true" ng-click="closeThisDialog(0)"></i>
				</div>
				<div class="login-txt">
					<h4>Log in to RTE with</h4>
				</div>
				<ul class="list-unstyled no-margin">

					<li class="margin-b-20">
						<a href="" class="btn btn-social btn-gplus " ng-click="member.signinSocial('google')">
							<i class="fa fa-google-plus icon" aria-hidden="true"></i>  &nbsp;
							Google
						</a>
					</li>
					<li class="margin-b-20">
						<a href="" class="btn  btn-social btn-fb  " ng-click="member.signinSocial('facebook')">
							<i class="fa fa-facebook icon" aria-hidden="true"></i>  &nbsp;
							Facebook
						</a>
					</li>
					<li class="margin-b-20">
						<a href="" class="btn  btn-social btn-twitter  " ng-click="member.signinSocial('twitter')">
							<i class="fa fa-twitter icon" aria-hidden="true"></i>  &nbsp;
							Twitter
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-12 col-xs-12">
				<div class="form-wrapper form-fields text-center">
					<form ng-submit="member.signin(member.signInData, 'signin_form')" id="signin_form" name="signin_form" class="" show-msg="false">
						<div class="form-group input-placeholder">
							<input name="email" validator="required" valid-method="blur" type="email" class="form-control center-block" ng-model="member.signInData.email" required placeholder="Email">
						</div>
						<div class="form-group input-placeholder" >
							<input name="password" validator="required" valid-method="blur" type="password" class="form-control center-block" id="password-input" ng-model="member.signInData.password" required placeholder="Password">
						</div>
						<div class="">
							<div class="row">
								<div class="col-sm-6 col-xs-6">
									<div class="text-center">
										<a href="{{ route('forgotpassword.get')}}" class="forgt-passwrd">
											Forgot Password?
										</a>
									</div>
								</div>
								<div class="col-sm-6 col-xs-6">
										<button type="submit" class="btn-signin btn-rounded  mrgn-left20">Sign In</button>
								</div>
							</div>
						</div>
					</form>
					<div class="text-center new-user">
					<h3>
						OR
					</h3>
						<button class="btn-rounded  btn-theme-drkgrn btn-fullwidth" ng-click="openPopup('page', 'signin', 'member-signup', 'popup-lg'); closeThisDialog(0)">Sign up with email</button>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="help-text text-center">
							<p>
								The Company can be contacted by mail at
								<a class="link-normal" href="mailto:pr@rte.com">[pr@rte.com]</a>.
							</p>
							<p>
								By Logging in, you agree to our
								<a class="text-theme" href="">
									Terms &amp; Conditions
								</a>
							</p>
						</div>
					</div>
				</div>
		</div>
	</div>
</section>
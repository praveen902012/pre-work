@include('page::includes.head')
<section class="bg-grey section-spacing page-height" ng-app="app" ng-controller="AccountController as admin">
	<div class="container">
		<div  class="reg-form-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
						<h2>
						Admin Sign in
						</h2>
						<form  ng-submit="admin.signin(admin.signInData, 'admin/signin')" name="operator_signin_form">
							<div class="form-group">
								<label>
									Email  <span> (हिंदी अनुवाद के अनुसार)</span><span class="mand-field">&nbsp;*</span>
								</label>
								<input validator="required" valid-method="blur" type="email" class="form-control" ng-model="admin.signInData.email" required>
							</div>
							<div class="form-group">
								<label>
									Password  <span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">&nbsp;*</span>
								</label>
								<input validator="required" valid-method="blur" type="password" class="form-control" id="password-input" ng-model="admin.signInData.password" required>
							</div>
							<div class="row">
								<div class="col-md-4 col-xs-12">

									<button type="submit" class="btn-theme">Sign In</button>
								</div>
								<div class="col-md-8 col-xs-12">

								</div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include('page::includes.foot')
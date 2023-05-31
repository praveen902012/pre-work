@include('page::includes.head')
<section class="bg-lt-blue" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div  class="form-lg-wrapper form-fields">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="form-sm-container reset-form">
						<h3>Restricted Access</h3>
						 <form name="access_check" ng-init="msg = 'Authenticationg...' " ng-submit="create('allow-access', formData, 'access_check')">
							<div class="form-field">
								<label>
									Password
								</label>
								<input type="password" class="form-control" ng-model="formData.allowaccess" placeholder="Password" required>
							</div>
							<br>
							<button type="submit" class="btn-rounded btn-rounded-lg btn-signup no-margin">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('page::includes.foot')
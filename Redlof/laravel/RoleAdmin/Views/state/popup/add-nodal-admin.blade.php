<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Add Nodal Administrator
		</h2>
		<div class="popup-rt">
			<span>
				<i class="fa fa-info-circle" aria-hidden="true"></i>
			</span>
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-init="formData.state_id=helper.state_id">
		<form name="admin-nodal-admin"  ng-submit="create('admin/nodaladmin/add', formData, 'admin-nodal-admin')" ng-init="formData.state_slug=helper.state_slug;formData.district_id=helper.district_id;">
			<div class="form-group">
				<label>First Name</label>
				<div>
					<input validator="required" valid-method="blur" ng-model="formData.first_name" type="text" class="form-control" id="first_name" placeholder="Enter your first name" required>
				</div>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<div>
					<input validator="required" valid-method="blur" ng-model="formData.last_name" type="text" class="form-control" id="last_name" placeholder="Enter your last name" required>
				</div>
			</div>
			<div class="form-group">
				<label>Email address</label>
				<div>
					<input validator="required" valid-method="blur" ng-model="formData.email" type="email" class="form-control" id="email" placeholder="Enter email" required>
				</div>
			</div>
			<div class="form-group" class="col-sm-9">
				<label>Phone</label>
				<div>
					<input ng-model="formData.phone" type="tel" class="form-control" id="phone" required placeholder="Enter phone number">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-xs-12">
				</div>
				<div class="col-sm-6 col-xs-12">
					<button type="submit" class="btn-theme pull-right">Submit</button>
				</div>
			</div>
		</form>
	</div>
</section>
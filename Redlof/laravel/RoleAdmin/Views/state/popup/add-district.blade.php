<section class="" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Add District
		</h2>
		<div class="popup-rt">
			<span>
				<i class="fa fa-info-circle" aria-hidden="true"></i>
			</span>
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-init="formData.state_id=helper.state_id">
		<form name="admin-add-district" class="common-form add-area" ng-submit="create('admin/district/add', formData, 'admin-add-district')" ng-init="formData.state_slug=helper.state_slug">

		<div class="form-group">
			<label>District Name</label>
			<div>
				<input validator="required" valid-method="blur" ng-model="formData.name" type="text" class="form-control" id="name" placeholder="Enter District Name" required>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-xs-12">
			</div>
			<div class="col-sm-6 col-xs-12">
				<button type="submit" class="btn-theme pull-right">Add District</button>
			</div>
		</div>
	</form>
</div>
</section>
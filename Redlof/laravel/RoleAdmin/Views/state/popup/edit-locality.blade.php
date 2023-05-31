<section class="pp-addstate">
	<div class="header-popup-ad">
		<h2>
		Edit Locality
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="AppController" ng-init="formData={}">
		<form name="admin-edit-locality" class="common-form add-area" ng-submit="create('admin/state/update/locality', formData, 'admin-edit-locality')">
			<div class="form-group" ng-init="formData.name=helper.name;formData.id=helper.id;">
				<input type="text" class="form-control" ng-model="formData.name">

			</div>

			<div class="row">

				<div class="col-sm-6 col-xs-12">
					<button type="submit" class="btn-theme">Update</button>
				</div>
			</div>
		</form>
	</div>
</section>
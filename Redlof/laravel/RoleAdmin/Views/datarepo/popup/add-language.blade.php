<section class="form-popup">
	<div class="header-popup-ad">
		<h2>
			Add Languages
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="AppController">
		<form name="admin-add-languages" class="common-form add-area" ng-submit="create('admin/language/add', formData, 'admin-add-languages')">
			<div class="form-group">
				<label>
					Name:
				</label>
				<input validator="required" valid-method="blur" type="text" name="name" ng-model="formData.name" ng-required="true" class="form-control">
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
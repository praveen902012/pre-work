<section class="form-popup">
	<div class="header-popup-ad">
		<h2>
			Add Nodal Admin
		</h2>
		<div class="popup-rt">
		<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="AppController">
		<form name="districtadmin-add-school" class="common-form add-area" ng-submit="create('districtadmin/school/add', formData, 'districtadmin-add-school')">
			<div class="form-group">
				<label>
					Name:
				</label>
				<input validator="required" valid-method="blur" type="text" name="name" ng-model="formData.name" ng-required="true" class="form-control">
			</div>

			<div class="form-group form-field">
				<label>
					Image:
				</label>
				<div ngf-drop ngf-select ng-model="formData.image" class="drop-box center-block"
				ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
			</div>
			<div ngf-no-file-drop>
				File Drag/Drop is not supported for this browser
			</div>

			<div class="text-center">
			<img width="300" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="formData.image" />
			</div>
		</div>

		<div class="form-group">
			<label>
				Phone:
			</label>
			<input validator="required" valid-method="blur" type="text" name="phone" ng-model="formData.phone" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Website:
			</label>
			<input validator="required" valid-method="blur" type="text" name="website" ng-model="formData.website" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Address:
			</label>
			<input validator="required" valid-method="blur" type="text" name="address" ng-model="formData.address" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Locality:
			</label>
			<input validator="required" valid-method="blur" type="text" name="locality" ng-model="formData.locality" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Sub-locality:
			</label>
			<input validator="required" valid-method="blur" type="text" name="sub
			_locality" ng-model="formData.sub_locality" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Sub-sub-locality:
			</label>
			<input validator="required" valid-method="blur" type="text" name="sub_sub_locality" ng-model="formData.sub_sub_locality" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Latitude:
			</label>
			<input validator="required" valid-method="blur" type="text" name="latitude" ng-model="formData.lat" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Longitude:
			</label>
			<input validator="required" valid-method="blur" type="text" name="longitude" ng-model="formData.lng" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Pincode:
			</label>
			<input validator="required" valid-method="blur" type="text" name="pincode" ng-model="formData.pincode" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				Status:
			</label>
			<input validator="required" valid-method="blur" type="text" name="status" ng-model="formData.status" ng-required="true" class="form-control">
		</div>
		<div class="form-group">
			<label>
				Application Status:
			</label>
			<input validator="required" valid-method="blur" type="text" name="application_status" ng-model="formData.application_status" ng-required="true" class="form-control">
		</div>

		<div class="form-group">
			<label>
				State ID:
			</label>
			<input validator="required" valid-method="blur" type="text" name="state_id" ng-model="formData.state_id" ng-required="true" class="form-control">
		</div>



		<button type="submit" class="btn-theme">Submit</button>
	</form>
</div>
</section>
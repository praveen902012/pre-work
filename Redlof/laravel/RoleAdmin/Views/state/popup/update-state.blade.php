<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad" ng-init="getAPIData('admin/state/details/'+[[helper.state_id]], 'formData')">
		<h2>
		Update State
		</h2>
		<div class="popup-rt">
			<span>
				<i class="fa fa-info-circle" aria-hidden="true"></i>
			</span>
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
		<form name="admin-update-states" class="common-form add-area" ng-submit="create('admin/state/update', formData, 'admin-update-states')">
			<div class="form-group">
				<label>
					Name:
				</label>
				<input validator="required" valid-method="blur" type="text" name="name" ng-model="formData.name" ng-required="true" class="form-control">
			</div>
			<div class="form-group">
				<label>
					Language
				</label>
				<ui-select ng-model="formData.language_id" theme="select2" ng-init="getDropdown('admin/get/languages/list', 'languages')">
				<ui-select-match placeholder="Select language">
				[[$select.selected.name]]
				</ui-select-match>
				<ui-select-choices repeat="item.id as item in languages | filter:$select.search">
				[[item.name]]
				</ui-select-choices>
				</ui-select>
			</div>
			<div class="form-group">
				<label>
					Image:
				</label>
				<div ngf-drop ngf-select ng-model="formData.image" class="drop-box center-block"
					ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
				</div>
				<div ngf-no-file-drop>
					File Drag/Drop is not supported for this browser
				</div>
				<div class="text-center" ng-if="formData.image">
					<img width="300" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="formData.image" />
				</div>
				<div class="text-center" ng-if="!formData.image">
					<img width="300" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ng-src="[[formData.fmt_logo]]" />
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
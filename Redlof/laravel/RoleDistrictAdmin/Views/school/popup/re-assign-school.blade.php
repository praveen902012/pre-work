<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Re-Assign School
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div ng-init="formData={};getAPIData('districtadmin/get/school/nodal/'+helper.school_id,'nodal')">
		<div class="popup-content-ad" ng-init="formData.school_id=helper.school_id">
			<form name="admin-add-school" class="common-form add-area" ng-submit="create('districtadmin/school/re-assign', formData)">

				<p>This School as been assigned to: <b>[[nodal.nodaladmin.user.email]]</b></p>

				<div class="form-group" ng-init="getDropdown('districtadmin/assign/nodaladmin/'+[[helper.district_id]], 'nodaladmins')">

					<label>Select new nodal admin to assign</label>
					<ui-select class="custom_ui_select" ng-model="formData.nodal_id" theme="selectize">
					<ui-select-match>
					[[$select.selected.user.display_name]]
					</ui-select-match>
					<ui-select-choices repeat="item.id as item in nodaladmins | filter: $select.search | orderBy: 'name' ">
					[[item.user.display_name]]
					</ui-select-choices>
					</ui-select>
				</div>
				<div class="form-group">
					<button class="btn-theme" type="submit">
					Re-Assign
					</button>
				</div>
			</form>
		</div>
	</div>
</section>
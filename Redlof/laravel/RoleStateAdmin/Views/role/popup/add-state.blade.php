<section class="form-popup" ng-controller="AppController">
	<div class="header">
		<h2>
		Add State
		</h2>
	</div>
	<div class="body" ng-init="formData = {}">
		<form name="admin-add-states" class="common-form add-area" ng-submit="createWithReset('admin/state/add', formData, 'admin-add-states')">
			<div class="form-group">
				<label>
					Name:
				</label>
				<input validator="required" valid-method="blur" type="text"  name="name" ng-model="formData.name" ng-required="true" class="form-control">
			</div>
			<div class="form-group">
				<label>
					Code:
				</label>
				<input validator="required" valid-method="blur" type="text" name="name" ng-model="formData.code" ng-required="true" class="form-control">
			</div>
			<div class="form-group" ng-init="getDropdown('admin/countries/list/all', 'Types')">
				<label>Select Country</label>
				<ui-select class="custom_ui_select" ng-model="formData.country_id" theme="selectize">
				<ui-select-match>
				[[$select.selected.name]]
				</ui-select-match>
				<ui-select-choices repeat="item.id as item in Types | filter: $select.search | orderBy: 'name' ">
				[[item.name]]
				</ui-select-choices>
				</ui-select>
			</div>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	</section>
<section class="pp-addstate">
	<div class="header-popup-ad">
		<h2>
			Add Cluster
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="AppController" ng-init="formData={}">
		<form name="admin-add-locality" class="common-form add-area" ng-submit="create('admin/state/add/cluster', formData, 'admin-add-locality')">
			<div class="form-group">
				<label>
					States
				</label>
				<ui-select class="" ng-model="formData.state_id" theme="select2" ng-init="getDropdown('admin/get/states/all', 'states')">
					<ui-select-match placeholder="Select state">
						[[$select.selected.name]]
					</ui-select-match>
					<ui-select-choices repeat="item in states | filter:$select.search">
						[[item.name]]
					</ui-select-choices>
				</ui-select>
			</div>
			<div class="form-group">
				<label>
					Select District:
				</label>
				<ui-select class="" ng-model="formData.district_id" theme="select2" ng-click="getDropdown('admin/get/districts/'+[[formData.state_id.id]], 'districts')">
					<ui-select-match placeholder="Select district">
						[[$select.selected.name]]
					</ui-select-match>
					<ui-select-choices repeat="item.id as item in districts | filter:$select.search">
						[[item.name]]
					</ui-select-choices>
				</ui-select>
			</div>
			<div class="form-group">
				<label>
					Select Block:
				</label>
				<ui-select class="" ng-model="formData.block_id" theme="select2" ng-click="getDropdown('admin/get/blocks/'+[[formData.district_id]], 'blocks')" >
				<ui-select-match placeholder="Select block">
				[[$select.selected.name]]
				</ui-select-match>
				<ui-select-choices repeat="item.id as item in blocks | filter:$select.search">
				[[item.name]]
				</ui-select-choices>
				</ui-select>
			</div>

			<div class="form-group">
				<label>
					Enter Cluster Name
				</label>
				<input type="text" class="form-control" ng-model="formData.cluster_name" placeholder="Enter cluster name">
			</div>
			<div class="form-group text-center">
				<label>
					OR
				</label>

				<div class="form-group">
					<div ng-init="formData.event_id = helper.event_id">
						<label class="text-sky"> Choose your CSV File </label>
					</div>
					<button type="button" class="btn btn-primary" ngf-select ng-model="formData.file" ngf-multiple="false" accept=".csv" ngf-pattern="'.csv'">
						Select File
					</button>
					<div class="div-ib" ng-if="formData.file">
						<span ng-bind="formData.file.name"></span>
						<i ng-click="formData.file = null" class="fa fa-times icon_del" aria-hidden="true"></i>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
					</div>
					<div class="col-sm-6 col-xs-12">
						<button type="submit" class="btn-theme pull-right">Upload</button>
					</div>
				</div>
		</form>
	</div>
</section>
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
		<form name="stateadmin-nodal-admin"  ng-submit="create('stateadmin/add/nodaladmin', formData, 'stateadmin-nodal-admin')" ng-init="formData.state_slug=helper.state_slug">
			<div class="form-group">
				<label>
					Districts
				</label>
				<ui-select class="" ng-model="formData.district_id" theme="select2" ng-init="getDropdown('stateadmin/get/districts/'+[[helper.state_id]], 'districts')" >
				<ui-select-match placeholder="Select District">
				[[$select.selected.name]]
				</ui-select-match>
				<ui-select-choices repeat="item.id as item in districts | filter:$select.search">
				[[item.name]]
				</ui-select-choices>
				</ui-select>
			</div>
			<div class="form-group">
				<label>First Name</label>
				<div>
					<input valid-method="blur" ng-model="formData.first_name" type="text" class="form-control" id="first_name" placeholder="Enter your first name">
				</div>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<div>
					<input valid-method="blur" ng-model="formData.last_name" type="text" class="form-control" id="last_name" placeholder="Enter your last name">
				</div>
			</div>
			<div class="form-group">
				<label>Email address</label>
				<div>
					<input valid-method="blur" ng-model="formData.email" type="email" class="form-control" id="email" placeholder="Enter email">
				</div>
			</div>
			<div class="form-group" class="col-sm-9">
				<label>Phone</label>
				<div>
					<input ng-model="formData.phone" type="tel" class="form-control" id="phone" placeholder="Enter phone number">
				</div>
			</div>

			<div class="form-group text-center">
				<label>OR</label>
			</div>
			<div class="form-group text-center"></div>
			<div class="form-group">
				<div ng-init="formData.event_id = helper.event_id">
					<label class="text-sky"> Choose your CSV File </label>
				</div>
				<button type="button" class="btn btn-primary" ngf-select ng-model="formData.file" ngf-multiple="false" accept=".csv" ngf-pattern="'.csv'">
					Select File
				</button>
				<div class="div-ib" ng-if="formData.file">
					<div class="form-group"></div>
					<span ng-bind="formData.file.name"></span>
					<i ng-click="formData.file = null" class="fa fa-times icon_del" aria-hidden="true"></i>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-xs-12">
				</div>
				<div class="col-sm-6 col-xs-12">
					<button ng-disabled="inProcess" type="submit" class="btn-theme pull-right">
						<span ng-if="!inProcess">Submit</span>
						<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>

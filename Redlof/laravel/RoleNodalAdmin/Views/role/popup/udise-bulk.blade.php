<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Upload CSV
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
			<form name="upload-csv"  ng-submit="create('nodaladmin/add/bulk-udise', uploadData, 'upload-csv')" ng-init="uploadData.district_id = helper.district_id">
				<div class="row">
					<div class="col-sm-12">
						<div class="bulk_upload padding-50">
							<div class="text-center">
								<div ng-init="uploadData.event_id = helper.event_id">
									<label class="text-sky"> Choose your CSV File </label>
								</div>
								<button type="button" class="btn btn-primary" ngf-select ng-model="uploadData.file" ngf-multiple="false" accept=".csv" ngf-pattern="'.csv'">
								Select File
								</button>
								<div class="div-ib" ng-if="uploadData.file">
									<span ng-bind="uploadData.file.name"></span>
									<i ng-click="uploadData.file = null" class="fa fa-times icon_del" aria-hidden="true"></i>
								</div>
								<button type="submit" class="btn btn-success">
								Upload
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
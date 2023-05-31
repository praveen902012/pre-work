<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Add Udise
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
		<form name="upload-csv"  ng-submit="create('nodaladmin/add/udise', formData, 'upload-csv')">
			<div class="row">
				<div class="col-sm-12">
					<div class="bulk_upload padding-50">
						<div class="form-group no-padding">
							<label for="name">Enter Udise</label>
							<input type="text" name="udise"  class="form-control" class="form-control" ng-model="formData.udise" placeholder="Udise" required="true">
						</div>
						<button type="submit" name="button" class="btn btn-success">
						Add Udise
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Confirm rejection
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-init="formData.state_id=helper.state_id">
		Please choose your reason for rejection -
		<form name="reject"  ng-submit="create('schooladmin/student/reject', formData, 'reject')" ng-init="formData.registration_id=helper.registration_id">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="radio">
						<label><input  validator="required" valid-method="blur" ng-model="formData.reason" type="radio" value="Did not report">Did not report</label>
					</div>
					{{-- <div class="radio">
						<label><input  validator="required" valid-method="blur" ng-model="formData.reason" type="radio" value="No document" >No document</label>
					</div>
					<div class="radio">
						<label><input  validator="required" valid-method="blur" ng-model="formData.reason" type="radio" value="False document" >False document</label>
					</div> --}}
					<div ng-show="formData.reason == 'False document'">
						<div class="form-group">
							<label for="comment">Reason:</label>
							<textarea class="form-control" rows="3" placeholder="Please write your reason" ng-model="formData.rejected_reason"></textarea>
						</div>
						<div class="text-center">
							<label>Please upload the scanned document submited by the student.</label>
						</div>
						<div class="form-group col-sm-12 no-padding">
							<div ngf-drop ngf-select ng-model="formData.rejected_document" class="drop-box center-block" ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="file_extension|image/*" ngf-pattern="'image/*,.pdf'">Click Or Drop Here</div>
							<div class="center-block" ngf-no-file-drop>
								File Drag/Drop is not supported for this browser
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 col-xs-12">
							</div>
							<div class="text-center col-sm-6 col-xs-12" ng-if="formData.rejected_document">
								<span ng-bind="formData.rejected_document.name"></span>
								<i ng-click="formData.rejected_document = null" class="fa fa-times icon_del" aria-hidden="true"></i>
							</div>
							<div class="col-sm-3 col-xs-12">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-danger">Reject</button>
					<button ng-click="closeThisDialog()" class="btn btn-default">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</section>
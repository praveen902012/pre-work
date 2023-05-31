<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Add Image
		</h2>
		<div class="popup-rt">
				<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
			</div>
	</div>

	<div class="popup-content-ad">

		<form name="add-image" class="common-form add-area" ng-submit="create('stateadmin/gallery/addImage/'+[[helper.state_id]], formData, 'add-image')">
			<div id="primary">

				<div class="col-sm-12 col-xs-12">

					<div class="text-center">
						<div class="form-group">

							<label>
								Select Image
							</label>
							<div class="form-group">
								<div ngf-drop ngf-select ng-model="formData.image" class="drop-box center-block"
								ngf-drag-over-class="dragover" ngf-multiple="true" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
							</div>

							<div ngf-no-file-drop>
								File Drag/Drop is not supported for this browser
							</div>
							<span>Image size should not exceed 1 mb</span>
						</div>

					</div>
				</div>


			</div>
			<div class="text-center">
				<img width="300" ng-repeat="photo in formData.image" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="photo" />
				[[photo]]
			</div>

			<div class="row">
				<div class="text-center col-sm-12 col-xs-12">
					<button ng-disabled="inProcess" type="submit" class="btn-theme">
						<span ng-if="!inProcess">Add Image</span>
						<span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
</section>
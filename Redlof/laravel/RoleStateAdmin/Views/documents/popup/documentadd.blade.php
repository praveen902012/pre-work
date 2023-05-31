<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Add Documents
		</h2>
		<div class="popup-rt">
            <i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
        </div>
	</div>

	<div class="popup-content-ad">

		<form name="add-image" class="common-form add-area" ng-submit="create('stateadmin/document/upload', formData)">
			<div id="primary" style="display: flow-root;">

				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>
							Title
						</label>
						<input type="text" name="title" ng-model="formData.title" class="form-control">
					</div>
				</div>

				<div class="col-sm-12 col-xs-12">

					<div class="text-center">
						<div class="form-group">

							<label>
								Select Document
							</label>
							<div class="form-group">
								<div ngf-drop ngf-select ng-model="formData.image_file" class="drop-box center-block"
								ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept=".pdf" ngf-pattern="'.pdf'">Click Or Drop Here
							</div>
							
							<p>[[formData.image_file.name]]</p>
							
							<div ngf-no-file-drop>
								File Drag/Drop is not supported for this browser
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group text-center">
						<label>
							Select Document Image
						</label>
						<div class="form-group">
							<div ngf-drop ngf-select ng-model="formData.doc_image_file" class="drop-box center-block"
							ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
						</div>
						<p>[[formData.doc_image_file.name]]</p>
					</div>
				</div>
			</div>
			<div class="text-center">
				<img width="300" style="margin:8px auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="formData.doc_image_file" />			
			</div>

			<div class="row">
				<div class="text-center col-sm-12 col-xs-12">
					<button ng-disabled="inProcess" type="submit" class="btn-theme">
						<span ng-if="!inProcess">Add document</span>
						<span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
</section>
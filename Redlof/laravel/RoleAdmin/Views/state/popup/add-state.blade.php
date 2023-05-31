<section class="pp-addstate">
	<div class="header-popup-ad">
		<h2>
		Add State
		</h2>
		<div class="popup-rt">
			<span>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>
<a    data-placement="right" data-toggle="popover" title="Information" data-content="India is a country located in southern Asia. With over 1.3 billion people, India is the most populous democracy in the world. It is a federal constitutional republic governed under a parliamentary system consisting of 29 states and 7 union territories."><i class="fa fa-info-circle" aria-hidden="true"></i></a>
			</span>
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad" ng-controller="AppController" ng-init="formData={}">
		<form name="admin-add-states" class="common-form add-area" ng-submit="create('admin/state/add', formData, 'admin-add-states')">
			<div class="form-group">
				<label>
					States
				</label>
				<ui-select class="" ng-model="formData.state_id" theme="select2" ng-init="getDropdown('admin/get/states/newlist', 'states')" >
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
					Primary language:
				</label>
				<ui-select class="" ng-model="formData.language" theme="select2" ng-init="getDropdown('admin/get/languages/list', 'languages')" >
				<ui-select-match placeholder="Select language">
				[[$select.selected.name]]
				</ui-select-match>
				<ui-select-choices repeat="item in languages | filter:$select.search">
				[[item.name]]
				</ui-select-choices>
				</ui-select>
			</div>
			<div class="form-group">
				<label>
					Logo for the State:
				</label>
				<div ngf-drop ngf-select ng-model="formData.image" class="drop-box"
					ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
				</div>
				<div ngf-no-file-drop>
					File Drag/Drop is not supported for this browser
				</div>
				<div class="text-center">
					<img width="300" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="formData.image" />
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
<section class="form-popup" ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
		Add new subject
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div ng-controller="SubjectController as Subject">
		<div class="popup-content-ad" ng-init="Subject.getLevels()">
			<form name="add-subject" class="common-form add-area" ng-submit="create('schooladmin/subject/add', Subject.formData, 'add-subject')">
				<div class="form-group">
					<label>Select Class
					</label>
					<ui-select ng-model="Subject.formData.level_id" theme="select2">
					<ui-select-match placeholder="Select">
					[[$select.selected.level]]
					</ui-select-match>
					<ui-select-choices repeat="item.id as item in Subject.classes | filter:$select.search">
					[[item.level]]
					</ui-select-choices>
					</ui-select>
				</div>
				<div class="form-group">
					<label>Subject Name</label>
					<div  ng-repeat="subject in Subject.formData.subjects" >
						<div  class="form-group">
							<div class="form-inline">
								<input validator="required" valid-method="blur" ng-model="subject.name" type="text" class="form-control" id="subject" placeholder="Subject name" required>
								<button class="btn btn-danger" ng-click="Subject.formData.subjects.splice($index,1)" type="button"  ng-if="Subject.formData.subjects.length>1" >
								<i class="fa ion-ios-minus-outline remove-ref" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
					<button ng-click="Subject.addSubject()" type="button" class="btn btn-primary">
					<i class="fa ion-ios-plus-outline add" aria-hidden="true"></i>
					</button>
				</div>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
					</div>
					<div class="col-sm-6 col-xs-12">
						<button type="submit" class="btn-theme pull-right">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
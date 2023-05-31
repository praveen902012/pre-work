<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Change Student DOB
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

	<div class="popup-content-ad" ng-controller="Step1Controller as Step1"> 

		<form name="stateadmin-student-status-change" class="common-form add-area" ng-submit="create('stateadmin/script/student/dob/update', formData)">
			<div id="primary">
				<div class="row">
					<div class="col-xs-12">
                        <div class="form-group" ng-init="formData={};formData.dob={};formData.id=helper.studentData.id">
                            <label>
                                Date Of Birth <span class="mand-field">*</span>&nbsp;<i
                                    class="ico-tip fa fa-question-circle" aria-hidden="true"
                                    data-toggle="tooltip"></i>
                                <p class="hindi-lbl">
                                    [[helper.studentData.dob]]
                                </p>
                            </label>
                            <div class="row">
                                <div class="col-sm-2 col-xs-12" ng-init="Step1.getDates()">
                                    <ui-select class="" ng-model="formData.dob.date" theme="select2">
                                        <ui-select-match placeholder="Date">
                                            [[$select.selected.date]]
                                        </ui-select-match>
                                        <ui-select-choices
                                            repeat="item.id as item in Step1.dates | filter:$select.search">
                                            [[item.date]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <ui-select class="" ng-model="formData.dob.month" theme="select2"
                                        ng-init="Step1.getMonths()">
                                        <ui-select-match placeholder="Month">
                                            [[$select.selected.month]]
                                        </ui-select-match>
                                        <ui-select-choices
                                            repeat="item.id as item in Step1.months | filter:$select.search">
                                            [[item.month]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <div class="col-sm-3 col-xs-12" ng-init="Step1.getYears()">
                                    <ui-select class="" ng-model="formData.dob.year" theme="select2">
                                        <ui-select-match placeholder="Year">
                                            [[$select.selected.year]]
                                        </ui-select-match>
                                        <ui-select-choices
                                            repeat="item.year as item in Step1.years | filter:$select.search">
                                            [[item.year]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<button ng-disabled="inProcess" type="submit" class="btn-theme pull-right">
						<span ng-if="!inProcess">Save</span>
						<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>
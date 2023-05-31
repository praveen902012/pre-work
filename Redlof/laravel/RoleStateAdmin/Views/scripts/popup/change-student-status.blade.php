<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Change Student Status
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

	<div class="popup-content-ad">

		<form name="stateadmin-student-status-change" class="common-form add-area" ng-submit="create('stateadmin/script/student/status/update', helper.studentData)">
			<div id="primary">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group" ng-init="statusTypes=['applied', 'dismissed', 'rejected', 'withdraw', 'dropout']">
							<label>
								Allotment status *
							</label>
                            <ui-select class="custom_ui_select" ng-model="helper.studentData.registration_cycle.status" theme="selectize">
                                <ui-select-match>
                                    [[$select.selected]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in statusTypes | orderBy: 'name' ">
                                    [[item]]
                                </ui-select-choices>
                            </ui-select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group" ng-init="veriStatusTypes=['verified', 'rejected', 'pending']">
							<label>
								Document verification status *
							</label>
                            <ui-select class="custom_ui_select" ng-model="helper.studentData.registration_cycle.document_verification_status" theme="selectize">
                                <ui-select-match>
                                    [[$select.selected]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in veriStatusTypes | orderBy: 'name' ">
                                    [[item]]
                                </ui-select-choices>
                            </ui-select>
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
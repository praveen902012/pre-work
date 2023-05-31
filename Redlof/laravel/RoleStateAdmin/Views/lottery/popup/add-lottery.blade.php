<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Lottery Settings
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

	<div class="popup-content-ad" ng-controller="LotteryController as Lottery">
		<div ng-init="Lottery.getPreviousLotteries('stateadmin/lottery')">
			<form name="stateadmin-add-lottery" class="common-form add-area" ng-submit="create('stateadmin/lottery', formData, 'stateadmin-add-lottery')" ng-init="formData={};formData.is_school_reg='Yes'">
				<div id="primary">
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<div class="form-group">
								<label>
									Year *
								</label>
								<input validator="required" valid-method="blur" type="number" name="session_year" ng-model="formData.session_year" ng-required="true" class="form-control">
							</div>
						</div>
						<div class="col-sm-6 col-xs-12">
							<div class="form-group" ng-if="formData.session_year>1000">
								<label>
									&nbsp;
								</label>
								<input validator="required" valid-method="blur" type="number" name="session_year" ng-required="true" class="form-control" value="[[formData.session_year + 1]]" disabled="">
							</div>
						</div>

						<div class="col-sm-6 col-xs-6" ng-if="Lottery.previousLotterySessions.includes(formData.session_year)" style="margin-bottom: 30px;">
							<label>
								Please select cycle
							</label>
							<ui-select class="" ng-model="formData.cycle" theme="select2" ng-init="cycles=[2,3]">
								<ui-select-match placeholder="Select Cycle">
									[[$select.selected]]
								</ui-select-match>
								<ui-select-choices repeat="item in cycles | filter:$select.search">
									[[item]]
								</ui-select-choices>
							</ui-select>
							<small style="color: red">
								We found there is already a lottery present for session [[formData.session_year]]
							</small>
						</div>

						<div class="col-sm-6 col-xs-6" ng-if="Lottery.previousLotterySessions.includes(formData.session_year)">
							<label>
								Allow school registration  
							</label>
							<ui-select class="" ng-model="formData.is_school_reg" theme="select2" ng-init="schoolRegs=['No', 'Yes']">
								<ui-select-match placeholder="Select">
									[[$select.selected]]
								</ui-select-match>
								<ui-select-choices repeat="item in schoolRegs | filter:$select.search">
									[[item]]
								</ui-select-choices>
							</ui-select>
						</div>

						<div class="col-sm-12 col-xs-12" ng-if="formData.is_school_reg=='Yes'">
							<div class="form-group">
								<label>
									School Registration Start Date *
								</label>
								<input validator="required" valid-method="blur" type="text" name="reg_start_date" ng-model="formData.reg_start_date" ng-required="true" class="form-control" id="reg_start_date" ng-init="showFlatpickerForDate('reg_start_date')" autocomplete="off" >
							</div>
						</div>

						<div class="col-sm-12 col-xs-12" ng-if="formData.is_school_reg=='Yes'">
							<div class="form-group">
								<label>
									School Registration End Date
								</label>
								<input valid-method="blur" type="text" name="reg_end_date" ng-model="formData.reg_end_date" class="form-control" ng-init="showFlatpickerForDate('reg_end_date')" autocomplete="off" id="reg_end_date">
							</div>
						</div>

						<div class="col-sm-12 col-xs-12">
							<div class="form-group">
								<label>
									Student Registration Start Date *
								</label>
								<input validator="required" valid-method="blur" type="text" name="stu_reg_start_date" ng-model="formData.stu_reg_start_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('stu_reg_start_date')" autocomplete="off" id="stu_reg_start_date">
							</div>
						</div>

						<div class="col-sm-12 col-xs-12">
							<div class="form-group">
								<label>
									Student Registration End Date *
								</label>
								<input validator="required" valid-method="blur" type="text" name="stu_reg_end_date" ng-model="formData.stu_reg_end_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('stu_reg_end_date')" autocomplete="off" id="stu_reg_end_date">
							</div>
						</div>

						<div class="col-sm-12 col-xs-12">
							<div class="form-group">
								<label>
									Lottery Announcement Date *
								</label>
								<input validator="required" valid-method="blur" type="text" name="lottery_announcement" ng-model="formData.lottery_announcement" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('lottery_announcement')" autocomplete="off" id="lottery_announcement">
							</div>
						</div>
						<div class="col-sm-12 col-xs-12">
							<div class="form-group">
								<label>
									Enrollment End Date *
								</label>
								<input validator="required" valid-method="blur" type="text" name="enrollment_end_date" ng-model="formData.enrollment_end_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('enrollment_end_date')" autocomplete="off" id="enrollment_end_date">
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
	</div>
</section>
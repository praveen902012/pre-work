<section ng-controller="AppController" ng-cloak>
	<div class="header-popup-ad">
		<h2>
			Edit Lottery Settings
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

	<div class="popup-content-ad" ng-controller="LotteryController as Lottery" ng-init="Lottery.editLottery([[helper.lottery_id]])">

		<form name="stateadmin-edit-lottery" class="common-form add-area" ng-submit="create('stateadmin/lottery/edit/'+[[helper.lottery_id]], Lottery.formData, 'stateadmin-edit-lottery')">
			<div id="primary">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>
								Year *
							</label>
							<input validator="required" valid-method="blur" type="number" name="session_year" ng-model="Lottery.formData.session_year" ng-required="true" class="form-control" disabled>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group" ng-if="Lottery.formData.session_year>1000">
							<label>
								&nbsp;
							</label>
							<input validator="required" valid-method="blur" type="number" name="session_year" ng-required="true" class="form-control" value="[[Lottery.formData.session_year + 1]]" disabled="">
						</div>
					</div>
					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								School Registration Start Date *
							</label>
							<input validator="required" valid-method="blur" type="text" name="reg_start_date" ng-model="Lottery.formData.reg_start_date" ng-required="true" class="form-control" id="reg_start_date" ng-init="showFlatpickerForDate('reg_start_date')" autocomplete="off" disabled>

						</div>
					</div>

					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								School Registration End Date
							</label>
							<input valid-method="blur" type="text" name="reg_end_date" ng-model="Lottery.formData.reg_end_date" class="form-control" ng-init="showFlatpickerForDate('reg_end_date')" autocomplete="off" id="reg_end_date">
						</div>
					</div>

					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								Student Registration Start Date *
							</label>
							<input validator="required" valid-method="blur" type="text" name="stu_reg_start_date" ng-model="Lottery.formData.stu_reg_start_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('stu_reg_start_date')" autocomplete="off" id="stu_reg_start_date">
						</div>
					</div>

					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								Student Registration End Date *
							</label>
							<input validator="required" valid-method="blur" type="text" name="stu_reg_end_date" ng-model="Lottery.formData.stu_reg_end_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('stu_reg_end_date')" autocomplete="off" id="stu_reg_end_date">
						</div>
					</div>

					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								Lottery Announcement Date *
							</label>
							<input validator="required" valid-method="blur" type="text" name="lottery_announcement" ng-model="Lottery.formData.lottery_announcement" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('lottery_announcement')" autocomplete="off" id="lottery_announcement">
						</div>
					</div>


					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label>
								Enrollment End Date *
							</label>
							<input validator="required" valid-method="blur" type="text" name="enrollment_end_date" ng-model="Lottery.formData.enrollment_end_date" ng-required="true" class="form-control" ng-init="showFlatpickerForDate('enrollment_end_date')" autocomplete="off" id="enrollment_end_date">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<button ng-disabled="inProcess" type="submit" class="btn-theme pull-right">
						<span ng-if="!inProcess">Save Changes</span>
						<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>
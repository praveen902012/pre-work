<div class="notification_users">
	<div class="row hide_element" element-init>
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="form-group form_field">
						<label class="">Select Filter</label>
						<select class="form-control" ng-model="Notification.student_filter" ng-change="Notification.getStudentCount(Notification.student_filter)">
							<option value="">
								Select filter
							</option>
							<option value="applied">
								Applied Students
                            </option>
							<option value="verified">
								Verified Students
							</option>
							<option value="allotted">
								Allotted Students
							</option>
                            <option value="enrolled">
								Enrolled Students
                            </option>
						</select>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="alert alert-success text-center">
						<strong>[[Notification.student_count]]</strong> Student<span ng-if="Notification.student_count!=1">s</span> selected
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
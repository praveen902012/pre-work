<div class="notification_users">
	<div class="row hide_element" element-init>
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="form-group form_field">
						<label class="">Select Filter</label>
						<select class="form-control" ng-model="Notification.search_filter" ng-change="Notification.getSchoolCount(Notification.search_filter)">
							<option value="">
								Select filter
							</option>
							<option value="applied">
								Applied Schools
							</option>
							<option value="registered">
								Registered Schools
							</option>
							<option value="verified">
								Verified Schools
							</option>
							<option value="rejected">
								Rejected Schools
							</option>
							<option value="ban">
								Banned Schools
							</option>
						</select>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="alert alert-success text-center">
						<strong>[[Notification.school_count]]</strong> school<span ng-if="Notification.school_count!=1">s</span> selected
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
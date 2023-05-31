<section ng-controller="AppController">
	<div class="header-popup-ad" ng-init="getAPIData('stateadmin/get/lottery-details/'+[[helper.lottery_id]], 'lottery_details')">
		<h2>
		Lottery Completion Statistics
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>
	<div class="popup-content-ad">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td><b>Type</b></td>
					<td><b>Stats</b></td>
				</tr>
			</thead>
			<tbody>
				{{-- <tr>
					<td>Total Applied Students</td>
					<td>[[lottery_details.total_applied_students]]</td>
				</tr> --}}
				<tr>
					<td>Total Allotted Students</td>
					<td>
						<span ng-if="lottery_details.session_year == 2021">
							<span ng-if="lottery_details.cycle == 1">
								8490
							</span>
							<span ng-if="lottery_details.cycle != 1">
								1937
							</span>
						</span>
						<span ng-if="lottery_details.session_year != 2021">
							[[lottery_details.total_allotted_students]]
						</span>
					</td>
				</tr>
				{{--<tr>
					<td>Total Unallotted Students For Pre-Primary</td>
					<td>[[lottery_details.total_unallotted_students_for_pre_primary]]</td>
				</tr>
				<tr>
					<td>Total Unallotted Students For Class 1</td>
					<td>[[lottery_details.total_unallotted_students_for_class_one]]</td>
				</tr>
				 <tr>
					<td>Total Seats left for Class 1</td>
					<td>[[lottery_details.total_seats_left_for_class_one]]</td>
				</tr>
				<tr>
					<td>Total Seats left for Pre-Primary</td>
					<td>[[lottery_details.total_seats_left_for_pre_primary]]</td>
				</tr> --}}
			</tbody>
		</table>
	</div>
</section>
@extends('stateadmin::includes.layout')
@section('content')
<div  class="dashboard_stats page-height">
	<div class="row" ng-controller="NotificationController as Notification">
		<div class="col-xs-8">
			<div class="popup-notification">
				<div class="panel panel-default">
					<div class="panel-heading">
						SMS Notifications for Schools
					</div>
					<div class="panel-body">
						<div class="container-fluid">
							<div class="row" >
								<form name="addnotification" class="common-form addnotification" ng-submit="Notification.triggerSMSNotification('school')">
									<div class="row" ng-init="Notification.notificationData.type='sms'">
										<div class="col-sm-12">
											<div class="form-group form_field custom_editor">
												<label>
													Content
												</label>
												<textarea class="form-control" ng-model="Notification.notificationData.content" rows="5" placeholder="Write your sms contet here..." required>
												</textarea>
											</div>
										</div>
									</div>
									<div class="text-right" ng-cloak>
										<button type="submit" ng-disabled="Notification.disable_trigger_btn || Notification.processing" class="btn btn-primary">
										<span ng-if="!Notification.processing">Trigger Notification</span>
										<span ng-if="Notification.processing">Sending <i class="fa fa-circle-o-notch fa-spin"></i></span>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			@include('stateadmin::notifications.include-users-select')
		</div>

		<hr>

		<div class="col-xs-8">
			<div class="popup-notification">
				<div class="panel panel-default">
					<div class="panel-heading">
						SMS Notifications for Students
					</div>
					<div class="panel-body">
						<div class="container-fluid">
							<div class="row" >
								<form name="addnotification" class="common-form addnotification" ng-submit="Notification.triggerSMSNotification('student')">
									<div class="row" ng-init="Notification.notificationData.type='sms'">
										<div class="col-sm-12">
											<div class="form-group form_field custom_editor">
												<label>
													Content
												</label>
												<textarea class="form-control" ng-model="Notification.notificationData.student_content" rows="5" placeholder="Write your sms content here..." required>
												</textarea>
											</div>
										</div>
									</div>
									<div class="text-right" ng-cloak>
										<button type="submit" ng-disabled="Notification.disable_student_trigger_btn || Notification.processing" class="btn btn-primary">
										<span ng-if="!Notification.processing">Trigger Notification</span>
										<span ng-if="Notification.processing">Sending <i class="fa fa-circle-o-notch fa-spin"></i></span>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			@include('stateadmin::notifications.include-students-select')
		</div>
	</div>
</div>
@endsection
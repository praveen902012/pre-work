@extends('stateadmin::includes.layout')
@section('content')
<div  class="dashboard_stats page-height">
	<div class="row" ng-controller="NotificationController as Notification">
		<div class="col-xs-8">
			<div class="popup-notification">
				<div class="panel panel-default">
					<div class="panel-heading">
						Email Notifications
					</div>
					<div class="panel-body">
						<div class="container-fluid">
							<div class="row" >
								<form name="addnotification" class="common-form addnotification" ng-submit="Notification.triggerEmailNotification()">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group form_field">
												<label>
													Subject
												</label>
												<input type="text" placeholder="Enter mail subject" ng-model="Notification.notificationData.subject" required="" class="form-control">
											</div>
										</div>
									</div>
									<div class="row" ng-init="Notification.notificationData.type='email'">
										<div class="col-sm-12">
											<div class="form-group form_field custom_editor">
												<label>
													Content
												</label>
											<trix-editor spellcheck="true" angular-trix ng-model="Notification.notificationData.content" class="trix-content" trix-attachment-add="Notification.trixAttachmentAdd(e, editor);" trix-attachment-remove="Notification.trixAttachmentRemove(e, editor);" placeholder="Write your mail content here..." style="min-height: 225px !important;max-height: 250px !important;overflow-y: auto;"></trix-editor>
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
</div>
</div>
@endsection
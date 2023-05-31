@extends('admin::includes.landing')
@section('content')

@include('admin::notifications.menu')

<div class="row" ng-controller="NotificationController as Notification">

    <div class="col-xs-6">
        @include('admin::notifications.include-users-select')
    </div>

    <div class="col-xs-6">
    <div class="popup-notification">
        <div class="panel panel-default">
            <div class="panel-heading">
                Desktop Notifications
            </div>

            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row" >

                        <form name="addnotification" class="common-form addnotification" ng-submit="Notification.triggerBrowserNotification()">


                        <div class="row" >
                            <div class="col-sm-12">
                                <div class="form-group form_field">
                                    <label>
                                        Content
                                    </label>
                                    <textarea ng-model="Notification.notificationData.content" required class="form-control" placeholder="Enter content"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="text-right">
                            <button type="submit" class="btn btn theme-btn bg-theme-btn btn-sm admin_notification_action_btn">Trigger Notification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
@endsection
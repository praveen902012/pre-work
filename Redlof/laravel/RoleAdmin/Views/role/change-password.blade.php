@extends('admin::includes.layout')
@section('content')
<div class="row" page-title="Change Password" ng-controller="AppController">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Change Password</div>
            <div class="panel-body">

                <form name="changepassword" class="common-form add-area" ng-submit="create('admin/password/change', passwordData, 'changepassword')" ng-init="passwordData={}">

                    <div class="form-group frm-grp-show-hide" show-hide-container>
                        <label for="name">Old Password</label>
                        <input type="password" name="old_password" class="form-control" ng-model="passwordData.old_password" required>
                    </div>

                    <div class="form-group frm-grp-show-hide" show-hide-container>
                        <label for="name">New Password</label>
                        <input type="password" name="password" class="form-control" ng-model="passwordData.password" required>
                    </div>

                    <button type="submit" name="button" class="btn btn-success">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
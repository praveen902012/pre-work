@extends('schooladmin::includes.layout')
@section('content')
<div class="row" page-title="Update Profile" ng-controller="AppController">
    <div class="col-sm-3 col-xs-12">
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Update</div>
            <div class="panel-body">
                <form name="updateprofile" class="common-form add-area" ng-submit="create('schooladmin/profile/update', profileData, 'updateprofile')">
                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">First Name</label>
                        <input type="text" name="first_name"  ng-init="profileData.first_name='{{$schooladmin->first_name}}'" class="form-control" ng-model="profileData.first_name" required="true">
                    </div>
                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">Last Name</label>
                        <input type="text" name="last_name" ng-init="profileData.last_name='{{$schooladmin->last_name}}'" class="form-control" ng-model="profileData.last_name" required="true">
                    </div>
                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">Phone</label>
                        <input type="numeric" name="phone" ng-init="profileData.phone='{{$schooladmin->phone}}'" class="form-control" ng-model="profileData.phone" required="true">
                    </div>
                    <div class="text-center">
                        <button type="submit" name="button" class="btn btn-success">
                        Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xs-12">
    </div>
</div>
@endsection
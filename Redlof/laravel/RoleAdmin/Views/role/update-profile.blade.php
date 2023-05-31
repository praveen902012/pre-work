@extends('admin::includes.layout')
@section('content')

<div class="row" page-title="Update Profile" ng-controller="AppController">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Update</div>
            <div class="panel-body">

                <form name="updateprofile" class="common-form add-area" ng-submit="create('admin/profile/update', profileData, 'updateprofile')">

                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">First Name</label>
                        <input type="text" name="first_name" ng-init="profileData.first_name='{{$admin->first_name}}'"  class="form-control" ng-model="profileData.first_name" required="true">
                    </div>

                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">Last Name</label>
                        <input type="text" name="last_name" ng-init="profileData.last_name='{{$admin->last_name}}'" class="form-control" ng-model="profileData.last_name" required="true">
                    </div>

                    <div class="form-group col-sm-12 no-padding">
                        <label for="name">Phone</label>
                        <input type="numeric" name="phone" ng-init="profileData.phone='{{$admin->phone}}'" class="form-control" class="form-control" ng-model="profileData.phone" required="true">
                    </div>
                    <button type="submit" name="button" class="btn btn-success">
                        Update Profile
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
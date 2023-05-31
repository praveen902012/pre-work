@extends('schooladmin::includes.layout')
@section('content')
<div class="row" page-title="Profile Details">
    <div class="col-sm-3 col-xs-12">
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Profile
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="text-center col-sm-12 col-xs-12">
                             <h4>
                            {{$schooladmin->first_name}}
                            </h4>
                            <p></p>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img height="" width="" src="{{ $schooladmin->photo_thumb  }}"  alt="">
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a class="btn btn-default" href="{{ route('schooladmin.profile-update') }}">Update Profile</a>
                <a class="btn btn-default" href="{{ route('schooladmin.profile-update-photo') }}">Update Photo</a>
                <a class="btn btn-default" href="{{ route('schooladmin.change-password') }}">Change Password</a>
            </div>
        </div>
    </div>
     <div class="col-sm-3 col-xs-12">
    </div>
</div>
@endsection
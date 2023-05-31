@extends('admin::includes.layout')
@section('content')

<div class="row" page-title="Profile Details">
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Profile
            </div>

            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <img src="{{ $admin->photo  }}" alt="{{ $admin->first_name . ' ' .  $admin->last_name  }}" class="user_profile_photo">
                    		{{ $admin->first_name . ' ' .  $admin->last_name  }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer text-right">
                <a class="btn btn-default" href="{{ route('admin.profile-update') }}">Update Profile</a>
                <a class="btn btn-default" href="{{ route('admin.profile-update-photo') }}">Update Photo</a>
                <a class="btn btn-default" href="{{ route('admin.change-password') }}">Change Password</a>
            </div>

        </div>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div ui-view="inner-content">

        </div>
    </div>
</div>

@endsection
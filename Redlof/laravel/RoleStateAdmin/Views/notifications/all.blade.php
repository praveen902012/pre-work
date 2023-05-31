@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash"  ng-cloak ng-controller="AppController">
	<div class="row">
		<div class="col-sm-2 col-xs-4">
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="panel panel-default text-center">
				<div class="panel-heading">Send Mail</div>
				<div class="panel-body">
					<br>
					<a href="{{route('stateadmin.notifications-mail')}}" class="btn btn-danger"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp; Compose Mail</a>
					<br>
					<br>
					<p>Click on compose mail to create a new mail. The mail will be sent in bulk based on filters</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4">
			<div class="panel panel-default text-center">
				<div class="panel-heading">Send SMS</div>
				<div class="panel-body">
					<br>
					<a href="{{route('stateadmin.notifications-sms')}}" class="btn btn-primary"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;&nbsp; Create SMS</a>
					<br>
					<br>
					<p>Click on create sms to compose new sms. The sms will be sent in bulk based on filters</p>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-xs-4">
		</div>
	</div>
</section>
@endsection
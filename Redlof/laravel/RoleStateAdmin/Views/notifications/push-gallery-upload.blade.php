@extends('admin::includes.landing')
@section('content')
@include('admin::notifications.menu')
<div class="gallery-library" ng-controller="NotificationController as Notification">
	<div ng-controller="AppController">
		<div class="row">
			<div class="col-lg-6">
				<div class="pull-left notification-gallery-nav">
					<a href="{{ route('admin.notifications-gallery-upload') }}" class="btn btn-default btn-xs active">
						Upload
					</a>
					<a href="{{ route('admin.notifications-gallery-library') }}" class="btn btn-default btn-xs">
						Library
					</a>
				</div>
			</div>
			<div class="col-lg-6" ng-init="formData={}">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" ng-init="formData.access='private'">
				<form id="upload-image" name="upload-image" class="upload-image" ng-submit="create('admin/notification/image/upload', formData)">
					<div class="form-group radio-access">
						<h4>
							Access*
						</h4>
						<label class="radio-inline"><input type="radio"  name="access" value="private" checked ng-model="formData.access"> Private</label>
						<label class="radio-inline"><input type="radio"  name="access" value="public" ng-model="formData.access"> Public</label>
					</div>
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							<div class="form-group">
								<div ngf-drop ngf-select ng-model="formData.photo" class="drop-box-image"
								ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">
								Click Or Drop Here
							</div>
							<div ngf-no-file-drop>
								File Drag/Drop is not supported for this browser
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-12">
						<div class="profilephoto form-group">
							<img ngf-thumbnail="formData.photo" height="200" width="200" class="img-responsive img-center">
						</div>
					</div>
					<div class="col-sm-5 col-xs-12">

					</div>
				</div>	
				<button type="submit" class="btn theme-btn bg-theme-btn btn-sm">Submit</button>
			</form>
		</div>
	</div>
</div>
@endsection
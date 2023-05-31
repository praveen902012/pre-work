@extends('admin::includes.layout')
@section('content')

<div page-title="Update Photo" ng-controller="AppController">
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Update Photo</div>
				<div class="panel-body">
					<form name="updatephoto" class="common-form add-area" ng-submit="create('admin/photo', profileData, 'updatephoto')">

						<div class="row">
							<div class="col-sm-6 col-xs-12">
								<div class="form-group">
									<div ngf-drop ngf-select ng-model="profileData.photo" class="drop-box" ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here</div>
									<div ngf-no-file-drop>
										File Drag/Drop is not supported for this browser
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<div class="form-group">
									<img width="100" ngf-thumbnail="profileData.photo" class="img-responsive img-center">
								</div>
							</div>
						</div>

						<button type="submit" name="button" class="btn btn-success">
							Update Photo
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
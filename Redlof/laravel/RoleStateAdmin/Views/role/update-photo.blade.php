@extends('stateadmin::includes.layout')
@section('content')

<div class="row"  page-title="Update Photo" ng-controller="AppController">
    <div class="col-sm-3 col-xs-12">
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Update Photo</div>
            <div class="panel-body">
                <form name="updatephoto" class="common-form add-area" ng-submit="create('stateadmin/photo', profileData, 'updatephoto')">
                    <div class="form-group col-sm-12 no-padding">
                        <div ngf-drop ngf-select ng-model="profileData.photo" class="drop-box center-block" ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here</div>
                        <div class="center-block" ngf-no-file-drop>
                            File Drag/Drop is not supported for this browser
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                        </div>
                        <div class="text-center col-sm-6 col-xs-12">
                            <div class="profilephoto center-block">
                                <img width="200" ngf-thumbnail="profileData.photo" class="img-responsive img-center">
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                        </div>
                    </div>
                    <br>
                    <div class="text-center" ng-cloak>
                        <button ng-disabled="inProcess" type="submit" name="button" class="btn btn-success">
                            <span ng-if="!inProcess">Update Photo</span>
                            <span ng-if="inProcess">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
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
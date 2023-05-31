@extends('admin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController" ng-init="blockData={};wardData={}">
    <div class="container-fluid">

        <div class="page-header-custom page-title-ad">
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <div>
                        <h2>
                            Downloads
                        </h2>
                    </div>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="rt-action  pull-right">

                        <a class="btn-theme btn-blue" href="{{ \URL::previous() }}">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default" ng-cloak ng-controller="DownloadReportController as Download">
            <div class="panel-heading">Download Blocks</div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <ui-select class="" ng-model="blockData.state_id" theme="select2"
                                ng-init="getDropdown('admin/get/states/all', 'states')">
                                <ui-select-match placeholder="Select state">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in states | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <ui-select class="" ng-model="blockData.district_id" theme="select2"
                                ng-click="getDropdown('admin/get/districts/'+[[blockData.state_id.id]], 'districts')">
                                <ui-select-match placeholder="Select district">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in districts | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <button
                                ng-click="Download.initDownload('admin/download/block/'+[[blockData.district_id.id]],{})"
                                class="btn btn-primary btn-block">
                                <span ng-if="!Download.inProcess">Download</span>
                                <span ng-if="Download.inProcess">Please wait <i
                                        class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="panel panel-default" ng-cloak ng-controller="DownloadReportController as Download">
            <div class="panel-heading">Download Wards</div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <ui-select class="" ng-model="wardData.state_id" theme="select2"
                                ng-init="getDropdown('admin/get/states/all', 'states')">
                                <ui-select-match placeholder="Select state">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in states | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <ui-select class="" ng-model="wardData.district_id" theme="select2"
                                ng-click="getDropdown('admin/get/districts/'+[[wardData.state_id.id]], 'districts')">
                                <ui-select-match placeholder="Select district">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in districts | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <ui-select class="" ng-model="wardData.block_id" theme="select2"
                                ng-click="getDropdown('admin/get/blocks/'+[[wardData.district_id.id]], 'blocks')">
                                <ui-select-match placeholder="Select block">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in blocks | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <button
                                ng-click="Download.initDownload('admin/download/locality/'+[[wardData.block_id.id]],{})"
                                class="btn btn-primary btn-block">
                                <span ng-if="!Download.inProcess">Download</span>
                                <span ng-if="Download.inProcess">Please wait <i
                                        class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
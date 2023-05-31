@extends('admin::includes.layout')
@section('content')
<div class="state-single" ng-controller="AppController">
    <div class="container-fluid" ng-controller="ListController as List">
        <div class="page-header-custom page-title-ad">
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <div>
                        <h2>
                            Manage Districts
                        </h2>
                    </div>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="rt-action  pull-right">

                        <button class="btn-theme btn-blue"
                            ng-click="openPopup('admin', 'state', 'add-block', 'create-popup-style')">
                            Add Block
                        </button>
                        <button class="btn-theme btn-blue"
                            ng-click="openPopup('admin', 'state', 'add-sub-block', 'create-popup-style')">
                            Add Sub Block
                        </button>
                        <button class="btn-theme btn-blue"
                            ng-click="openPopup('admin', 'state', 'add-cluster', 'create-popup-style')">
                            Add Cluster
                        </button>
                        <button class="btn-theme btn-blue"
                            ng-click="openPopup('admin', 'state', 'add-localities', 'create-popup-style')">
                            Add Locality
                        </button>
                        <a href="{{route('admin.downloads')}}" class="btn-theme btn-blue">
                            Downloads
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row" ng-init="formData={}">
                <div class="col-sm-12 col-xs-12">

                    <div class="common-form add-area form-inline">
                        <div class="form-group">

                            <ui-select class="" ng-model="formData.state_id" theme="select2"
                                ng-init="getDropdown('admin/get/states/all', 'states')">
                                <ui-select-match placeholder="Select state">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in states | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">

                            <ui-select class="" ng-model="formData.district_id" theme="select2"
                                ng-click="getDropdown('admin/get/districts/'+[[formData.state_id.id]], 'districts')">
                                <ui-select-match placeholder="Select district">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in districts | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">

                            <ui-select class="" ng-model="formData.block_id" theme="select2"
                                ng-click="getDropdown('admin/get/blocks/'+[[formData.district_id.id]], 'blocks')">
                                <ui-select-match placeholder="Select block">
                                    [[$select.selected.name]]
                                </ui-select-match>
                                <ui-select-choices repeat="item in blocks | filter:$select.search">
                                    [[item.name]]
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <button
                                ng-click="List.init('district-list', {'getall': 'admin/get/locality/'+[[formData.block_id.id]]})"" class="
                                btn btn-primary"> Search Locality</button>
                        </div>
                    </div>
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    @include('page::app.pagination')
                    <table ng-if="List.ListService.results.length > 0" ng-cloak
                        class="table table-responsive custom-table">
                        <thead class="thead-cls">
                            <tr>
                                <th>Sl.no</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="locality in List.ListService.results">
                                <td>[[$index+1]]</td>
                                <td>[[locality.name]]</td>
                                <td><button
                                        ng-click="helper.name = locality.name;helper.id = locality.id;openPopup('admin', 'state', 'edit-locality', 'create-popup-style')"
                                        class="btn btn-warning btn-xs city-action-btn">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="">
                        <div class="dynamic-content-container">
                        </div>
                    </div>
                </div>
                <div ng-if="List.ListService.results.length == 0" ng-cloak>
                    <div class="add-state-admin">
                        <p>No localities found</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
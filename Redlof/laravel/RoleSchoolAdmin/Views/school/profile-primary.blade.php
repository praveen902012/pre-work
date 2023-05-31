@extends('schooladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
    <div class="container" ng-controller="AppController" ng-init="School.getSchoolDetails({{$school->id}})">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form name="admin-add-school" class="common-form add-area">
                        <div id="exTab1">
                            <ul class="nav nav-pills reg-nav-block ">
                                <li class="active">
                                    <a class="step-link">1. Primary Details</a>
                                </li>
                                <li>
                                    <a href="{{route('schooladmin.school-profile-address')}}" class="step-link">2.
                                        Address Details</a>
                                </li>
                                <li>
                                    <a href="{{route('schooladmin.school-profile-region')}}" class="step-link">3. Region
                                        Selection</a>
                                </li>
                                <li>
                                    <a href="{{route('schooladmin.school-profile-fee')}}" class="step-link">4. Fee &
                                        Seat Details</a>
                                </li>
                                <li>
                                    <a href="{{route('schooladmin.school-profile-bank')}}" class="step-link">5. Bank
                                        Details</a>
                                </li>
                            </ul>
                            <div class="tab-content clearfix rte-all-form-sp">
                                <div class="tab-pane active" id="1a">
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    School Name&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="text"
                                                    name="name" ng-model="School.schoolData.name" ng-required="true"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    UDISE Code&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="text"
                                                    name="udise" ng-model="School.schoolData.udise" ng-required="true"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field" ng-cloak>
                                                <label>
                                                    Medium of Instruction&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>
                                                            (हिंदी अनुवाद के अनुसार)
                                                        </span>
                                                    </p>
                                                </label>
                                                <ui-select ng-disabled="true" class=""
                                                    ng-model="School.schoolData.medium" theme="select2"
                                                    ng-init="getAPIData('{{$state->slug}}/get/languages/all', 'languages')">
                                                    <ui-select-match placeholder="Select medium">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item as item in languages | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Class Upto&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>

                                                    </p>
                                                </label>
                                                <ui-select ng-disabled="true" class="" ng-model="School.schoolData.type"
                                                    theme="select2"
                                                    ng-init="classes = [{id: 'kg2', name: 'KG 2'},{id: 'class1', name: 'Class 1'},{id: 'class2', name: 'Class 2'},{id: 'class3', name: 'Class 3'},{id: 'class4', name: 'Class 4'},{id: 'class5', name: 'Class 5'},{id: 'class6', name: 'Class 6'},{id: 'class7', name: 'Class 7'},{id: 'class8', name: 'Class 8'},{id: 'class9', name: 'Class 9'},{id: 'class10', name: 'Class 10'},{id: 'class11', name: 'Class 11'},{id: 'class12', name: 'Class 12'}]">
                                                    <ui-select-match placeholder="Select">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.id as item in classes | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Type&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>

                                                    </p>
                                                </label>
                                                <ui-select ng-disabled="true" class=""
                                                    ng-model="School.schoolData.school_type" theme="select2"
                                                    ng-init="types = [{id: 'co-educational', name: 'Co-Educational'},{id: 'boys', name:'Boys School'},{id: 'girls', name: 'Girls School'}]">
                                                    <ui-select-match placeholder="Select">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.id as item in types | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Admin Mobile Number&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>
                                                            (हिंदी अनुवाद के अनुसार)
                                                        </span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="text"
                                                    name="admin_phone" ng-model="School.schoolData.admin_phone"
                                                    ng-required="true" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Contact Number&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="text"
                                                    name="phone" ng-model="School.schoolData.phone" ng-required="true"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field"
                                                ng-init="getAPIData('{{$state->slug}}/get/levels/all', 'levels')">
                                                <label>
                                                    Entry Classes&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>
                                                    </p>
                                                </label>
                                                <span ng-repeat="level in levels" ng-cloak>
                                                    <label class="custom-check">
                                                        <input disabled type="radio" name="levels" id="[[level.id]]"
                                                            value="[[level.id]]"
                                                            ng-model="School.schoolData.level">[[level.level]]
                                                        <p class="hindi-lbl">
                                                            <span>
                                                                (हिंदी अनुवाद )
                                                            </span>
                                                        </p>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    School Image
                                                    <p class="hindi-lbl"><span>
                                                            (हिंदी अनुवाद के अनुसार)
                                                        </span>
                                                    </p>
                                                </label>
                                                <div class="clearfix">
                                                    <span class="uploaded-img">
                                                        <img width="300" style="width:100px;"
                                                            class="img-responsive set-cropped-image"
                                                            ngf-thumbnail="School.schoolData.photo" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    RTE Certificate number&nbsp;<span class="mand-field">*</span>
                                                    <p class="hindi-lbl">
                                                        <span>(मान्यता प्रमाण पत्र संख्या)</span><span
                                                            class="mand-field">*</span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="text"
                                                    name="rte_certificate_no"
                                                    ng-model="School.schoolData.rte_certificate_no" ng-required="true"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Email ID
                                                    <p class="hindi-lbl">
                                                        <span>(हिंदी अनुवाद के अनुसार)</span>
                                                    </p>
                                                </label>
                                                <input disabled type="text" name="admin_email"
                                                    ng-model="School.schoolData.admin_email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Website Link&nbsp;<span class="mand-field"></span>
                                                    <p class="hindi-lbl">
                                                        <span>
                                                            (हिंदी अनुवाद के अनुसार)
                                                        </span><span class="mand-field">
                                                        </span>
                                                    </p>
                                                </label>
                                                <input disabled validator="required" valid-method="blur" type="url"
                                                    name="website" ng-model="School.schoolData.website"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    School Description&nbsp;
                                                    <p class="hindi-lbl">
                                                        <span>
                                                            (हिंदी अनुवाद के अनुसार)
                                                        </span>
                                                    </p>
                                                </label>
                                                <textarea disabled spellcheck="true" rows="4" name="description"
                                                    ng-model="School.schoolData.description"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script>
$(document).ready(function() {
    $('.ico-tip').tooltip({
        title: "<p><b>For Pre-Primary:</b> DOB must be between 01/04/{{date('Y')-5}} - 31/03/{{date('Y')-3}}</p><p><b>For Class 1:</b> DOB must be between 01/04/{{date('Y')-6}} - 31/03/{{date('Y')-5}}</p>",
        html: true,
        placement: "top"
    });
});
</script>
<section class="page-height" ng-controller="AppController">
    <div class="container" element-init ng-init="msg='Loading...'">
        <div class="sp-form-container" ng-controller="Step1Controller as Step1">
            <div class="row" ng-init="formData={}">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12"
                    ng-init="Step1.getLevels('{{$state->slug}}')">
                    @include('state::registration.includes.inc-first-step-header')
                    <form id="step1" class="sp-form common-form" name="step1"
                        ng-submit="create('{{$state->slug}}/student-registration/step1/save', formData, 'step1')">
                        <p class="text-lightgrey">
                            Name of the child (बच्चे का नाम)
                        </p>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        First Name <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (पहला नाम) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <input type="text" id="name" ng-model="formData.first_name" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        Middle Name
                                        <p class="hindi-lbl">
                                            (मध्य नाम)
                                        </p>
                                    </label>
                                    <input type="text" id="name" ng-model="formData.middle_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        Last Name
                                        <p class="hindi-lbl">
                                            (आखिरी नाम)
                                        </p>
                                    </label>
                                    <input type="text" id="name" ng-model="formData.last_name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        Gender <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (लिंग) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male" ng-model="formData.gender">
                                            Male
                                            <p class="hindi-lbl">
                                                (पुरुष )
                                            </p>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="female" ng-model="formData.gender">
                                            Female
                                            <p class="hindi-lbl">
                                                (महिला )
                                            </p>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="transgender"
                                                ng-model="formData.gender"> Transgender
                                            <p class="hindi-lbl">
                                                (द्वीलिंगी / ट्रांसजेंडर )
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        Date Of Birth <span class="mand-field">*</span>&nbsp;<i
                                            class="ico-tip fa fa-question-circle" aria-hidden="true"
                                            data-toggle="tooltip"></i>
                                        <p class="hindi-lbl">
                                            (जन्म तिथि) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-12" ng-init="Step1.getDates()">
                                            <ui-select class="" ng-model="formData.dob.date" theme="select2">
                                                <ui-select-match placeholder="Date">
                                                    [[$select.selected.date]]
                                                </ui-select-match>
                                                <ui-select-choices
                                                    repeat="item.id as item in Step1.dates | filter:$select.search">
                                                    [[item.date]]
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                        <div class="col-sm-3 col-xs-12">
                                            <ui-select class="" ng-model="formData.dob.month" theme="select2"
                                                ng-init="Step1.getMonths()">
                                                <ui-select-match placeholder="Month">
                                                    [[$select.selected.month]]
                                                </ui-select-match>
                                                <ui-select-choices
                                                    repeat="item.id as item in Step1.months | filter:$select.search">
                                                    [[item.month]]
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" ng-init="Step1.getYears()">
                                            <ui-select class="" ng-model="formData.dob.year" theme="select2">
                                                <ui-select-match placeholder="Year">
                                                    [[$select.selected.year]]
                                                </ui-select-match>
                                                <ui-select-choices
                                                    repeat="item.year as item in Step1.years | filter:$select.search">
                                                    [[item.year]]
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>Select Class <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (कक्षा चुनें) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <ui-select class="" ng-model="formData.level_id" theme="select2"
                                        ng-click="Step1.getAppropriateClass(formData.dob)">
                                        <ui-select-match placeholder="Select">
                                            [[$select.selected.level]]
                                        </ui-select-match>
                                        <ui-select-choices
                                            repeat="item.id as item in Step1.level_selected | filter:$select.search">
                                            [[item.level]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>Mobile Number
                                        <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (मोबाइल नंबर) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <input type="tel" class="form-control" ng-model="formData.mobile" required>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Email ID (if any)
                                        <p class="hindi-lbl">
                                            (ईमेल एड्रेस यदि हो)
                                        </p>
                                    </label>
                                    <input type="email" class="form-control" ng-model="formData.email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>Aadhaar no. of the Child
                                        <p class="hindi-lbl">
                                            (बच्चे का आधार संख्या)
                                        </p>
                                    </label>
                                    <input type="text" class="form-control" ng-model="formData.aadhar_no">
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label>Aadhaar Enrollment no. of the Child (if you don't have Aadhaar No. of the
                                        Child)
                                        <p class="hindi-lbl">
                                            (बच्चे का आधार नामांकन संख्या)
                                        </p>
                                    </label>
                                    <input type="text" class="form-control" ng-model="formData.aadhar_enrollment_no">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Passport size photo of the Child
                                        <p class="hindi-lbl">
                                            (बच्चे का पासपोर्ट आकार का फोटो)
                                        </p>
                                    </label>
                                    <button href="" class="btn btn-secondary" ngf-drop ngf-select
                                        ng-model="formData.image" ngf-multiple="false" ngf-drag-over-class="dragover"
                                        ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">
                                        <i class="fa fa-plus"></i> &nbsp; Choose file
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4" ng-if="formData.image">
                                <div class="form-group">
                                    <label>Uploaded photo of the Child
                                        <p class="hindi-lbl">
                                            (बच्चे की फोटो अपलोड की गई)
                                        </p>
                                    </label>
                                    <div class="logo">
                                        <img ngf-thumbnail="formData.image" alt="logo-state"
                                            style="border-radius: 5px !important;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button ng-disabled="inProcess" type="submit" class="btn-theme mrt-20">
                            <span ng-if="!inProcess">Save</span>
                            <span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')

@extends('schooladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
    <div class="container" ng-controller="AppController" ng-init="School.getSchoolBankDetails({{$school->id}})">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                        <h2>
                            Edit bank details
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row" ng-init="msg='Please wait till we complete school registration'">
                <div class="col-sm-12 col-xs-12">

                    <div id="exTab1">
                        <ul class="nav nav-pills reg-nav-block ">
                            <li>
                                <a href="{{route('schooladmin.edit-school')}}" class="step-link">
                                    1. Primary Details<br>&nbsp&nbsp&nbsp
                                    (प्राथमिक विवरण)
                                </a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.update-address',$school->udise)}}" class="step-link">
                                    2. Address Details<br>&nbsp&nbsp&nbsp
                                    (पता विवरण)
                                </a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.update-region',$school->udise)}}" class="step-link">
                                    3. Region Selection<br>&nbsp&nbsp&nbsp
                                    (क्षेत्र चयन)
                                </a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.update-fee',$school->udise)}}" class="step-link">
                                    4. Fee & Seat Details<br>&nbsp&nbsp&nbsp
                                    (शुल्क और सीट विवरण)
                                </a>
                            </li>
                            <li class="active">
                                <a class="step-link">
                                    5. Bank Details<br>&nbsp&nbsp&nbsp
                                    (बैंक सूचना)
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content clearfix rte-all-form-sp" ng-init="School.bankdetail = {}">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrapper">
                                    <div class="form-spacing">
                                        <form
                                            ng-submit="create('schooladmin/school/update/bank/{{$udise}}', School.bankdetail, 'updatebankDetail')"
                                            name="updatebankDetail" class="common-form operator_signin_form">
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Account holder name*
                                                    </label>
                                                    <input validator="required" valid-method="blur" type="text"
                                                        class="form-control"
                                                        ng-model="School.bankdetail.account_holder_name"
                                                        id="account_holder_name" placeholder="Account holder name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Account number*
                                                    </label>
                                                    <input validator="required" valid-method="blur" min="0" type="text"
                                                        class="form-control" ng-model="School.bankdetail.account_number"
                                                        id="account_number" placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Confirm account number*
                                                    </label>
                                                    <input validator="required" valid-method="blur" min="0" type="text"
                                                        class="form-control"
                                                        ng-model="School.bankdetail.account_number_confirmation"
                                                        id="account_number" placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field" ng-init="banks = helper.allBanks()">
                                                <div class="">
                                                    <label>
                                                        Bank name*
                                                    </label>
                                                    <input validator="required" valid-method="blur" type="text"
                                                        class="form-control" ng-model="School.bankdetail.bank_name"
                                                        id="account_number" placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        IFSC code
                                                    </label>
                                                    <input valid-method="blur" type="text" class="form-control"
                                                        ng-model="School.bankdetail.ifsc_code" id="ifsc_code"
                                                        placeholder="IFSC code">
                                                </div>
                                            </div>

                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Confirm IFSC code
                                                    </label>
                                                    <input valid-method="blur" type="text" class="form-control"
                                                        ng-model="School.bankdetail.ifsc_code_confirmation"
                                                        id="ifsc_code" placeholder="IFSC code">
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Branch Name *
                                                    </label>
                                                    <input valid-method="blur" type="text" class="form-control"
                                                        ng-model="School.bankdetail.branch" id="branch"
                                                        placeholder="Branch Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="text-lightgrey pdv-20 label-declaration">
                                                    <div class="clearfix">
                                                        <div class="checkbox-block">
                                                            <input type="checkbox" name="accept" required>
                                                        </div>
                                                        <div class="checkbox-content">
                                                            I hereby declare that all information entered in this form
                                                            is true to my knowledge. Any wrong information will lead to
                                                            strict action by the State School Education Department.
                                                            <p class="hindi-lbl">
                                                                मैं यह घोषणा करता हूं कि इस फॉर्म में दर्ज की गई सभी
                                                                जानकारी मेरे ज्ञान के हिसाब से सही है। मेरे द्वारा दी
                                                                गयी किसी भी गलत जानकारी के लिये रज्य के स्कूल शिक्षा
                                                                विभाग को सख्त कार्यवाही करने का अधिकार होगा ।
                                                            </p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <button ng-disabled="updatebankDetail.$invalid" type="submit"
                                                class="btn btn-theme">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
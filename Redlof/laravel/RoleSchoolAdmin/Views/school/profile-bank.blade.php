@extends('schooladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
    <div class="container" ng-controller="AppController" ng-init="School.getSchoolBankDetails({{$school->id}})">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                    </div>
                </div>
            </div>
            <div class="row" ng-init="msg='Please wait till we complete school registration'">
                <div class="col-sm-12 col-xs-12">

                    <div id="exTab1">
                        <ul class="nav nav-pills reg-nav-block ">
                            <li>
                                <a href="{{route('schooladmin.school-profile-primary')}}" class="step-link">1. Primary
                                    Details</a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.school-profile-address')}}" class="step-link">2. Address
                                    Details</a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.school-profile-region')}}" class="step-link">3. Region
                                    Selection</a>
                            </li>
                            <li>
                                <a href="{{route('schooladmin.school-profile-fee')}}" class="step-link">4. Fee & Seat
                                    Details</a>
                            </li>
                            <li class="active">
                                <a class="step-link">5. Bank Details</a>
                            </li>
                        </ul>
                        <div class="tab-content clearfix rte-all-form-sp" ng-init="School.bankdetail = {}">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrapper">
                                    <div class="form-spacing">
                                        <form name="updatebankDetail" class="common-form operator_signin_form">
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Account holder name*
                                                    </label>
                                                    <input disabled validator="required" valid-method="blur" type="text"
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
                                                    <input disabled validator="required" valid-method="blur" min="0"
                                                        type="text" class="form-control"
                                                        ng-model="School.bankdetail.account_number" id="account_number"
                                                        placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field" ng-init="banks = helper.allBanks()">
                                                <div class="">
                                                    <label>
                                                        Bank name*
                                                    </label>
                                                    <input disabled validator="required" valid-method="blur" type="text"
                                                        class="form-control" ng-model="School.bankdetail.bank_name"
                                                        id="account_number" placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        IFSC code
                                                    </label>
                                                    <input disabled valid-method="blur" type="text" class="form-control"
                                                        ng-model="School.bankdetail.ifsc_code" id="ifsc_code"
                                                        placeholder="IFSC code" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <div class="">
                                                    <label>
                                                        Branch Name*
                                                    </label>
                                                    <input disabled valid-method="blur" type="text" class="form-control"
                                                        ng-model="School.bankdetail.branch" id="branch"
                                                        placeholder="Branch Name" required>
                                                </div>
                                            </div>
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
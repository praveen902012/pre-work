@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
    <div class="container" ng-controller="AppController"
        ng-init="School.getSchoolBankDetails('{{$state->slug}}','{{$udise}}')">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                        <h2>
                            Bank Details
                        </h2>
                        <!-- <p>
							Register here for filling up Application Form for EWS/DG Admission for session {{date("Y")}}-{{date("y")+1}}
						</p> -->
                    </div>
                </div>
            </div>
            <div class="row" ng-init="msg='Please wait till we complete school registration'">
                <div class="col-sm-12 col-xs-12">
                    <form name="admin-add-school" class="common-form add-area"
                        ng-submit="create('{{$state->slug}}/school/{{$udise}}/bank-detail/save', School.bankdetail, 'admin-add-school')">
                        <div id="exTab1">
                            <ul class="nav nav-pills reg-nav-block ">
                                <li>
                                    <a href="{{route('state.register-your-school.resume-primary-details',[$state->slug,$udise])}}"
                                        class="step-link">
                                        1. Primary Details<br>&nbsp&nbsp&nbsp
                                        (प्राथमिक विवरण)
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('state.register-your-school.address-details',[$state->slug,$udise])}}"
                                        class="step-link">
                                        2. Address Details<br>&nbsp&nbsp&nbsp
                                        (पता विवरण)
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('state.register-your-school.region-selection',[$state->slug,$udise])}}"
                                        class="step-link">
                                        3. Region Selection<br>&nbsp&nbsp&nbsp
                                        (क्षेत्र चयन)
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('state.register-your-school.class-info',[$state->slug,$udise])}}"
                                        class="step-link">
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
                                @if($show_preview)
                                <li>
                                    <a class="step-link"
                                        href="{{route('state.school-registration-preview',[$state->slug,$udise])}}">
                                        6. Preview Details<br>&nbsp;&nbsp;&nbsp;
                                        (पूर्वावलोकन विवरण)
                                    </a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content clearfix rte-all-form-sp">
                                <form
                                    ng-submit="create('campowner/School.bankdetails/save', School.bankdetail, 'updatebankDetail')"
                                    name="updatebankDetail" class="common-form operator_signin_form">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-wrapper">
                                            <div class="form-spacing">
                                                <div class="form-group form-field">
                                                    <div class="">
                                                        <label>
                                                            खाता धारक का नाम*
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
                                                            खाता संख्या*
                                                        </label>
                                                        <input validator="required" valid-method="blur" min="0"
                                                            type="text" class="form-control"
                                                            ng-model="School.bankdetail.account_number"
                                                            id="account_number" placeholder="Account number" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-field">
                                                    <div class="">
                                                        <label>
                                                            खाता संख्या की पुष्टि करें*
                                                        </label>
                                                        <input validator="required" valid-method="blur" min="0"
                                                            type="text" class="form-control"
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
                                                            id="account_number" placeholder="Bank name" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-field">
                                                    <div class="">
                                                        <label>
                                                            IFSC कोड
                                                        </label>
                                                        <input valid-method="blur" type="text" class="form-control"
                                                            ng-model="School.bankdetail.ifsc_code" id="ifsc_code"
                                                            placeholder="IFSC code">
                                                    </div>
                                                </div>

                                                <div class="form-group form-field">
                                                    <div class="">
                                                        <label>
                                                            IFSC कोड की पुष्टि करें
                                                        </label>
                                                        <input valid-method="blur" type="text" class="form-control"
                                                            ng-model="School.bankdetail.ifsc_code_confirmation"
                                                            id="ifsc_code" placeholder="IFSC code">
                                                    </div>
                                                </div>

                                                <div class="form-group form-field">
                                                    <div class="">
                                                        <label>
                                                            Branch Name शाखा का नाम*
                                                        </label>
                                                        <input valid-method="blur" type="text" class="form-control"
                                                            ng-model="School.bankdetail.branch" id="branch"
                                                            placeholder="Branch Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-lightgrey pdv-20 label-declaration">
                                                <div class="clearfix">
                                                    <div class="checkbox-block">
                                                        <input type="checkbox" name="accept" required>
                                                    </div>
                                                    <div class="checkbox-content">
                                                        I hereby declare that all information entered in this form is
                                                        true to my knowledge. Any wrong information will lead to strict
                                                        action by the State School Education Department.
                                                        <p class="hindi-lbl">
                                                            मैं यह घोषणा करता हूं कि इस फॉर्म में दर्ज की गई सभी जानकारी
                                                            मेरे ज्ञान के हिसाब से सही है। मेरे द्वारा दी गयी किसी भी
                                                            गलत जानकारी के लिये रज्य के स्कूल शिक्षा विभाग को सख्त
                                                            कार्यवाही करने का अधिकार होगा ।
                                                        </p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <button ng-disabled="inProcess" type="submit" class="btn btn-theme ">
                                            <span ng-if="!inProcess">Submit</span>
                                            <span ng-if="inProcess">Please Wait.. <i
                                                    class="fa fa-spinner fa-spin"></i></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
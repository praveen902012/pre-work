@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing bg-grey"
    ng-controller="ResumeRegistrationController as Registration" ng-init="helper.state_slug='{{$state->slug}}'">
    <div class="container" ng-controller="Step4Controller as Step4"
        ng-init="Registration.registration_no = helper.findIdFromUrl()">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <div class="heading-strip all-pg-heading">
                        @if(is_null($registration->registration_cycle))
                            <h2>
                                Student lottery results
                            </h2>
                        @else 
                            <h2>
                                Student lottery results for the year
                                {{$registration->registration_cycle->application_details->session_year}}
                            </h2>
                        @endif
                    </div>
                </div>

                @if(!is_null($registration->registration_cycle) && $registration->status == 'completed')
                    <div class="col-sm-4 col-xs-12">
                        <div class="pull-right">
                            <a href="/api/{{$state->slug}}/download/registration-form/{{$registration->registration_no}}"
                                class="btn btn-default btn-xs">
                                <span><i class="fa fa-download"></i></span>Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="hm-card bg-wht lottery-result">
                <div class="result-row-heading">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4>
                                Registration ID
                            </h4>
                        </div>
                        <div class="col-sm-10">
                            <h4>{{$registration->registration_no}}</h4>
                        </div>
                    </div>
                </div>
                <div class="result-row">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4>Student Name</h4>
                        </div>
                        <div class="col-sm-10">
                            <h4>{{$registration->first_name}} @if($registration->middle_name != 'Null')
                                {{$registration->middle_name}} @endif @if($registration->middle_name != 'Null')
                                {{$registration->last_name}} @endif</h4>
                        </div>
                    </div>
                </div>
                <div class="result-row">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4>Student Class</h4>
                        </div>
                        <div class="col-sm-10">
                            <h4>{{$registration->level->level}}</h4>
                        </div>
                    </div>
                </div>
                <div class="result-row">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4>Date of Birth</h4>
                        </div>
                        <div class="col-sm-10">
                            <h4>{{$registration->fmt_dob}}</h4>
                        </div>
                    </div>
                </div>

                @if(is_null($registration->registration_cycle) || $registration->status != 'completed')
                    <div class="result-row">
                        <div class="row">
                            <div class="col-sm-2">
                                <h4>Status</h4>
                            </div>
                            <div class="col-sm-10">
                                <h4>फॉर्म अधूरा हैं। कृपया फॉर्म सबमिट करें।</h4>
                            </div>
                        </div>
                    </div>
                @else

                    @if(count($check) > 0)
                        
                        {{-- if student-registration is still on --}}
                        @if($registration->registration_cycle->document_verification_status=='verified')
                                <div class="result-row no-border">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>छात्र के दस्तावेज सत्यापित हो गए हैं। लॉटरी का इंतज़ार करें।</h4>
                                        </div>
                                    </div>
                                </div>

                        @elseif($registration->registration_cycle->document_verification_status=='rejected')
                            <div class="result-row no-border">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h4>छात्र आवेदन खारिज। दस्तावेज़ सम्पूर्ण नही।</h4>
                                        <br>
                                        <p><b>Reason</b></p>
                                        <p>
                                            {{$registration->registration_cycle->doc_reject_reason}}
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        {{-- <a class="btn-theme btn-sm pull-right"
                                            ng-click="openPopup('state', 'registration', 'resume-registration', 'create-popup-style sm-popup-style')">
                                            <span><i class="fa fa-pencil" aria-hidden="true"></i> Edit preferences</span>
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        @elseif($registration->registration_cycle->document_verification_status == NULL )
                            <div class="result-row no-border">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if($registration->status == 'completed')
                                            <h4>छात्र पंजीकरण पूरा हो गया हैं। खंड शिक्षा अधिकारी दफ्तर में सत्यापन के लिए दस्तावेज़ जमा कराए।</h4>
                                        @else 
                                            <h4>फॉर्म अधूरा हैं। कृपया फॉर्म सबमिट करें।</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>  
                        @endif

                    @else

                        {{-- after student-registration is over --}}
                        @if($registration->registration_cycle->status=='allotted' || $registration->registration_cycle->status=='not_reported' || $registration->registration_cycle->status=='enrolled')
                            <div class="result-row no-border"
                                ng-init="Step4.checkReport('{{$state->slug}}',{{$registration->id}})">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <h4>Allotted School</h4>
                                    </div>

                                    <div class="col-sm-6">
                                        <h4>
                                            छात्र को लॉटरी में 
                                            '{{$registration->registration_cycle->school->name}} (UDISE-{{$registration->registration_cycle->school->udise}})' 
                                            मिला हैं। कृपया दस्तावेज़ लेजाकर स्कूल में दाखिला करवाये।
                                        </h4>

                                        @if($registration->registration_cycle->status=='not_reported')
                                            <p>Not reported to school</p>
                                        @endif

                                        @if($registration->registration_cycle->status=='enrolled')
                                            <p>Enrolled in school</p>
                                        @endif
                                    </div>

                                    <div ng-if="Step4.reported" class="col-sm-4">
                                        <a href="" ng-really-action="Report"
                                            ng-really-message="Do you want to report school denying admission? This report will be sent to the respective administrator and further actions will be carried out."
                                            ng-really-click="Step4.reportSchoolDeny('{{$state->slug}}',{{$registration->id}})"
                                            class="btn-theme btn-sm  pull-right">
                                            <span>School denying admission</span>
                                        </a>
                                    </div>

                                    @if($registration->registration_cycle->status=='not_reported' && count($check)>0)
                                        <div class="col-sm-4">
                                            {{-- <a class="btn-theme btn-sm pull-right"
                                                ng-click="openPopup('state', 'registration', 'resume-registration', 'create-popup-style sm-popup-style')">
                                                <span><i class="fa fa-pencil" aria-hidden="true"></i> Edit preferences</span>
                                            </a> --}}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @elseif($registration->registration_cycle->status=='dismissed')
                            <div class="row">
                                <div class="col-sm-12" style="margin-top: 20px;">
                                    <h4>विद्यालय द्वारा अभिभावक के आवेदन पर एडमिशन खारिज। यदि आपने ऐसा नहीं किया तो खंड शिक्षा अधिकारी से मिले।</h4>
                                </div>
                            </div>
                        @elseif($registration->registration_cycle->document_verification_status=='verified')
                            <div class="result-row no-border">
                                @if($lottery_triggered && $registration->registration_cycle->status == 'applied')
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>You have not been allotted to any school of your preference.</h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>छात्र के दस्तावेज सत्यापित हो गए हैं। लॉटरी का इंतज़ार करें।</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @elseif($registration->registration_cycle->document_verification_status=='rejected')
                            <div class="result-row no-border">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h4>छात्र आवेदन खारिज। दस्तावेज़ सम्पूर्ण नही।</h4>
                                        <br>
                                        <p><b>Reason</b></p>
                                        <p>
                                            {{$registration->registration_cycle->doc_reject_reason}}
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        {{-- <a class="btn-theme btn-sm pull-right"
                                            ng-click="openPopup('state', 'registration', 'resume-registration', 'create-popup-style sm-popup-style')">
                                            <span><i class="fa fa-pencil" aria-hidden="true"></i> Edit preferences</span>
                                        </a> --}}
                                    </div>
                                </div>
                            </div>

                        @elseif($registration->status == 'completed')
                            <div class="result-row no-border">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h4>छात्र पंजीकरण पूरा हो गया हैं। खंड शिक्षा अधिकारी दफ्तर में सत्यापन के लिए दस्तावेज़ जमा कराए।</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                    @endif
                @endif
            </div>
               
        </div>   
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
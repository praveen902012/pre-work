@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing" ng-controller="SchoolFeeSeatController as School">
    <div class="container" ng-controller="AppController">
        <div class="rte-container"
            ng-init="getAPIData('{{$state->slug}}/school/{{$udise}}/fee-structure', 'feestructure')">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                        <h2>
                            Fee & Seat Details (सीट एवं शुल्क विवरण)
                        </h2>
                        <!-- <p>
							Register here for filling up Application Form for EWS/DG Admission for session 2019-2020
						</p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form name="add-fee-structure" class="common-form add-area"
                        ng-submit="School.submitDetails(feestructure, School.seatinfo,'{{$state->slug}}', '{{$udise}}')">
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

                                <li class="active">
                                    <a class="step-link">
                                        4. Fee & Seat Details<br>&nbsp&nbsp&nbsp
                                        (शुल्क और सीट विवरण)
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('state.register-your-school.bank-details',[$state->slug,$udise])}}"
                                        class="step-link">
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
                            <div>
                                <div class="row" class="row">
                                    <div class="col-sm-12 col-xs-12">

                                        <table class="table table-responsive table-bordered custom-table">
                                            <thead class="thead-cls">
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Class</th>
                                                    <th>मासिक शिक्षण शुल्क (in Rs)</th>
                                                    <th>कुल शुल्क (in Rs)</th>
                                                    <th>RTE के अन्तर्गत कुल पढ़ रहे छात्र</th>
                                                </tr>
                                            </thead>

                                            <tr ng-repeat="item in feestructure">
                                                <td ng-bind="$index+1"></td>
                                                <td ng-if="item.level" ng-bind="item.level"></td>
                                                <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                                                <td><input type="number" ng-model="item.tution_fee" class="form-control"
                                                        validator="required" ng-required="true" min="0"
                                                        ng-change="item = School.calculateTotalFee(item)"
                                                        ng-init="item = School.calculateTotalFee(item)"></td>
                                                <td ng-bind="item.total"></td>
                                                <td>
                                                    <input type="number" ng-model="item.rte_seats" class="form-control" validator="required" ng-required="true" min="0">
                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>
                            </div>



                            <div class="row" ng-init="School.initSeatInfo('{{$state->slug}}', '{{$udise}}')">

                                <div class="col-sm-12 col-xs-12">

                                    <table class="table table-responsive table-bordered custom-table">
                                        <thead class="thead-cls">
                                            <tr>
                                                <th colspan="5" class="text-center">Total RTE seats allotted</th>
                                            </tr>
                                        </thead>
                                        <thead class="thead-cls">
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Class</th>
                                                <th class="text-center">{{$year - 3 }} - {{ $year - 2 }}
                                                </th>
                                                <th class="text-center">{{ $year - 2 }} - {{ $year - 1 }}
                                                </th>
                                                <th class="text-center">{{ $year - 1 }} - {{ $year}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>1.</td>
                                            <td ng-bind="School.pastSeatInfo.level"></td>
                                            <td>
                                                <input type="number" class="form-control" validator="required"
                                                    ng-required="true" min="0"
                                                    ng-model="School.pastSeatInfo.third_year">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" validator="required"
                                                    ng-required="true" min="0"
                                                    ng-model="School.pastSeatInfo.second_year">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" validator="required"
                                                    ng-required="true" min="0"
                                                    ng-model="School.pastSeatInfo.first_year">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row" ng-init="School.initSeatDetails('{{$state->slug}}', '{{$udise}}')">

                                <div class="col-sm-12 col-xs-12">

                                    <table class="table table-responsive table-bordered custom-table">
                                        <thead class="thead-cls">
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Class</th>
                                                <th class="text-center">{{ $year }} मे नये प्रवेश हेतु कुल सीट
                                                </th>
                                                <th class="text-center">{{ $year }} मे नये प्रवेश हेतु 25% सीट
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr ng-repeat="item in School.seatinfo">
                                            <td ng-bind="$index+1"></td>
                                            <td ng-bind="item.level"></td>
                                            <td><input type="number" class="form-control" validator="required"
                                                    ng-required="true" min="0" ng-model="item.total_seats"
                                                    ng-init="item = School.process25per(item)"
                                                    ng-change="item = School.process25per(item)"></td>
                                            <td ng-bind="item.available_seats"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="text-lightgrey pdv-20 label-declaration">
                                    <div class="clearfix">
                                        <div class="checkbox-block">
                                            <input type="checkbox" name="accept" ng-model="School.tos" required>
                                        </div>
                                        <div class="checkbox-content">
                                            <p class="hindi-lbl">
                                                {{$school->name}} घोषणा करता है कि ये पूरी जानकारी सत्य एवं सही है।
                                                मैंने इस संबंध में अधिसूचना के सारे उपबन्ध पढ़कर समझ लिये हैं। यदि
                                                सत्यापन करने पर कोई जानकारी झूठी या असत्य पाई जाती है तो मेरे पंजीकरण को
                                                रद्द किया जा सकता हैं।
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button ng-disabled="School.inProcess" type="submit" class="btn-theme step-link">
                                        <span ng-if="!School.inProcess">Save &amp; Continue ( सेव ) </span>
                                        <span ng-if="School.inProcess">Please Wait.. <i
                                                class="fa fa-spinner fa-spin"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')

@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing">
    <div class="container" ng-controller="AppController" ng-init="School.initAddress('{{$state->slug}}');">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                        <h2>
                            Preview Details
                        </h2>
                        <p>
                            Register here for filling up Application Form for EWS/DG Admission for session
                            {{date("Y")}}-{{date("y")+1}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form name="admin-add-school" class="common-form add-area"
                        ng-submit="School.saveSchoolAddress('{{$state->slug}}/new/school/add-address/{{$udise}}', '{{$state->slug}}')">
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
                                <li>
                                    <a href="{{route('state.register-your-school.bank-details',[$state->slug,$udise])}}"
                                        class="step-link">
                                        5. Bank Details<br>&nbsp&nbsp&nbsp
                                        (बैंक सूचना)
                                    </a>
                                </li>
                                @if($show_preview)
                                <li class="active">
                                    <a class="step-link"
                                        href="{{route('state.school-registration-preview',[$state->slug,$udise])}}">
                                        6. Preview Details<br>&nbsp;&nbsp;&nbsp;
                                        (पूर्वावलोकन विवरण)
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </form>
                </div>
            </div><br>
            <div class="row" ng-init="getAPIData('{{$state->slug}}/get/school-details/'+{{$udise}}, 'School');"
                ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Primary Details</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>School Name</b></td>
                                    <td>[[ School.name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>UDISE Code</b></td>
                                    <td>[[ School.udise ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Medium of Instruction</b></td>
                                    <td>[[ School.language.name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Class Upto</b></td>
                                    <td>[[ School.type | capitalize]]</td>
                                </tr>
                                <tr>
                                    <td><b>Type</b></td>
                                    <td>[[ School.school_type | capitalize]]</td>
                                </tr>
                                <tr>
                                    <td><b>Admin Mobile No.</b></td>
                                    <td>[[ School.schooladmin.user.phone ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Contact Number</b></td>
                                    <td>[[ School.phone ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Entry Classes</b></td>
                                    <td>
                                        <span ng-if="School.entry_class"> [[School.entry_class]]</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>RTE Certificate No.</b></td>
                                    <td>[[ School.rte_certificate_no ]]</td>
                                </tr>

                                <tr>
                                    <td><b>Email ID</b></td>
                                    <td ng-if="School.schooladmin.user.email != null" class="word-break-all">[[ School.schooladmin.user.email
                                        ]]</td>
                                    <td ng-if="School.schooladmin.user.email == null">No email provided</td>
                                </tr>

                                <tr>
                                    <td><b>Website Link</b></td>
                                    <td ng-if="School.website != null || School.website != 'null'">[[ School.website ]]
                                    </td>
                                    <td ng-if="School.website == null">--</td>
                                </tr>
                                <tr ng-if="[[ School.fmt_logo ]]">
                                    <td><b>School Image</b></td>
                                    <td class="text-center"><img style="max-height:500px" width="300"
                                            ng-src="[[ School.fmt_logo ]]" alt="[[ School.name ]]" class="responsive-image"></td>
                                </tr>
                                <tr>
                                    <td><b>School Description</b></td>
                                    <td ng-if="School.description != null || School.description != 'null'">[[
                                        School.description ]]</td>
                                    <td ng-if="School.website == null">--</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row" ng-init="getAPIData('{{$state->slug}}/get/school-address?udise='+{{$udise}}, 'Address');"
                ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Address Details</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>District</b></td>
                                    <td>[[ Address.district_name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Block</b></td>
                                    <td>[[ Address.block_name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Rural/Urban</b></td>
                                    <td>[[ Address.state_type | capitalize ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Block/Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat</b></td>
                                    <td>[[ Address.sub_block_name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Ward or Village</b></td>
                                    <td>[[ Address.locality_name ]]</td>
                                </tr>
                                <!-- <tr>
                                    <td><b>Cluster</b></td>
                                    <td>[[ Address.cluster.name ]]</td>
                                </tr> -->
                                <tr>
                                    <td><b>Pincode</b></td>
                                    <td>[[ Address.pincode ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Postal Address</b></td>
                                    <td>[[ Address.address ]]</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ########### Region Selection Details############-->
            <div class="row"
                ng-init="getAPIData('{{$state->slug}}/get/school-region-details/{{$udise}}', 'RegionDetails');"
                ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Region Selection Details</div>
                        <div class="panel-body">
                            <h4>Selected neighbourhood wards (In Block):</h4><br>
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>S No.</b></td>
                                    <td><b>Name</b></td>
                                </tr>
                                <tr ng-repeat="selected in RegionDetails.selected">
                                    <td>[[$index+1]]</td>
                                    <td>[[ selected.name ]]</td>
                                </tr>
                            </table>
                            <br>
                            <h4>Selected neighbourhood wards (In District):</h4><br>
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>S No.</b></td>
                                    <td><b>Name</b></td>
                                </tr>
                                <tr ng-repeat="selected in RegionDetails.selectedDist">
                                    <td>[[$index+1]]</td>
                                    <td>[[ selected.name ]]</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ########### Fees  Details############-->

            <div class="row" ng-init="getAPIData('{{$state->slug}}/school/{{$udise}}/fee-structure', 'Fee');" ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Fee Details</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>S No.</b></td>
                                    <td><b>Class</b></td>
                                    <td><b>Monthly Tution Fee (in Rs)</b></td>
                                    <td><b>Total Annual Fees (in Rs)</b></td>
                                </tr>
                                <tr ng-repeat="price in Fee">
                                    <td>[[$index+1]]</td>
                                    <td>[[ price.level_info.level ]]</td>
                                    <td>[[ price.tution_fee]]</td>
                                    <td>[[ (price.tution_fee*12) + price.other_fee]]</td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- ########### Allotment Details############-->

            <div class="row"
                ng-init="getAPIData('{{$state->slug}}/school/{{$udise}}/get/past-seat-info', 'pastSeatInfo');">

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
                            <td ng-bind="pastSeatInfo.level"></td>
                            <td>
                                [[pastSeatInfo.third_year]]
                            </td>
                            <td>
                                [[pastSeatInfo.second_year]]
                            </td>
                            <td>
                                [[pastSeatInfo.first_year]]
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


            <!-- ########### Seat Details############-->

            <div class="row" ng-init="getAPIData('{{$state->slug}}/school/{{$udise}}/get/seat-info', 'Seat');" ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Seat Details</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>S No.</b></td>
                                    <td><b>Class</b></td>
                                    <td><b>Available Seats</b></td>
                                    <td><b>Total Seats</b></td>
                                </tr>
                                <tr ng-repeat="singleSeat in Seat">
                                    <td>[[$index+1]]</td>
                                    <td>[[ singleSeat.level ]]</td>
                                    <td>[[ singleSeat.available_seats]]</td>
                                    <td>[[ singleSeat.total_seats ]]</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ############################### Bank Details ###################################### -->
            <div class="row" ng-init="getAPIData('{{$state->slug}}/get/school-bank-details/{{$udise}}', 'Bank');"
                ng-cloak>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Bank Details</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>Account Holder Name</b></td>
                                    <td>[[ Bank.account_holder_name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Account Number</b></td>
                                    <td>[[ Bank.account_number ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Bank Name</b></td>
                                    <td>[[ Bank.bank_name ]]</td>
                                </tr>
                                <tr>
                                    <td><b>IFSC Code</b></td>
                                    <td>[[ Bank.ifsc_code ]]</td>
                                </tr>
                                <tr>
                                    <td><b>Branch Name</b></td>
                                    <td>[[ Bank.branch ]]</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-controller="SchoolController as School">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="checkbox-sample">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="accept" ng-model="School.schoolData.accept_agreement"
                                    required>
                                I hereby declare that the information given above is true and correct to the best of my
                                knowledge and belief. I have read and understood all the provisions of the notification
                                in this regard. In case any information is found false or incorrect on verification, the
                                registration may be cancelled and I will be liable for the action to be taken against me
                                as per law.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="text-center" ng-cloak>
                            <a href="{{route('state.register-your-school.resume-primary-details',[$state->slug,$udise])}}"
                                role="button" class="btn-theme step-link">Edit Details</a>
                            <button
                                ng-click="School.saveAndSubmit('{{$state->slug}}/school/{{$udise}}/save_data', {{ $state }})"
                                class="btn-theme step-link">
                                Submit Details
                            </button>
                        </div>
                    </div>
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
</section>
@include('state::includes.footer')
@include('state::includes.foot')
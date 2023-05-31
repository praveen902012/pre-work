@extends('nodaladmin::includes.layout')
@section('content')
<section ng-controller="AppController" ng-cloak>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Basic details</div>
                    <div class="panel-body">
                        <p>
                            <strong>Name:</strong> {{$school->name}}
                        </p>
                        <p>
                            <strong>UDISE:</strong> {{$school->udise}}
                        </p>
                        <p>
                            <strong>Medium:</strong> {{$school->language->name}}
                        </p>
                        @if(!empty($school->eshtablished))
                        <p>
                            <strong>Eshtablished Year:</strong> {{$school->eshtablished}}
                        </p>
                        @endif
                        @if(!empty($school->phone))
                        <p>
                            <strong>Phone:</strong> {{$school->phone}}
                        </p>
                        @endif
                        @if(!empty($school->rte_certificate_no))
                        <p>
                            <strong>RTE Certificate No. :</strong> {{$school->rte_certificate_no}}
                        </p>
                        @endif
                        @if(!empty($school->website))
                        <p>
                            <strong>Website:</strong> {{$school->website}}
                        </p>
                        @endif
                        <p>
                            <strong>School Type:</strong> {{$school->school_type}}
                        </p>
                        <p>
                            <strong>Entry Class:</strong>
                            @foreach($levels as $value) {{$value['name'] }} @endforeach
                        </p>
                        <p>
                            <strong>Address:</strong> {{$school->address}}
                        </p>
                        <p>
                            <strong>Pincode:</strong> {{$school->pincode}}
                        </p>
                        <p>
                            <strong>Ward:</strong> {{$school->locality->name}}
                        </p>
                        @if(count($school->sublocality)>0)
                        <p>
                            <strong>Sub Locality:</strong> {{$school->sublocality->name}}
                        </p>
                        @endif
                        @if(count($school->subsublocality)>0)
                        <p>
                            <strong>Sub Sub Locality:</strong> {{$school->subsublocality->name}}
                        </p>
                        @endif
                        <p>
                            <strong>Block:</strong> {{$school->block->name}}
                        </p>
                        <!-- <p>
							<strong>Urban/Rural:</strong> {{$school->state_type}}
						</p>
						<p>
							<strong>Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat:</strong> {{$school->sub_block_name}}
						</p> -->

                        @if(!empty($school->max_fees))
                        <p>
                            <strong>Maximum fees:</strong> {{$school->max_fees}}
                        </p>
                        @endif
                        <p>
                            <strong>Status:</strong> {{$school->application_status}}
                        </p>
                    </div>
                </div>
                <div class="panel panel-warning">
                    <div class="panel-heading">Neighbourhood details (In district)</div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered custom-table">
                            <thead class="thead-cls">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                            @foreach($sub_regions as $key => $value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value['name']}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                @if(!empty($school->school_bank_details->account_number))
                <div class="panel panel-success">
                    <div class="panel-heading">Bank details</div>
                    <div class="panel-body">
                        <p>
                            <strong>Account holder name:</strong> {{$school->school_bank_details->account_holder_name}}
                        </p>
                        <p>
                            <strong>Account number:</strong> {{$school->school_bank_details->account_number}}
                        </p>
                        <p>
                            <strong>IFSC code:</strong>
                            @if($school->school_bank_details->ifsc_code)
                            {{$school->school_bank_details->ifsc_code}}
                            @else
                            No IFSC Code
                            @endif
                        </p>
                        <p>
                            <strong>Bank:</strong> {{$school->school_bank_details->bank_name}}
                        </p>
                        <p>
                            <strong>Branch:</strong> {{$school->school_bank_details->branch}}
                        </p>
                    </div>
                </div>
                @endif
                <div class="panel panel-warning">
                    <div class="panel-heading">Neighbourhood details (In Block)</div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered custom-table">
                            <thead class="thead-cls">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                            @foreach($regions as $key => $value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value['name']}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" ng-controller="SchoolFeeNSeatController as School"
            ng-init="getAPIData('nodaladmin/get/school-fee-details/{{$school->id}}', 'feestructure')">
            <div class="col-sm-12 col-xs-12">
                <div id="exTab1">
                    <div>
                        <div class="row" class="row">
                            <div class="col-sm-12 col-xs-12">
                                <table class="table table-responsive table-bordered custom-table">
                                    <thead class="thead-cls">
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Class</th>
                                            <th>Monthly Tution Fee (in Rs)</th>
                                            <th>Other Fee (in Rs)</th>
                                            <th>Total Fees (in Rs)</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="item in feestructure">
                                        <td ng-bind="$index+1"></td>
                                        <td ng-if="item.level" ng-bind="item.level"></td>
                                        <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                                        <td><input disabled type="number" ng-model="item.tution_fee"
                                                class="form-control" validator="required" ng-required="true" min="0"
                                                ng-change="item = School.calculateTotalFee(item)"></td>
                                        <td><input disabled type="number" ng-model="item.other_fee" class="form-control"
                                                validator="required" ng-required="true" min="0"
                                                ng-change="item = School.calculateTotalFee(item)"
                                                ng-init="item = School.calculateTotalFee(item)"></td>
                                        <td ng-bind="item.total"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="panel-group">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">Total RTE seats allotted</div>
                                    <div class="panel-body">
                                        <table class="table table-responsive table-bordered custom-table">
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
                                                <td>{{$pastInfo->level}}</td>
                                                <td>
                                                    {{$pastInfo->third_year}}
                                                </td>
                                                <td>
                                                    {{$pastInfo->second_year}}
                                                </td>
                                                <td>
                                                    {{$pastInfo->first_year}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" ng-init="School.initSeatDetails('{{$school->udise}}')">

                        <div class="col-sm-12 col-xs-12">
                            <div class="panel-group">
                                <div class="panel panel-success">
                                    <div class="panel-heading">Seats Availablle</div>
                                    <div class="panel-body">
                                        <table class="table table-responsive table-bordered custom-table">
                                            <thead class="thead-cls">
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Class</th>
                                                    <th>Total seats for New Admission Cycle {{ $year  }} - {{ $year + 1}}</th>
                                                    <th>25% RTE seats for New Admission Cycle {{ $year  }} - {{ $year + 1}}</th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="item in School.seatinfo">
                                                <td ng-bind="$index+1"></td>
                                                <td ng-if="item.level" ng-bind="item.level"></td>
                                                <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                                                <td ng-bind="item.total_seats"></td>
                                                <td ng-bind="item.available_seats"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" ng-init="getAPIData('nodaladmin/school/allottment-details/{{$school->id}}', 'applicationCycles')">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Seat Allottment History</div>
                    <div class="panel-body">
                        <div class="row" ng-if="applicationCycles.length">
                            <div class="col-md-6" ng-repeat="applicationCycle in applicationCycles">
                                <p><b class="text-muted">Session Year : </b> [[applicationCycle.session_year]]</p>
                                <p><b class="text-muted">Cycle : </b> [[applicationCycle.cycle]]</p>
                                <p><b class="text-muted">Entry Class: </b>[[applicationCycle.entry_class.level_info.level]] </p>
                                <p><b class="text-muted">Is School Registered : </b> <span ng-if="applicationCycle.school_cycle">Yes</span> <span ng-if="!applicationCycle.school_cycle">No</span></p>
                                <p><b class="text-muted">Total Seats (25%): </b> [[applicationCycle.entry_class.available_seats]] </p>
                                <p><b class="text-muted">Total Students Applied: </b> [[applicationCycle.no_reg_students]] </p>

                                <p><b class="text-muted">Total Students Allotted: </b> [[applicationCycle.alloted_students.length]] </p>
                                <p><b class="text-muted">Total Students Enrolled: </b> [[applicationCycle.enrolled_students.length]] </p>
                                <p><b class="text-muted">Total Students Dismissed: </b> [[applicationCycle.dismissed_students.length]] </p>

                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

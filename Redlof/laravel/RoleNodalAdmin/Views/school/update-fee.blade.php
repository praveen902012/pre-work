@extends('nodaladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolFeeNSeatController as School">
    <div class="container" ng-controller="AppController"
        ng-init="getAPIData('nodaladmin/get/school-fee-details/{{$school->id}}', 'feestructure')"">
		<div class=" rte-container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
                    <h2>
                        Edit fee & seat details
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <form name="add-fee-structure" class="common-form add-area"
                    ng-submit="School.submitDetails(feestructure, School.seatinfo, '{{$udise}}')">
                    <div id="exTab1">
                        <ul class="nav nav-pills reg-nav-block ">
                            <li>
                                <a href="{{route('school.school-edit',$school->id)}}" class="step-link">
                                    1. Primary Details<br>&nbsp&nbsp&nbsp
                                    (प्राथमिक विवरण)
                                </a>
                            </li>
                            <li>
                                <a href="{{route('nodaladmin.edit-school-address',$school->udise)}}" class="step-link">
                                    2. Address Details<br>&nbsp&nbsp&nbsp
                                    (पता विवरण)
                                </a>
                            </li>
                            <li>
                                <a href="{{route('nodaladmin.update-region',$school->udise)}}" class="step-link">
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
                                <a href="{{route('nodaladmin.update-bank',$school->udise)}}" class="step-link">
                                    5. Bank Details<br>&nbsp&nbsp&nbsp
                                    (बैंक सूचना)
                                </a>
                            </li>
                        </ul>
                        <div>
                            <div class="row" class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <table class="table table-responsive table-bordered custom-table">
                                        <thead class="thead-cls">
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Class</th>
                                                <th>Monthly Tution Fee (in Rs)</th>
                                                <th>Total Fees (in Rs)</th>
                                            </tr>
                                        </thead>
                                        <tr ng-repeat="item in feestructure">
                                            <td ng-bind="$index+1"></td>
                                            <td ng-if="item.level" ng-bind="item.level"></td>
                                            <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                                            <td><input ng-disabled="{{$disable_edit}}" type="number"
                                                    ng-model="item.tution_fee" class="form-control" validator="required"
                                                    ng-required="true" min="0"
                                                    ng-init="item = School.calculateTotalFee(item)"
                                                    ng-change="item = School.calculateTotalFee(item)"></td>
                                            <td ng-bind="item.total"></td>
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
                                            <input ng-disabled="{{$disable_edit}}" type="number" class="form-control"
                                                validator="required" ng-required="true" min="0"
                                                ng-model="School.pastSeatInfo.third_year">
                                        </td>
                                        <td>
                                            <input ng-disabled="{{$disable_edit}}" type="number" class="form-control"
                                                validator="required" ng-required="true" min="0"
                                                ng-model="School.pastSeatInfo.second_year">
                                        </td>
                                        <td>
                                            <input ng-disabled="{{$disable_edit}}" type="number" class="form-control"
                                                validator="required" ng-required="true" min="0"
                                                ng-model="School.pastSeatInfo.first_year">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" ng-init="School.initSeatDetails('{{$udise}}')">
                            <div class="col-sm-12 col-xs-12">
                                <table class="table table-responsive table-bordered custom-table">
                                    <thead class="thead-cls">
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Class</th>
                                            <th class="text-center">Total seats for New Admission Cycle {{ $year }} -  {{$year + 1 }}</th>
                                            <th class="text-center">25% RTE seats for New admission cycle {{ $year }} -  {{$year + 1 }}</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="item in School.seatinfo">
                                        <td ng-bind="$index+1"></td>
                                        <td ng-if="item.level" ng-bind="item.level"></td>
                                        <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                                        <?php //@if($disable_edit)
?>
                                        <td><input ng-disabled="{{$disable_edit}}" type="number"
                                                ng-model="item.total_seats" class="form-control" validator="required"
                                                ng-init="item = School.process25per(item)"
                                                ng-change="item = School.process25per(item)" ng-required="true" min="0">
                                        </td>
                                        <?php /* @else
<td><input type="number" ng-model="item.total_seats" class="form-control" validator="required" ng-required="true" min="0"></td>
@endif */?>
                                        <td ng-bind="item.available_seats"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <button ng-if="School.show_save_button" class="btn-theme step-link" type="submit">Save
                                    &amp; Continue</button>
                                <div ng-if="!School.show_save_button" class="alert alert-danger alert-dismissible"
                                    ng-cloak>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Note:</strong> Available seats cannot be less then allotted seats for this
                                    Admission Cycle.
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
@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div ng-controller="StudentController as Student" class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="all-admin-link">
					<h2>{{$student->first_name}}</h2>
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							<div class="form-group">
								<strong>Registration ID:</strong>
								<span class="grn">{{$student->registration_no}}</span>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">
							<div class="form-group">
								<strong>Student Class:</strong>
								<span>{{$student->level->level}}</span>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">
							<div class="form-group">
								<strong>Date of Birth:</strong>
								<span>{{$student->fmt_dob}}</span>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">

						</div>
					</div>



				</div>
			</div>
		</div>
		<div ng-init="Student.getAttendanceMonths({{$student->id}})" class="row">
			<div class="col-sm-9 col-xs-12">
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-body">
							<p>Please enter the attendance details in a monthly manner.</p>
							<form name="add-attendance" ng-submit="create('schooladmin/add/attendance', Student.monthData, 'add-attendance')">
								<table ng-init="Student.monthData.registration_id = {{$student->id}}" class="table table-responsive custom-table no-border">
									<thead>
										<tr>
											<th>Monthly</th>
											<th>Total Working Days</th>
											<th>No. of days present</th>
											<th>Present Percentage (%)</th>
										</tr>
									</thead>
									<tbody>[[Student.validity]]
										<tr ng-repeat="month in Student.monthData.attendances" ng-init="month.validity=false;month.validMonth=false;">

											<td ng-bind="month.month"></td>

											<td><input type="number" ng-model="month.total_days" class="form-control" validator="required" ng-required="true" ng-disabled="" min="0" ng-change="month.percentage = Student.calcPerc(month.total_days, month.attended_days);month.validity = Student.checkValid(month.total_days, month.attended_days);month.validMonth = Student.checkValidMonth(month.total_days);"><p ng-show="month.validMonth">Invalid number of days</p></td>


											<td><input type="number" ng-model="month.attended_days" class="form-control" validator="required" ng-required="true" ng-disabled="" min="0" ng-change="month.percentage = Student.calcPerc(month.total_days, month.attended_days);month.validity = Student.checkValid(month.total_days, month.attended_days);"><p class="text-warning"  ng-show="month.validity">No. of days present cannot be more then total working days</p></td>


											<td><input type="number" ng-init="month.percentage = Student.calcPerc(month.total_days, month.attended_days);month.validMonth = Student.checkValidMonth(month.total_days);" ng-model="month.percentage" class="form-control"  ng-disabled="true" min="0"></td>


										</tr>

									</tbody>
								</table>

								<button type="submit" class="btn btn-theme">Save</button>

							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3 col-xs-12">
					<p>Mark this student as dropped out from the school</p>
					<button type="button" ng-click="helper.student_id={{$student->id}};openPopup('schooladmin', 'student', 'drop-student', 'create-popup-style')" class="btn btn-danger" >Dropout</button>
				</div>
			</div>
		</div>
	</section>
	@endsection
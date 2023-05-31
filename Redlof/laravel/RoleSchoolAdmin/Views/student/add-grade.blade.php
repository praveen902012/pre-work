@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div ng-controller="StudentController as Student" class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="all-admin-link">
					<h2>{{$student->first_name}}</h2>
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							<div class="">
								<strong>Registration ID:</strong>
								<span class="grn">{{$student->registration_no}}</span>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">
							<div class="">
								<strong>Student Class:</strong>
								<span>{{$student->level->level}}</span>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">
							<div class="">
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
		<div ng-init="Student.getSubjects({{$student->level->id}},{{$student->id}})" class="row">
			<div class="col-sm-10 col-xs-12">
				<div class="panel-group">
					<div class="panel panel-default">
						<div ng-show="Student.subjectData.marks.length>0" class="panel-body">
							<p>Please enter the student marks subjectwise.</p>
							<form name="add-marks" ng-submit="create('schooladmin/add/marks', Student.subjectData, 'add-marks')"  ng-init="Student.subjectData.registration_id={{$student->id}}" >
								<table class="table table-responsive custom-table no-border">
									<thead>
										<tr>
											<th>Subjects</th>
											<th>Maximum Marks/grades</th>
											<th>Marks/grades Obtained</th>
											<th>Average marks of the class</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="mark in Student.subjectData.marks" ng-init="mark.checkMark=false">
											<td ng-bind="mark.subject.name"></td>
											<td><input type="number" ng-model="mark.total_marks" class="form-control" validator="required" ng-required="true" ng-disabled="" min="0" ng-change="mark.checkMark = Student.checkGrade(mark.total_marks,mark.scored_marks);" ></td>
											<td><input type="number" ng-model="mark.scored_marks" class="form-control" validator="required" ng-required="true" ng-disabled="" min="0" ng-change="mark.checkMark = Student.checkGrade(mark.total_marks,mark.scored_marks);"><p ng-if="mark.checkMark">Marks obtained cannot be more than maximum marks</p></td>
											<td><input type="number" ng-model="mark.avg_marks" class="form-control" validator="required" ng-required="true" ng-disabled="" min="0" ></td>
										</tr>
									</tbody>
								</table>
								<button  type="submit" class="btn btn-theme">Save</button>
							</div>
							<div ng-show="!Student.subjectData.marks.length>0" class="panel-body">
								<p>Please add subjects before adding student marks.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection
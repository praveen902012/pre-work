@extends('schooladmin::includes.layout')
@section('content')

<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-init="getAPIData('schooladmin/get/seat-info', 'seatinfo')">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12">

				<h2>Add seat information</h2>
				<p>Please fill out all the details for entry classes</p>
			</div><br>

			<form name="add-seat-structure" ng-submit="create('schooladmin/school/level-seat/add', seatinfo, 'add-seat-structure')">
			<div >
				<div class="row" class="row">
					<div class="col-sm-12 col-xs-12">

							<table class="table table-responsive table-bordered custom-table">
								<thead class="thead-cls">
									<tr>
										<th>Sr. No</th>
										<th>Class</th>
										<th>Total Seats</th>
										<th>Seats Available For Admission</th>
									</tr>
								</thead>

								<tr ng-repeat="item in seatinfo">
									<td>[[$index+1]]</td>
									<td>[[item.level]]</td>
									<td><input type="number" ng-model="item.total_seats" class="form-control" validator="required" ng-required="true" ng-disabled="{{$seat_filled}}" min="0"></td>
									<td><input type="number" ng-model="item.available_seats" class="form-control" validator="required" ng-required="true"  ng-disabled="{{$seat_filled}}" min="0"></td>
								</tr>

							</table>

					</div>
				</div>
			</div>
			@if($seat_filled==FALSE)
			<button class="btn-theme btn-green" type="submit">Save & Continue</button>
			@endif
			</form>
		</div>
	</div>
</section>
@endsection
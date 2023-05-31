@extends('schooladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-init="getAPIData('schooladmin/get/fee-structure', 'feestructure')">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
			<div class="col-sm-12 col-xs-12">

				<h2>Add fee structure</h2>
				<p>Please fill out all the details from class nursery to class 8</p>
			</div><br>
			<form name="add-fee-structure" ng-submit="create('schooladmin/school/level-fee/add', feestructure, 'add-fee-structure')">
			<div >
				<div class="row" class="row">
					<div class="col-sm-12 col-xs-12">

							<table class="table table-responsive table-bordered custom-table">
								<thead class="thead-cls">
									<tr>
										<th>Sr. No</th>
										<th>Class</th>
										<th>Dress Fees (in Rs)</th>
										<th>Books Fees (in Rs)</th>
										<th>Other Fees (in Rs)</th>
										<th>Total Fees (in Rs)</th>
									</tr>
								</thead>

								<tr ng-repeat="item in feestructure">
									<td>[[$index+1]]</td>
									<td>[[item.level]]</td>
									<td><input type="number" ng-model="item.dress_fee" class="form-control" validator="required" ng-required="true" ng-disabled="{{$add_fee}}" min="0"></td>
									<td><input type="number" ng-model="item.books_fee" class="form-control" validator="required" ng-required="true"  ng-disabled="{{$add_fee}}" min="0"></td>
									<td><input type="number" ng-model="item.other_fee" class="form-control" validator="required" ng-required="true" ng-disabled="{{$add_fee}}" min="0"></td>
									<td>[[item.dress_fee+item.books_fee+item.other_fee]]</td>
								</tr>

							</table>

					</div>
				</div>
			</div>
			@if($add_fee==FALSE)
			<button class="btn-theme btn-green" type="submit">Save & Continue</button>
			@endif
			</form>
		</div>
	</div>
</section>
@endsection
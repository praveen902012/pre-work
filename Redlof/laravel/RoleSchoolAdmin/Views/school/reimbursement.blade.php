@extends('schooladmin::includes.layout')
@section('content')
<section class="districtadmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List"  ng-cloak ng-init="List.init('school-list', {'getall': 'schooladmin/get/students/reimbursement/all'})">
		<div class="row">
			<div class="col-sm-5 col-xs-12">
				<div class="heading-strip">
					<h2>
					Reimbursement
					</h2>
				</div>
			</div>
			<div class="col-sm-7 col-xs-12">
				<div class="all-admin-link pull-right">
					<div class="form-inline">
						<div class="form-group well well-sm">
							Total Reimbursed Amount:Rs. {{$reimburse->reimbursement_amount}}
						</div>
						@if($reimburse->payment_status=='paid')
						<button ng-really-action="Mark as Not Received" ng-really-message="Do you want to mark it as not received?" ng-really-click="create('schooladmin/school/reimbursement/not_received',  school, 'not-received')" class="btn btn-danger btn-theme btn-alert">Did not receive</button>
						@endif
						@if($reimburse->payment_status=='not_received')
						<button ng-really-action="Mark as Received" ng-really-message="Do you want to mark it as received?" ng-really-click="create('schooladmin/school/reimbursement/received',  school, 'received')" class="btn btn-theme">Mark Received</button>
						@endif
					</div>
				</div>
			</div>

		</div>
		<div>
			<div ng-if="List.ListService.results.length > 0">
				<div   class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="search-action clearfix">
							<form class="">
								<div class="form-group">
									<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or UDISE" table-list-search="[[List.ListName]]">
								</div>
								<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">Search</button>
							</form>
						</div>
					</div>
					<div class="col-sm-5 col-xs-12">
				<div class="rt-action  pull-right" ng-controller="DownloadReportController as Download">
					<button  ng-if="List.ListService.results.length > 0" type="button" class="btn btn-warning pull-right" ng-click="Download.triggerDownload('schooladmin/get/students/reimbursement/all/download')"><i class="fa fa-download"></i> Download Excel</button>
				</div>
			</div>
				</div>
				<div class="table-responsive">
					<table class="table table-responsive custom-table table-bordered mrt-20" ng-init="total=0">
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Admission Cycle</th>
								<th>Student Name</th>
								<th>Student Category</th>
								<th>Class admitted</th>
								<th>Present Class</th>
								<th>Months present</th>
								<th>Per-Month Fee</th>
								<th>Total Reimbursement for the Year</th>
								<th>Bank Name</th>
								<th>Bank Account Number</th>
								<th>Bank IFSC Code</th>
							</tr>
						</thead>
						<tbody  ng-init="total = 0">
							<tr ng-repeat="student in List.ListService.results">
								<td>[[$index+1]]</td>
								<td>[[student.application_year]]</td>
								<td>[[student.student.first_name]] [[student.student.last_name]]</td>
								<td>[[student.student.personal_details.category]]</td>
								<td>[[student.student.level.level]]</td>
								<td>[[student.student.level.level]]</td>
								<td>[[student.total_months_present.total]]</td>
								<td>[[student.amount_payable/12]]</td>
								<td ng-init="$parent.total = $parent.total + (student.total_months_present.total*(student.amount_payable/12))">[[student.total_months_present.total*(student.amount_payable/12)]]</td>
								<td>[[student.student.bank_details.bank_name]]</td>
								<td>[[student.student.bank_details.account_number]]</td>
								<td>[[student.student.bank_details.ifsc_code]]</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<div class="all-admin-link pull-right">
							<div class="form-inline">
								<div class="form-group well well-sm">
									Total Reimbursement Amount:Rs. [[total]]
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="t-footer">
					<div class="row">
						<div class="col-sm-6 col-xs-6">
							<p>
								Showing [[List.ListService.currentPage]] of [[List.ListService.totalPage]] pages.
							</p>
						</div>
						<div class="col-sm-6 col-xs-6">
							<div class="prev-next pagination-custom tb-pagination pull-right">
								<table class="table">
									<td class="no-border">
										<ul class="list-unstyled list-inline text-left" ng-class="{ 'hide-pagination': !List.ListService.pagination }">
											<li>
												<a href="" ng-click="List.prevPage()" class="next-prev-link">
													<i class="fa ion-ios-arrow-left" aria-hidden="true"></i>
													<span>
														Prev [[List.ListService.pagesize]]
													</span>
												</a>
											</li>
											<li>
												<a href="" ng-click="List.nextPage()" class="next-prev-link">
													<span>
														Next [[List.ListService.pagesize]]
													</span>
													<i class="fa ion-ios-arrow-right" aria-hidden="true"></i>
												</a>
											</li>
										</ul>
									</td>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div align="center" class="col-sm-12 col-xs-12">
					<p ng-if="List.ListService.results.length == 0">No reimbursements to display</p>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
@endsection
@extends('districtadmin::includes.layout')
@section('content')
<section class="districtadmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div  ng-controller="ListController as List">
		<div class="container-fluid" ng-controller="SchoolController as School">
			<div class="row" >
				<div class="col-sm-6 col-xs-6">
					<div class="heading-strip">
						<h2>
							विद्यालय प्रतिपूर्ति
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="all-admin-link pull-right">
						<div class="form-inline">
							<div class="form-group" ng-init="School.initAdmissionCycle()">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									<select  class="form-control" ng-model="School.selectedCycle" id="sel1"  ng-init="School.selectedCycle='null'">
										<option value="null">Admission Cycle</option>
										<option value="[[cycle.session_year]]" ng-repeat="cycle in School.admissionCycle">[[cycle.session_year]] - [[cycle.session_year+1]]</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div >
				<div class="col-sm-12 col-xs-12">
					<div class="all-admin-link pull-right">
						<div class="form-inline">
							<div class="form-group">
								<div class="dropdown">
									<select class="form-control" ng-model="School.selectedStatus" id="sel2" ng-init="School.selectedStatus='null'">
										<option value="null">Select Status Payment</option>
										<option value="paid">Paid</option>
										<option value="not_paid">Not Paid</option>
										<option value="not_received">School did not receive</option>
									</select>
								</div>
							</div>
							<!-- <div class="form-group">
														<div class="dropdown">
																					<button class="btn btn-default dropdown-toggle" ng-init="School.ba='Select Block Admin'" type="button" data-toggle="dropdown">[[School.ba]]
																					<span class="caret"></span></button>
																					<ul class="dropdown-menu">
																					</ul>
														</div>
							</div> -->
							<div class="form-group"  ng-init="School.initNodalAdmin(); School.selectedNodal='null';">
								<select class="form-control" ng-model="School.selectedNodal" id="sel1" ng-init="School.selectedNodal='null'">
									<option value="null">Select Nodal Admin</option>
									<option ng-repeat="nodal in School.nodalData" value="[[nodal.id]]">[[nodal.user.first_name]]</option>
								</select>
							</div>
							<div class="form-group">
								<button ng-click="List.init('school-list', {'getall': 'districtadmin/get/schools/ac/'+[[School.selectedCycle]]+'/sop/'+[[School.selectedStatus]]+'/nodal/'+[[School.selectedNodal]], 'search': 'districtadmin/search/schools/ac/'+[[School.selectedCycle]]+'/sop/'+[[School.selectedStatus]]+'/nodal/'+[[School.selectedNodal]],'postTask': 'districtadmin/pay/selected'});School.checkbox='true'" class="btn btn-primary">Search Schools</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div ng-cloak ng-init="List.init('school-list', {'getall': 'districtadmin/get/schools/ac/'+[[School.selectedCycle]]+'/sop/'+[[School.selectedStatus]]+'/nodal/'+[[School.selectedNodal]], 'search': 'districtadmin/search/schools/ac/'+[[School.selectedCycle]]+'/sop/'+[[School.selectedStatus]]+'/nodal/'+[[School.selectedNodal]] ,'postTask': 'districtadmin/pay/selected'})">
				<div ng-if="List.ListService.results.length > 0">
					<div    ng-controller="DownloadReportController as Download"  class="row">
						<div class="col-sm-12 col-xs-12">
							<div class="search-action clearfix">
								<form class="">
									<div class="form-group">
										<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Name or UDISE" table-list-search="[[List.ListName]]">
									</div>
									<button class="btn-theme btn-blue" ng-click="List.search(keyword)" type="button">खोज</button>
									<div  ng-cloak ng-hide="!List.ListService.isAnySelected">
										<button class="btn-theme btn-blue" ng-really-close="true" ng-really-action="Pay" ng-really-message="Do you want to pay all the selected school?"? ng-really-click="List.postTask()">
										Pay All
										</button>
									</div>
									<button type="button" class="btn btn-info pull-right" ng-click="Download.triggerDownload('districtadmin/school/report/download/ac/'+[[School.selectedCycle]]+'/sop/'+[[School.selectedStatus]]+'/nodal/'+[[School.selectedNodal]])"><i class="fa fa-download"></i> Download Excel</button>
								</form>
							</div>
						</div>
					</div>
					<table class="table table-responsive custom-table table-bordered">
						<thead class="thead-cls">
							<tr>
								<th ng-show="School.selectedStatus=='not_paid' && School.checkbox">
									<div  class="checked">
										<input type="checkbox" ng-model="selectedAll" ng-click="List.toggleSelectAll(selectedAll);">
									</div>
								</th>
								<th>Sl.no</th>
								<th>विद्यालय का नाम</th>
								<th>U-डाइस</th>
								<th>School Nodal</th>
								<th>प्रतिपूर्ति की धनराशि (INR)</th>
								<th>स्थिति</th>
								<th>भुगतान की तिथि</th>
								<th>Reimbursed amount due (INR)</th>
								<th>एक्शन</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="school in List.ListService.results">
								<td ng-show="School.selectedStatus=='not_paid'  && School.checkbox">
									<div  class="checked">
										<input type="checkbox" ng-model="school.selected"  ng-click="List.toggleSelectItem(school.id, school.selected);">
									</div>
								</td>
								<td>[[$index+1]]</td>
								<td><a ng-href="school-student-reimbursement/[[school.id]]">[[school.name]]</a></td>
								<td>[[school.udise]]</td>
								<td>[[school.school_nodal.nodaladmin.user.display_name]]</td>
								<td ng-if="school.total_tution_fees.total">[[school.total_tution_fees.total]]</td>
								<td ng-if="!school.total_tution_fees.total"> - </td>
								<td>[[school.school_reimbursement.payment_status]]</td>
								<td ng-if="school.school_reimbursement.payed_on">[[school.school_reimbursement.fmt_dop]]</td>
								<td ng-if="!school.school_reimbursement.payed_on">-</td>
								<td>[[school.total_tution_fees.total - school.school_reimbursement.reimbursement_amount]]</td>
								<td ng-if="school.total_tution_fees.total && school.school_reimbursement.payment_status=='not_paid' && school.school_reimbursement.allow_status=='yes'">
									<button ng-really-action="Pay" ng-really-message="Do you want to mark it paid?" ng-really-click="create('districtadmin/school/reimbursement/pay/'+[[school.id]]+'/amount/'+[[school.total_tution_fees.total]],  student, 'paid')"  class="btn btn-success">Pay</button>
								</td>
								<td ng-if="school.school_reimbursement.payment_status=='paid' || school.school_reimbursement.payment_status=='received'">
									<button class="btn btn-primary disabled">Paid</button>
								</td>
								<td ng-if="school.school_reimbursement.payment_status=='not_received'">
									<button class="btn btn-primary disabled">Paid</button>
								</td>
								<td ng-if="!school.total_tution_fees.total && school.school_reimbursement.payment_status=='not_paid'&& school.school_reimbursement.allow_status=='no'">
									<button class="btn btn-warning disabled">Pay</button>
								</td>
							</tr>
						</tbody>
					</table>
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
						<p ng-if="List.ListService.results.length == 0">No Schools to display</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@extends('schooladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController" ng-init="School.getSchoolRegionDetails({{$school->id}})">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<form name="admin-add-school" class="common-form add-area" >
						<div id="exTab1">
							<ul  class="nav nav-pills reg-nav-block ">
								<li >
									<a href="{{route('schooladmin.school-profile-primary')}}" class="step-link">1. Primary Details</a>
								</li>
								<li >
									<a href="{{route('schooladmin.school-profile-address')}}" class="step-link">2. Address  Details</a>
								</li>
								<li class="active">
									<a class="step-link">3. Region Selection</a>
								</li>
								<li>
									<a href="{{route('schooladmin.school-profile-fee')}}"  class="step-link">4. Fee & Seat Details</a>
								</li>
								<li >
									<a  href="{{route('schooladmin.school-profile-bank')}}"  class="step-link">5. Bank Details</a>
								</li>
							</ul>
							<div class="tab-content clearfix rte-all-form-sp">
								<div class="tab-pane active" id="3a">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12">
										<div class="row">
											<div class="col-md-5 no-padding">
												<p class="pdb-5">[[School.regions.length]]  available choices</p>
												<div class="school-list-box">
													<table class="table table-fixed">
														<thead>
															<tr>
																<th class="font-sm col-xs-4">Area Name</th>
																<th class="col-xs-6 search-blk">
																	<i class="fa fa-search search-icon" aria-hidden="true"></i>
																	<input type="text" class="form-control" ng-model="search_region.name" placeholder="Search area">
																</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.regions| filter:search_region">
																<td class="col-xs-2">
																</td>
																<td class="col-xs-10">
																	<p class="font-sm">
																		<span ng-bind="region.name"></span>
																	</p>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="col-md-2 no-padding hidden-xs">
												<div class="dtable sp-arrow-block text-center">
													<div class="table-child">
														<i class="fa fa-long-arrow-right icon-arrow" aria-hidden="true"></i>
														<i class="fa fa-long-arrow-left icon-arrow" aria-hidden="true"></i>
													</div>
												</div>
											</div>
											<div class="col-md-5 no-padding">
												<p class="text-theme-green pdb-5">[[School.range0.length]]  selected choices</p>
												<div class="school-list-box">
													<table class="table table-fixed">
														<thead>
															<tr>
																<th class="font-sm col-xs-10">Area Name</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.range0">
																<td class="col-xs-2 text-center">
																</td>
																<td class="col-xs-10">
																	<p class="font-sm">
																		<span ng-bind="region.name"></span>
																	</p>
																</td>
															</tr>
														</tbody>
													</table>
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
		</div>
	</section>
	@endsection
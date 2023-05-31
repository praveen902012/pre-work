@extends('nodaladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController" ng-init="School.getSchoolRegionDetails({{$school->id}})">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
						<h2>
						Edit region selection
						</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<form name="admin-add-school" class="common-form add-area" ng-submit="School.saveSchoolNeighbourhood('{{$udise}}')">
						<div id="exTab1">
							<ul  class="nav nav-pills reg-nav-block ">
								<li >
									<a href="{{route('school.school-edit',$school->id)}}" class="step-link">1. Primary Details<br>&nbsp&nbsp&nbsp
										(प्राथमिक विवरण)
									</a>
								</li>
								<li >
									<a href="{{route('nodaladmin.edit-school-address',$school->udise)}}" class="step-link">2. Address  Details<br>&nbsp&nbsp&nbsp
										(पता विवरण)
									</a>
								</li>
								<li class="active">
									<a class="step-link">
										3. Region Selection<br>&nbsp&nbsp&nbsp
										(क्षेत्र चयन)
									</a>
								</li>
								<li>
									<a href="{{route('nodaladmin.update-fee',$school->udise)}}"  class="step-link">4. Fee & Seat Details<br>&nbsp&nbsp&nbsp
										(शुल्क और सीट विवरण)
									</a>
								</li>
								<li >
									<a  href="{{route('nodaladmin.update-bank',$school->udise)}}"  class="step-link">5. Bank Details<br>&nbsp&nbsp&nbsp
										(बैंक सूचना)
									</a>
								</li>
							</ul>
							<div class="tab-content clearfix rte-all-form-sp">
								<div class="tab-pane active" id="3a">
									<div class="row">
										<div class="col-md-8">
											<div class="form-group" >
												<h2>
												Select the neighbourhood areas of the school
												</h2>
												<p class="hindi-lbl">
													( स्कूल अपने पडोस के वार्ड या ग्राम पंचायत का चयन करें। पडोस के वार्ड या ग्राम पंचायत वो हों जहाँ से बच्चे आसानी से आपके विद्यालय में आ सकें और उनको वाहन लगवाने लेने की आवश्यकता ना पडे । )
												</p>
											</div >
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Select your neighbourhood wards (In Block): <span class="mand-field">*</span>
													<p class="hindi-lbl"> (हिंदी अनुवाद के अनुसार) (ब्लॉक में)
														<span class="mand-field">*</span>
													</p>
												</label>
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
																<th class="font-sm col-xs-2">Add</th>
																<th class="font-sm col-xs-4">Area Name</th>
																<th class="col-xs-6 search-blk">
																	<i class="fa fa-search search-icon" aria-hidden="true"></i>
																	<input ng-disabled="{{$disable_edit}}" type="text" class="form-control" ng-model="search_region.name" placeholder="Search area">
																</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.regions| filter:search_region">
																<td class="col-xs-2">
																	<button ng-disabled="{{$disable_edit}}"type="button" class="btn btn-theme" ng-click="School.selectRegion($index, region, '0-1')">
																	+
																	</button>
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
																<th class="font-sm col-xs-2">Remove</th>
																<th class="font-sm col-xs-10">Area Name</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.range0">
																<td class="col-xs-2 text-center">
																	<button ng-disabled="{{$disable_edit}}" type="button" class="btn btn-danger btn-rm" ng-click="School.removeRegion($index, region, '0-1')">
																	x
																	</button>
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
												<p class="text-lightgrey pdt-8">
													<small>Click on remove button to remove from selection</small>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Select your neighbourhood wards (In District): <span class="mand-field">*</span>
													<p class="hindi-lbl"> (अपने पड़ोस के वार्ड का चयन करें) (जिला में)
														<span class="mand-field">*</span>
													</p>
												</label>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12">
										<div class="row">
											<div class="col-md-5 no-padding">
												<p class="pdb-5">[[School.regionsDist.length]]  available choices</p>
												<div class="school-list-box">
													<table class="table table-fixed">
														<thead>
															<tr>
																<th class="font-sm col-xs-2">Add</th>
																<th class="font-sm col-xs-4">Area Name</th>
																<th class="col-xs-6 search-blk">
																	<i class="fa fa-search search-icon" aria-hidden="true"></i>
																	<input type="text" class="form-control" ng-model="search_regionDist.name" placeholder="Search area">
																</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.regionsDist| filter:search_regionDist">
																<td class="col-xs-2">
																	<button type="button" class="btn btn-theme" ng-click="School.selectRegionDist($index, region, '0-1')">
																	+
																	</button>
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
												<p class="text-theme-green pdb-5">[[School.range0Dist.length]]  selected choices</p>
												<div class="school-list-box">
													<table class="table table-fixed">
														<thead>
															<tr>
																<th class="font-sm col-xs-2">Remove</th>
																<th class="font-sm col-xs-10">Area Name</th>
															</tr>
														</thead>
														<tbody>
															<tr ng-repeat="region in School.range0Dist">
																<td class="col-xs-2 text-center">
																	<button type="button" class="btn btn-danger btn-rm" ng-click="School.removeRegionDist($index, region, '0-1')">
																	x
																	</button>
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
												<p class="text-lightgrey pdt-8">
													<small>Click on remove button to remove from selection</small>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<button ng-disabled="{{$disable_edit}}" type="submit" class="btn-theme">Save & Continue</button>
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
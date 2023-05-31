@extends('nodaladmin::includes.layout')
@section('content')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController" ng-init="School.getSchoolAddressDetails({{$school->id}})">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
						<h2>
							Edit address details
						</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<form name="admin-add-school" class="common-form add-area" ng-submit="School.saveSchoolAddress('nodaladmin/school/update/address/{{$udise}}')">
						<div id="exTab1">
							<ul class="nav nav-pills reg-nav-block ">
								<li>
									<a href="{{route('school.school-edit',$school->id)}}" class="step-link">
										1. Primary Details<br>&nbsp&nbsp&nbsp
										(प्राथमिक विवरण)
									</a>
								</li>
								<li class="active">
									<a class="step-link">
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
								<li>
									<a href="{{route('nodaladmin.update-fee',$school->udise)}}" class="step-link">
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
							<div class="tab-content clearfix rte-all-form-sp">


								<div class="tab-pane active" id="2a">
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field" ng-init="School.initStates('{{$state->slug}}')">
												<label>
													State&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(हिंदी अनुवाद के अनुसार)
														</span>
														<span class="mand-field">
															*
														</span>
													</p>
												</label>
												<ui-select ng-disabled="{{$disable_edit}}" class="" ng-model="School.schoolData.state" theme="select2" ng-change="School.clearStateData()">
													<ui-select-match placeholder="State">
														[[$select.selected.name]]
													</ui-select-match>
													<ui-select-choices repeat="item in School.states | filter:$select.search">
														[[item.name]]
													</ui-select-choices>
												</ui-select>
											</div>
										</div>
										<div class="col-sm-4 col-xs-12">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field" click-off="School.districts.length = 0">
												<label>
													District&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(हिंदी अनुवाद के अनुसार)
														</span> <span class="mand-field">
															*
														</span>
													</p>
												</label>
												<input ng-disabled="{{$disable_edit}}" ng-disabled="School.schoolData.state.length==0" class="form-control" autocomplete="off" type="text" name="state" placeholder="District" ng-click="School.initDistricts('{{$state->slug}}', School.schoolData.state)" ng-model="School.schoolData.district_name" ng-change="School.getDistricts('{{$state->slug}}', School.schoolData.state, School.schoolData.district_name)">
												<div class="filter-dropdown" ng-if="School.districts.length > 0; ">
													<ul class="custom-dropdown list-unstyled">
														<li ng-repeat="district in School.districts">
															<a href="" ng-bind="district.name" ng-click="School.chooseDistrict(district)" ng-class="{ active: $index==0}">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field" click-off="School.blocks.length = 0">
												<label>
													Block name&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(हिंदी अनुवाद के अनुसार)
														</span> <span class="mand-field">
															*
														</span> </p>
												</label>
												<input ng-disabled="{{$disable_edit}}" ng-disabled="School.schoolData.district_id.length==0" class="form-control" autocomplete="off" type="text" name="Block" placeholder="Block" ng-model="School.schoolData.block_name" ng-click="School.initBlocks('{{$state->slug}}', School.schoolData.district_id)" ng-change="School.getBlocks('{{$state->slug}}', School.schoolData.district_id, School.schoolData.block_name)">
												<div class="filter-dropdown" ng-if="School.blocks.length > 0; ">
													<ul class="custom-dropdown list-unstyled">
														<li ng-repeat="block in School.blocks">
															<a href="" ng-bind="block.name" ng-click="School.chooseBlock(block)" ng-class="{ active: $index==0}">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<label>
													Rural/Urban&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(ग्रामीण/ शहरी)
														</span> <span class="mand-field">
															*
														</span>
													</p>
												</label>
												<ui-select ng-disabled="{{$disable_edit}}" class="" ng-model="School.schoolData.stateType" on-select="School.choosestatetype($item)" theme="select2">
													<ui-select-match placeholder="Rural/Urban">
														[[$select.selected.name]]
													</ui-select-match>
													<ui-select-choices repeat="item in School.stateTypeAll | filter:$select.search">
														[[item.name]]
													</ui-select-choices>
												</ui-select>
											</div>
										</div>
										<div class="col-sm-6 col-xs-12">
											<div class="form-group form-field" click-off="School.blocks.length = 0">
												<label>
													Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(नगर निगम / नगर पालिका परिषद / नगर पंचायत)
														</span> <span class="mand-field">
															*
														</span> </p>
												</label>
												<div class="col-sm-8 col-xs-12">
													<input ng-disabled="{{$disable_edit}}" class="form-control" autocomplete="off" type="text" name="SubBlock" placeholder="SubBlock" ng-model="School.schoolData.sub_block_name" ng-click="School.initBlocks1('{{$state->slug}}', School.schoolData.block_id,School.schoolData.state_type,School.schoolData.district_id)">
												</div>
												<div class="filter-dropdown" ng-if="School.subblocks.length > 0; ">
													<ul class="custom-dropdown list-unstyled">
														<li ng-repeat="block in School.subblocks">
															<a href="" ng-bind="block.name" ng-click="School.chooseBlock1(block)" ng-class="{ active: $index==0}">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="row" ng-init="School.show_selection_type=false">
										<div class="col-md-4" ng-if="School.show_selection_type">
											<div class="form-group">
												<label>
													Select Ward or Gram Panchayat <span class="mand-field">*</span>
													<p class="hindi-lbl">
														(ईडब्लूएस कैटेगरी का आय प्रमाण ) <span class="mand-field">*</span>
													</p>
												</label>
												<ui-select ng-disabled="{{$disable_edit}}" class="" ng-model="School.schoolData.block_type" theme="select2" ng-init="income = [{value: 'ward', name: 'Ward' }, {value: 'panchayat', name: 'Gram Panchayat' }];" ng-change="School.schoolData.block_type = '[[$select.selected.value]]';School.show_selection_type=true">
													<ui-select-match placeholder="">
														[[$select.selected.name]]
													</ui-select-match>
													<ui-select-choices repeat="item.value as item in income | filter:$select.search">
														[[item.name]]
													</ui-select-choices>
												</ui-select>
											</div>
										</div>
										<div class="col-sm-4 col-xs-12" ng-if="School.schoolData.block_type">
											<div class="form-group form-field" click-off="School.localities.length = 0">
												<label ng-if="School.schoolData.block_type=='ward'">
													Ward Name <span class="mand-field">*</span>
													<p class="hindi-lbl">
														(हिंदी अनुवाद के अनुसार) <span class="mand-field">*</span>
													</p>
												</label>
												<label ng-if="School.schoolData.block_type=='panchayat'">
													Gram Panchayat <span class="mand-field">*</span>
													<p class="hindi-lbl">
														(हिंदी अनुवाद के अनुसार) <span class="mand-field">*</span>
													</p>
												</label>
												<input ng-disabled="{{$disable_edit}}" ng-disabled="School.schoolData.block_id.length==0" class="form-control" autocomplete="off" type="text" name="Locality" placeholder="Ward Name" ng-model="School.schoolData.locality_name" ng-change="School.getLocalities('{{$state->slug}}', School.schoolData.sub_block_id, School.schoolData.locality_name)">
												<div class="filter-dropdown" ng-if="School.localities.length > 0; ">
													<ul class="custom-dropdown list-unstyled">
														<li ng-repeat="locality in School.localities">
															<a href="" ng-bind="School.getWardName(locality)" ng-click="School.chooseLocality(locality)" ng-class="{ active: $index==0}">
															</a>
														</li>
													</ul>
												</div>
												<div ng-controller="DownloadReportController as Download">
													<a href="" ng-click="Download.triggerDownload('{{$state->slug}}/download/wards/'+[[School.schoolData.district_id]])" ng-show="School.schoolData.district_name.length>0 && School.schoolData.type=='panchayat'" class="full-nm-msg">Find your Gram Panchayat</a>
													<a href="" ng-click="Download.triggerDownload('{{$state->slug}}/download/wards/'+[[School.schoolData.district_id]])" ng-show="School.schoolData.district_name.length>0 && School.schoolData.type=='ward'" class="full-nm-msg">Find your Ward Name</a>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
									<!-- <div class="col-sm-4 col-xs-12">
                                            <div class="form-group form-field">
                                                <label>
                                                    Cluster <span class="mand-field">*</span>
                                                    <p class="hindi-lbl">
                                                        (हिंदी अनुवाद के अनुसार) <span class="mand-field">*</span>
                                                    </p>
                                                </label>
                                                <ui-select class=""
                                                    ng-click="School.getClusters(School.schoolData.block_id)"
                                                    ng-model="School.schoolData.cluster_id" theme="select2">
                                                    <ui-select-match placeholder="">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.id as item in School.clusters | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div> -->
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<label>
													Pincode&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(हिंदी अनुवाद के अनुसार)
														</span> <span class="mand-field">
															*
														</span>
													</p>
												</label>
												<input ng-disabled="{{$disable_edit}}" type="number" name="" ng-model="School.schoolData.pincode" class="form-control" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-8 col-xs-12">
											<div class="form-group form-field">
												<label>
													Postal Address&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>
															(हिंदी अनुवाद के अनुसार)
														</span><span class="mand-field">
															*
														</span>
													</p>
												</label>
												<textarea ng-disabled="{{$disable_edit}}" validator="required" valid-method="blur" name="website" ng-model="School.schoolData.address" ng-required="true" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<!-- <div class="row">
							<div class="col-sm-8 col-xs-12">
								<div class="form-group form-field">
									<label>
									Enter your address or nearest landmark&nbsp;
									<p class="hindi-lbl">
										<span>
											(हिंदी अनुवाद के अनुसार)
										</span>
									</p>
								</label>
									<div style="position: relative" >
										<input ng-disabled="{{$disable_edit}}" id="selectlocation" places-auto-complete component-restrictions="{country:'IN'}" ng-model="address" class="form-control" on-place-changed="School.placeChanged()">
									</div>
									<br>
									<label>
										Tip: Type your school name or nearest popular area to locate your school on the map
										<p class="hindi-lbl">
											<span>
												(हिंदी अनुवाद के अनुसार)
											</span>
										</p>
										<ng-map disable-default-u-i="{{$disable_edit}}"  style="height: 300px;width: 100%" center="12.9714, 77.5944" zoom="13">
											<marker  centered="true" on-dragend="School.placeDragged()" draggable="true" ng-repeat="location in School.locations" position="[[location.pos]]" visible="true"></marker>
										</ng-map>
									</label>
									<br>
									<label>
										Google Maps Address:
										<p class="hindi-lbl">
											<span>
												(हिंदी अनुवाद के अनुसार)
											</span>
										</p>
										<textarea ng-disabled="{{$disable_edit}}" placeholder="Venue" id="venue" ng-model="School.schoolData.venue" class="form-control"></textarea>
									</label>
								</div>
							</div>
						</div> -->
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<button ng-disabled="{{$disable_edit}}" class="btn-theme step-link" type="submit">Update &amp; Continue</button>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
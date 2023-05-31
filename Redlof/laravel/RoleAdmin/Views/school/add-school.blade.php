@extends('admin::includes.layout')
@section('content')
<section  class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak ng-init="List.init('schools-list', {'getall': 'admin/schools/{{$state->id}}'})">
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<a ng-href="{{ route('admin.state.single', $state->slug) }}">
							<img src="{{$state->fmt_logo}}" height="50" alt="{{$state->name}}">
						</a>
						<h2>
						{{ $state->name }} - {{ $title }}
						</h2>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="rt-action pull-right">
					<a class="btn-theme btn-blue mrgn-rt10" href="{{ route('admin.state.single', $state->slug) }}">
						{{ $state->name }}
						</a>
						<a class="btn-theme btn-blue no-margin" href="{{ route('admin.school.get', $state->slug ) }}">
							Go Back
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<section ng-controller="AppController">
					<div ng-controller="SchoolController as School">
						<div ng-init="School.schoolData.state_id={{ $state->id }};School.schoolData.state_slug={{ $state->slug }};School.schoolData.state_name={{ $state->name }} ">
							<form name="admin-add-school" class="common-form add-area" ng-submit="School.saveSchool('admin/school/add', '{{$state->slug}}')">
								<div id="primary">
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<div class="form-group">
												<label>
													School Name *
												</label>
												<input validator="required" valid-method="blur" type="text" name="name" ng-model="School.schoolData.name" ng-required="true" class="form-control">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													School Logo
												</label>
												<div class="form-group">
													<div ngf-drop ngf-select ng-model="School.schoolData.image" class="drop-box center-block"
														ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'" style="margin:0px 0 20px;">Click Or Drop Here
													</div>
													<div ngf-no-file-drop>
														File Drag/Drop is not supported for this browser
													</div>
													<span>Image size should not exceed 1 mb</span>
												</div>
												<img width="300" style="width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="School.schoolData.image" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													UDISE Code *
												</label>
												<input validator="required" valid-method="blur" type="text" name="udise" ng-model="School.schoolData.udise" ng-required="true" class="form-control">
											</div>
										</div>
									</div>
									<div class="text-center">

									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Medium of Instruction *
												</label>
												<div class="form-group" >
													<ui-select class="" ng-model="School.schoolData.medium" theme="select2" ng-init="getAPIData('admin/get/languages/list', 'languages')">
													<ui-select-match placeholder="Select">
													[[$select.selected.name]]
													</ui-select-match>
													<ui-select-choices repeat="item.value as item in languages | filter:$select.search">
													[[item.name]]
													</ui-select-choices>
													</ui-select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Established Since *
												</label>
												<div class="form-group" >
													<input validator="required" valid-method="blur" type="text" name="name" ng-model="School.schoolData.eshtablished" ng-required="true" class="form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Contact Number *
												</label>
												<input validator="required" valid-method="blur" type="text" name="phone" ng-model="School.schoolData.phone" ng-required="true" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Admin Mobile Number *
												</label>
												<input validator="required" valid-method="blur" type="text" name="admin_phone" ng-model="School.schoolData.admin_phone" ng-required="true" class="form-control">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<div class="form-group form-field" ng-init="getAPIData('{{$state->slug}}/get/levels/all', 'levels')">
												<label>
													Entry Classes&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">*</span>
													</p>
												</label>
												<span ng-repeat="level in levels">
													<label class="custom-check">
														<input type="checkbox" id="[[level.id]]" name="levels" ng-value="[[level.id]]" ng-model="School.schoolData.level[[level.id]]">[[level.level]]
														<p class="hindi-lbl">
															<span>
																(हिंदी अनुवाद )
															</span>
														</p>
													</label>
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Email ID *
												</label>
												<input validator="required" valid-method="blur" type="text" name="phone" ng-model="School.schoolData.admin_email" ng-required="true" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Website Link
												</label>
												<input validator="required" valid-method="blur" type="url" name="website" ng-model="School.schoolData.website"  class="form-control">
												<span class="full-nm-msg">Eg: http://school-website.com</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<div class="form-group">
												<label>
													Address *
												</label>
												<textarea validator="required" valid-method="blur" name="website" ng-model="School.schoolData.address" ng-required="true" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label>
												District *
											</label>
											<div class="form-group" click-off="School.districts.length = 0">
												<input   class="form-control" autocomplete="off" type="text" name="state" placeholder="District" ng-model="School.schoolData.district_name" ng-change="School.getDistricts('{{$state->id}}', School.schoolData.district_name)">
												<div class="custom-dropdown" ng-if="School.districts.length > 0; ">
													<ul class="list-unstyled">
														<li ng-repeat="district in School.districts">
															<a href="" ng-bind="district.name" ng-click="School.chooseDistrict(district)">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<label>
												Pincode *
											</label>
											<div class="form-group">
												<input type="number" name="" ng-model="School.schoolData.pincode" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label>
												Block name *
											</label>
											<div class="form-group" click-off="School.blocks.length = 0">
												<input ng-disabled="School.schoolData.district_id.length==0"  class="form-control" autocomplete="off" type="text" name="Block" placeholder="Block" ng-model="School.schoolData.block_name" ng-change="School.getBlocks(School.schoolData.district_id, School.schoolData.block_name)" >
												<div class="custom-dropdown" ng-if="School.blocks.length > 0; ">
													<ul class="list-unstyled">
														<li ng-repeat="block in School.blocks">
															<a href="" ng-bind="block.name" ng-click="School.chooseBlock(block)">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<label>
												Locality (Panchayat Name/Ward)​​​​​​​ *
											</label>
											<div class="form-group" click-off="School.localities.length = 0">
												<input ng-disabled="School.schoolData.block_id.length==0"  class="form-control" autocomplete="off" type="text" name="Locality" placeholder="Locality" ng-model="School.schoolData.locality_name" ng-change="School.getLocalities(School.schoolData.block_id, School.schoolData.locality_name)">
												<div class="custom-dropdown" ng-if="School.localities.length > 0; ">
													<ul class="list-unstyled">
														<li ng-repeat="locality in School.localities">
															<a href="" ng-bind="locality.name" ng-click="School.chooseLocality(locality)">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label>
												Sub locality (Revenue Village / Ward Name) *
											</label>
											<div class="form-group" click-off="School.sub_localities.length = 0">
												<input ng-disabled="School.schoolData.locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub locality" placeholder="Sub locality" ng-model="School.schoolData.sub_locality_name" ng-change="School.getSubLocalities(School.schoolData.locality_id, School.schoolData.sub_locality_name)" >
												<div class="custom-dropdown" ng-if="School.sub_localities.length > 0; ">
													<ul class="list-unstyled">
														<li ng-repeat="sublocality in School.sub_localities">
															<a href="" ng-bind="sublocality.name" ng-click="School.chooseSubLocality(sublocality)">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<label>
												Sub-sub locality (Habitation Name) *
											</label>
											<div class="form-group" click-off="School.sub_sub_localities.length = 0">
												<input ng-disabled="School.schoolData.sub_locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub-sub locality" placeholder="Sub-sub locality" ng-model="School.schoolData.sub_sub_locality_name" ng-change="School.getSubSubLocalities(School.schoolData.sub_locality_id, School.schoolData.sub_sub_locality_name)" >
												<div class="custom-dropdown" ng-if="School.sub_sub_localities.length > 0; ">
													<ul class="list-unstyled">
														<li ng-repeat="subsublocality in School.sub_sub_localities">
															<a href="" ng-bind="subsublocality.name" ng-click="School.chooseSubSubLocality(subsublocality)">
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<div class="form-group">
												<div style="position: relative" >
													<input id="selectlocation" places-auto-complete component-restrictions="{country:'IN'}" ng-model="address" class="form-control" on-place-changed="School.placeChanged()">
												</div>
												<br>
												<ng-map style="height: 300px" center="12.9716, 77.5946" zoom="14">
												<marker centered="true" on-dragend="School.placeDragged()" draggable="true" ng-repeat="location in School.locations" position="[[location.pos]]" visible="true"></marker>
												</ng-map>
												<br>
												<textarea placeholder="Venue" id="venue" ng-model="School.schoolData.venue" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-xs-12">
											<button type="submit" class="btn-theme">Save</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
</section>
@endsection
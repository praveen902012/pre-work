@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing" ng-controller="SchoolController as School">
	<div class="container" ng-controller="AppController">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="heading-strip all-pg-heading " ng-init="step_value='step1'">
						<h2>
						School Registration
						</h2>
						<p>
							Register here for filling up Application Form for EWS/DG Admission for session {{date("Y")}}-{{date("y")+1}}
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<form name="admin-add-school" class="common-form add-area" ng-submit="School.saveSchool('{{$state->slug}}/new/school/add', '{{$state->slug}}')">
						<div id="exTab1">
							<ul  class="nav nav-pills reg-nav-block ">
								<li ng-class="{ active: step_value=='step1'}">
									<a class="step-link" href="#1a" data-toggle="tab" ng-click="step_value='step1'">1. Primary Details</a>
								</li>
								<li ng-class="{ active: step_value=='step2'}">
									<a class="step-link" href="#2a" data-toggle="tab" ng-click="step_value='step2'; School.reInitializeMap()">2. Address  Details</a>
								</li>
								<li ng-class="{ active: step_value=='step3'}">
									<a class="step-link" href="#3a" data-toggle="tab" ng-click="step_value='step2'">3. Region Selection</a>
								</li>
							</ul>
							<div class="tab-content clearfix rte-all-form-sp">
								<div class="tab-pane active" id="1a">
									<div class="row">
										<div class="col-sm-8 col-xs-12">
											<div class="form-group form-field">
												<label>
													School Name&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">*</span>
													</p>
												</label>
												<input validator="required" valid-method="blur" type="text" name="name" ng-model="School.schoolData.name" ng-required="true" class="form-control">
												<!-- <p class="validation-msg ">Please enter your school full name</p> -->
												<span class="full-nm-msg">As an admin you need to enter full name of your school to get properly verified by the nodal officer</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<label>
													UDISE Code&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">
														*
													</span>
												</p>
											</label>
											<input validator="required" valid-method="blur" type="text" name="udise" ng-model="School.schoolData.udise" ng-required="true" class="form-control">
										</div>
									</div>
									<div class="col-sm-4 col-xs-12">
										<div class="form-group form-field" ng-cloak>
											<label>
												Medium of Instruction&nbsp;<span class="mand-field">*</span>
												<p class="hindi-lbl">
													<span>
														(हिंदी अनुवाद के अनुसार)
														</span><span class="mand-field"> *</span>
													</p>
												</label>
												<ui-select class="" ng-model="School.schoolData.medium" theme="select2" ng-init="getAPIData('{{$state->slug}}/get/languages/all', 'languages')">
												<ui-select-match placeholder="Select medium">
												[[$select.selected.name]]
												</ui-select-match>
												<ui-select-choices repeat="item.value as item in languages | filter:$select.search">
												[[item.name]]
												</ui-select-choices>
												</ui-select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<!-- <label>
																	Established Since&nbsp;<span class="mand-field">*</span>
																	<p class="hindi-lbl">
																						<span>(हिंदी अनुवाद के अनुसार)</span> <span class="mand-field">
																						*
																																																													</span>											</p>
												</label>
												<input validator="required" valid-method="blur" type="number" name="name" ng-model="School.schoolData.eshtablished" ng-required="true" class="form-control"> -->
												<label>
													Class Upto&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span>
														<span class="mand-field">
															*
														</span>
													</p>
												</label>
												<ui-select class="" ng-model="School.schoolData.type" theme="select2"  ng-init="classes = [{id: 'kg2', name: 'KG 2'},{id: 'class1', name: 'Class 1'},{id: 'class2', name: 'Class 2'},{id: 'class3', name: 'Class 3'},{id: 'class4', name: 'Class 4'},{id: 'class5', name: 'Class 5'},{id: 'class6', name: 'Class 6'},{id: 'class7', name: 'Class 7'},{id: 'class8', name: 'Class 8'},{id: 'class9', name: 'Class 9'},{id: 'class10', name: 'Class 10'},{id: 'class11', name: 'Class 11'},{id: 'class12', name: 'Class 12'}]">
												<ui-select-match placeholder="Select">
												[[$select.selected.name]]
												</ui-select-match>
												<ui-select-choices repeat="item.id as item in classes | filter:$select.search">
												[[item.name]]
												</ui-select-choices>
												</ui-select>
											</div>
										</div>
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<label>
													Type&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span>
														<span class="mand-field">
															*
														</span>
													</p>
												</label>
												<ui-select class="" ng-model="School.schoolData.school_type" theme="select2"  ng-init="types = [{id: 'co-educational', name: 'Co-Educational'},{id: 'boys', name:'Boys School'},{id: 'girls', name: 'Girls School'}]">
												<ui-select-match placeholder="Select">
												[[$select.selected.name]]
												</ui-select-match>
												<ui-select-choices repeat="item.id as item in types | filter:$select.search">
												[[item.name]]
												</ui-select-choices>
												</ui-select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-xs-12">
											<div class="form-group form-field">
												<label>
													Contact Number&nbsp;<span class="mand-field">*</span>
													<p class="hindi-lbl">
														<span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">
														*
													</span>
												</p>
											</label>
											<input validator="required" valid-method="blur" type="text" name="phone" ng-model="School.schoolData.phone" ng-required="true" class="form-control">
										</div>
									</div>
									<div class="col-sm-4 col-xs-12">
										<div class="form-group form-field">
											<label>
												Admin Mobile Number&nbsp;<span class="mand-field">*</span>
												<p class="hindi-lbl">
													<span>
														(हिंदी अनुवाद के अनुसार)
													</span> <span class="mand-field">
													*
												</span>
											</p>
										</label>
										<input validator="required" valid-method="blur" type="text" name="admin_phone" ng-model="School.schoolData.admin_phone" ng-required="true" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4 col-xs-12">
									<div class="form-group form-field" ng-init="getAPIData('{{$state->slug}}/get/levels/all', 'levels')">
										<label>
											Entry Classes&nbsp;<span class="mand-field">*</span>
											<p class="hindi-lbl">
												<span>(हिंदी अनुवाद के अनुसार)</span><span class="mand-field">*</span>
											</p>
										</label>
										<span ng-repeat="level in levels" ng-cloak>
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
								<div class="col-sm-4 col-xs-12">
									<div class="form-group form-field">
										<label>
											School Image
											<p class="hindi-lbl"><span>
												(हिंदी अनुवाद के अनुसार)
											</span>
										</p>
									</label>
									<div class="clearfix">
										<span class="uploaded-img">
											<img width="300" style="width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="School.schoolData.image" />
										</span>
										<span class="upload-action">
											<span ngf-drop ngf-select ng-model="School.schoolData.image" class="upload-btn"
												ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">+ Upload image
											</span>
											<div ngf-no-file-drop>
												File Drag/Drop is not supported for this browser
											</div>
											<span>Image size should not exceed 1 mb</span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-xs-12">
								<div class="form-group form-field">
									<label>
										Email ID&nbsp;<span class="mand-field">*</span>
										<p class="hindi-lbl">
											<span>(हिंदी अनुवाद के अनुसार</span>)<span class="mand-field">
											*
										</span>
									</p>
								</label>
								<input validator="required" valid-method="blur" type="text" name="admin_email" ng-model="School.schoolData.admin_email" ng-required="true" class="form-control">
							</div>
						</div>
						<div class="col-sm-4 col-xs-12">
							<div class="form-group form-field">
								<label>
									Website Link&nbsp;<span class="mand-field"></span>
									<p class="hindi-lbl">
										<span>
											(हिंदी अनुवाद के अनुसार)
										</span><span class="mand-field">
									</span>
								</p>
							</label>
							<input validator="required" valid-method="blur" type="url" name="website" ng-model="School.schoolData.website" class="form-control">
							<span class="full-nm-msg">Eg: http://school-website.com</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-xs-12">
						<div class="form-group form-field">
							<label>
								School Description&nbsp;
								<p class="hindi-lbl">
									<span>
										(हिंदी अनुवाद के अनुसार)
									</span>
								</p>
							</label>
							<textarea spellcheck="true" rows="4"  name="description" ng-model="School.schoolData.description"  class="form-control"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<a class="btn-theme step-link" href="#2a" data-toggle="tab" ng-click="step_value='step2'">Next</a>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="2a">
				<div class="row">
					<div class="col-sm-4 col-xs-12">
						<div class="form-group form-field" ng-init="School.initStates('{{$state->slug}}')">
							<label>
								State&nbsp;<span class="mand-field">*</span>
								<p class="hindi-lbl">
									<span>
										(हिंदी अनुवाद के अनुसार)
									</span> <span class="mand-field">
									*
								</span>
							</p>
						</label>
						<ui-select class="" ng-model="School.schoolData.state" theme="select2" ng-change="School.clearStateData()">
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
					<input ng-disabled="School.schoolData.state.length==0"  class="form-control" autocomplete="off" type="text" name="state" placeholder="District" ng-click="School.initDistricts('{{$state->slug}}', School.schoolData.state)" ng-model="School.schoolData.district_name" ng-change="School.getDistricts('{{$state->slug}}', School.schoolData.state, School.schoolData.district_name)">
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
					</span>						</p>
				</label>
				<input ng-disabled="School.schoolData.district_id.length==0"  class="form-control" autocomplete="off" type="text" name="Block" placeholder="Block" ng-model="School.schoolData.block_name" ng-click="School.initBlocks('{{$state->slug}}', School.schoolData.district_id)" ng-change="School.getBlocks('{{$state->slug}}', School.schoolData.district_id, School.schoolData.block_name)" >
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
			<div class="form-group form-field" click-off="School.localities.length = 0">
				<label>
					Ward Name/Ward Number​&nbsp;<span class="mand-field">*</span>
					<p class="hindi-lbl">
						<span>
							(हिंदी अनुवाद के अनुसार)
						</span><span class="mand-field">
						*
					</span>
				</p>
			</label>
			<input ng-disabled="School.schoolData.block_id.length==0"  class="form-control" autocomplete="off" type="text" name="Locality" placeholder="Ward Name" ng-model="School.schoolData.locality_name" ng-change="School.getLocalities('{{$state->slug}}', School.schoolData.block_id, School.schoolData.locality_name)">
			<div class="filter-dropdown" ng-if="School.localities.length > 0; ">
				<ul class="custom-dropdown list-unstyled">
					<li ng-repeat="locality in School.localities">
						<a href="" ng-bind="locality.name" ng-click="School.chooseLocality(locality)" ng-class="{ active: $index==0}">
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
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
				<input type="number" name="" ng-model="School.schoolData.pincode" class="form-control" required>
			</div>
		</div>
</div>
<!-- <div class="row">
				<div class="col-sm-4 col-xs-12">
									<div class="form-group form-field" click-off="School.sub_localities.length = 0">
														<label>
																			Sub locality (Revenue Village / Ward Name)&nbsp;<span class="mand-field">*</span>
																			<p class="hindi-lbl">
																								<span>
																													(हिंदी अनुवाद के अनुसार)
																								</span>
																								<span class="mand-field">
																													*
																								</span>
																			</p>
														</label>
														<input ng-disabled="School.schoolData.locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub locality" placeholder="Sub locality" ng-model="School.schoolData.sub_locality_name" ng-change="School.getSubLocalities('{{$state->slug}}', School.schoolData.locality_id, School.schoolData.sub_locality_name)" >
														<div class="filter-dropdown" ng-if="School.sub_localities.length > 0; ">
																			<ul class="custom-dropdown list-unstyled">
																								<li ng-repeat="sublocality in School.sub_localities">
																													<a href="" ng-bind="sublocality.name" ng-click="School.chooseSubLocality(sublocality)" ng-class="{ active: $index==0}">
																													</a>
																								</li>
																			</ul>
														</div>
									</div>
				</div>
				<div class="col-sm-4 col-xs-12">
									<div class="form-group form-field" click-off="School.sub_sub_localities.length = 0">
														<label>
																			Sub-sub locality (Habitation Name)&nbsp;<span class="mand-field">*</span>
																			<p class="hindi-lbl">
																								<span>
																													(हिंदी अनुवाद के अनुसार)
																								</span>
																								<span class="mand-field">
																													*
																								</span>
																			</p>
														</label>
														<input ng-disabled="School.schoolData.sub_locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub-sub locality" placeholder="Sub-sub locality" ng-model="School.schoolData.sub_sub_locality_name" ng-change="School.getSubSubLocalities('{{$state->slug}}', School.schoolData.sub_locality_id, School.schoolData.sub_sub_locality_name)" >
														<div class="filter-dropdown" ng-if="School.sub_sub_localities.length > 0; ">
																			<ul class="custom-dropdown list-unstyled">
																								<li ng-repeat="subsublocality in School.sub_sub_localities">
																													<a href="" ng-bind="subsublocality.name" ng-click="School.chooseSubSubLocality(subsublocality)" ng-class="{ active: $index==0}">
																													</a>
																								</li>
																			</ul>
														</div>
									</div>
				</div>
</div> -->
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
		<textarea validator="required" valid-method="blur" name="website" ng-model="School.schoolData.address" ng-required="true" class="form-control"></textarea>
	</div>
</div>
</div>
<div class="row">
<div class="col-sm-8 col-xs-12">
	<div class="form-group form-field">
		<div style="position: relative" >
			<input id="selectlocation" places-auto-complete component-restrictions="{country:'IN'}" ng-model="address" class="form-control" on-place-changed="School.placeChanged()">
		</div>
		<br>
		<label>
			Tip: Type your school name or nearest popular area to locate your school on the map
			<p class="hindi-lbl">
				<span>
					(हिंदी अनुवाद के अनुसार)
				</span>
			</p>
			<ng-map style="height: 300px;width: 100%" center="12.9714, 77.5944" zoom="13">
			<marker centered="true" on-dragend="School.placeDragged()" draggable="true" ng-repeat="location in School.locations" position="[[location.pos]]" visible="true"></marker>
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
			<textarea placeholder="Venue" id="venue" ng-model="School.schoolData.venue" class="form-control"></textarea>
		</label>
	</div>
</div>
</div>
<div class="row">
<div class="col-sm-12 col-xs-12">
	<a class="btn-theme step-link" href="#3a" data-toggle="tab" ng-click="step_value='step3'; School.regionSelection('{{$state->slug}}')">Next</a>
</div>
</div>
</div>
<div class="tab-pane" id="3a">
<div class="row">
<div class="col-md-8">
	<div class="form-group" >
		<h2>
		Select the neighbourhood areas of the school
		</h2>
	</div >
</div>
</div>
<div class="row">
<div class="col-md-6">
	<div class="form-group">
		<label>
			Select your ward: <span class="mand-field">*</span>
			<p class="hindi-lbl"> (हिंदी अनुवाद के अनुसार)
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
							<input type="text" class="form-control" ng-model="search_region.name" placeholder="Search area">
						</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="region in School.regions| filter:search_region">
						<td class="col-xs-2">
							<button type="button" class="btn btn-theme" ng-click="School.selectRegion($index, region, '0-1')">
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
							<button type="button" class="btn btn-danger btn-rm" ng-click="School.removeRegion($index, region, '0-1')">
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
			Select your neighbourhood ward: <span class="mand-field">*</span>
			<p class="hindi-lbl"> (हिंदी अनुवाद के अनुसार)
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
							<input type="text" class="form-control" ng-model="search_region.name" placeholder="Search area">
						</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="region in School.regions| filter:search_region">
						<td class="col-xs-2">
							<button type="button" class="btn btn-theme" ng-click="School.selectRegion($index, region, '1-3')">
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
		<p class="text-theme-green pdb-5">[[School.range1.length]]  selected choices</p>
		<div class="school-list-box">
			<table class="table table-fixed table-fixed-selected">
				<thead>
					<tr>
						<th class="font-sm col-xs-2">Remove</th>
						<th class="font-sm col-xs-10">Area Name</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="region in School.range1">
						<td class="col-xs-2 text-center">
							<button type="button" class="btn btn-danger btn-rm" ng-click="School.removeRegion($index, region, '1-3')">
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
			Select extended neighbourhood ward: <span class="mand-field">*</span>
			<p class="hindi-lbl"> (हिंदी अनुवाद के अनुसार)
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
							<input type="text" class="form-control" ng-model="search_region.name" placeholder="Search area">
						</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="region in School.regions| filter:search_region">
						<td class="col-xs-2">
							<button type="button" class="btn btn-theme" ng-click="School.selectRegion($index, region, '3-6')">
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
		<p class="text-theme-green pdb-5">[[School.range3.length]]  selected choices</p>
		<div class="school-list-box">
			<table class="table table-fixed table-fixed-selected">
				<thead>
					<tr>
						<th class="font-sm col-xs-2">Remove</th>
						<th class="font-sm col-xs-10">Area Name</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="region in School.range3">
						<td class="col-xs-2 text-center">
							<button type="button" class="btn btn-danger btn-rm" ng-click="School.removeRegion($index, region, '3-6')">
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
	<button type="submit" class="btn-theme">Save</button>
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
@include('state::includes.footer')
@include('state::includes.foot')
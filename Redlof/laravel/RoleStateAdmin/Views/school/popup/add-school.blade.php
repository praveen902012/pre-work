<section ng-controller="AppController">
	<div ng-controller="SchoolController as School">
	<div class="header-popup-ad">
		<h2>
			Add School
		</h2>
		<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
	</div>

	<div class="popup-content-ad">

		<form name="stateadmin-add-school" class="common-form add-area" ng-submit="School.saveSchool('stateadmin/school/add', '[[helper.state_slug]]')">
			<div id="primary">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>
							School Name *
						</label>
						<input validator="required" valid-method="blur" type="text" name="name" ng-model="School.schoolData.name" ng-required="true" class="form-control">
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">

					<div class="col-md-6">
						<div class="form-group">

							<label>
								School Logo
							</label>
							<div class="form-group">
								<div ngf-drop ngf-select ng-model="School.schoolData.image" class="drop-box center-block"
								ngf-drag-over-class="dragover" ngf-multiple="false" ngf-allow-dir="true" accept="image/*" ngf-pattern="'image/*'">Click Or Drop Here
							</div>

							<div ngf-no-file-drop>
								File Drag/Drop is not supported for this browser
							</div>
							<span>Image size should not exceed 1 mb</span>
						</div>

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
				<img width="300" style="margin:auto;width:100px;" class="img-responsive set-cropped-image" ngf-thumbnail="School.schoolData.image" />
			</div>

			<div class="col-sm-12 col-xs-12">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							Medium of Instruction *
						</label>
						<div class="form-group" >
							<ui-select class="" ng-model="School.schoolData.medium" theme="select2" ng-init="getAPIData('stateadmin/get/languages/list', 'languages')">
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

			<div class="col-sm-12 col-xs-12">
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

			<div class="col-sm-12 col-xs-12">
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
							Website Link *
						</label>
						<input validator="required" valid-method="blur" type="url" name="website" ng-model="School.schoolData.website" ng-required="true" class="form-control">
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="col-sm-12 col-xs-12">
				<div class="form-group">
					<label>
						Address *
					</label>
					<textarea validator="required" valid-method="blur" name="website" ng-model="School.schoolData.address" ng-required="true" class="form-control"></textarea>
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="col-md-6">
					<label>
						State *
					</label>
					<div class="form-group" ng-init="getAPIData('stateadmin/states/get/all', 'states')">
						<ui-select class="" ng-model="School.schoolData.state" theme="select2" ng-change="School.clearStateData()">
							<ui-select-match placeholder="State">
								[[$select.selected.name]]
							</ui-select-match>
							<ui-select-choices repeat="item in states | filter:$select.search">
								[[item.name]]
							</ui-select-choices>
						</ui-select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>
							Max Fees *
						</label>
						<input validator="required" valid-method="blur" type="text" name="udise" ng-model="School.schoolData.max_fees" ng-required="true" class="form-control">
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-xs-12">
				<div class="col-md-6">
					<label>
						District *
					</label>
					<div class="form-group">
						<input ng-disabled="School.schoolData.state.length==0"  class="form-control" autocomplete="off" type="text" name="state" placeholder="District" ng-model="School.schoolData.district_name" ng-change="School.getDistricts(School.schoolData.state, School.schoolData.district_name)">

						<div class="filter-dropdown" ng-if="School.districts.length > 0; ">
							<ul>
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

			<div class="col-sm-12 col-xs-12">
				<div class="col-md-6">
					<label>
						Block name *
					</label>
					<div class="form-group">

						<input ng-disabled="School.schoolData.district_id.length==0"  class="form-control" autocomplete="off" type="text" name="Block" placeholder="Block" ng-model="School.schoolData.block_name" ng-change="School.getBlocks(School.schoolData.district_id, School.schoolData.block_name)" >

						<div class="filter-dropdown" ng-if="School.blocks.length > 0; ">
							<ul>
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
					<div class="form-group">
						<input ng-disabled="School.schoolData.block_id.length==0"  class="form-control" autocomplete="off" type="text" name="Locality" placeholder="Locality" ng-model="School.schoolData.locality_name" ng-change="School.getLocalities(School.schoolData.block_id, School.schoolData.locality_name)">

						<div class="filter-dropdown" ng-if="School.localities.length > 0; ">
							<ul>
								<li ng-repeat="locality in School.localities">
									<a href="" ng-bind="locality.name" ng-click="School.chooseLocality(locality)">
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-xs-12">
				<div class="col-md-6">
					<label>
						Sub locality (Revenue Village / Ward Name) *
					</label>
					<div class="form-group">
						<input ng-disabled="School.schoolData.locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub locality" placeholder="Sub locality" ng-model="School.schoolData.sub_locality_name" ng-change="School.getSubLocalities(School.schoolData.locality_id, School.schoolData.sub_locality_name)" >

						<div class="filter-dropdown" ng-if="School.sub_localities.length > 0; ">
							<ul>
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
					<div class="form-group">
						<input ng-disabled="School.schoolData.sub_locality_id.length==0"  class="form-control" autocomplete="off" type="text" name="Sub-sub locality" placeholder="Sub-sub locality" ng-model="School.schoolData.sub_sub_locality_name" ng-change="School.getSubSubLocalities(School.schoolData.sub_locality_id, School.schoolData.sub_sub_locality_name)" >

						<div class="filter-dropdown" ng-if="School.sub_sub_localities.length > 0; ">
							<ul>
								<li ng-repeat="subsublocality in School.sub_sub_localities">
									<a href="" ng-bind="subsublocality.name" ng-click="School.chooseSubSubLocality(subsublocality)">
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

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
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<button type="submit" class="btn-theme pull-right">Save</button>
				</div>
			</div>
		</div>
	</form>
</div>
</div>
</section>
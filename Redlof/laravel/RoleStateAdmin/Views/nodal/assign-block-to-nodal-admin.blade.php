@extends('stateadmin::includes.layout')
@section('content')
<section class="admin_dash" ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="CommonController as Com" ng-cloak>
		<div class="page-header-custom page-title-ad">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<h2>
							Assign Blocks to Nodal Admin
						</h2>
					</div>
				</div>
			</div>
        </div>
        
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<div class="form-group" ng-init="formData={};districts={{$districts}}">
                    <label>Select District</label>
                    <ui-select class="custom_ui_select" ng-model="formData.district_id" ng-click="getAPIData('stateadmin/get/district/blocks/'+[[formData.district_id]], 'districtblocks'); Com.getNodalAdmins('stateadmin/district/nodal/admins/'+[[formData.district_id]]);" theme="selectize">
                    <ui-select-match>
                    [[$select.selected.name]]
                    </ui-select-match>
                    <ui-select-choices repeat="item.id as item in districts | filter: $select.search | orderBy: 'name' ">
                    [[item.name]]
                    </ui-select-choices>
                    </ui-select>
                </div>
			</div>
        </div>
        <br>
                
		<div>
			<div class="row">
				<div ng-if="districtblocks.length > 0" class="col-sm-8 col-xs-8">
					<table class="table table-responsive custom-table">
						<thead class="thead-cls">
							<tr>
								<th>Sl.no</th>
								<th>Name</th>
								<th>Assign Block to Nodal-Admin</th>
							</tr>
						</thead>
						<tbody ng-init="Data={}">
							<tr class="assign-blk-to-na" ng-repeat="districtblock in districtblocks" ng-cloak>
								<td>[[$index+1]]</td>
								<td>[[districtblock.name]]</td>
								<td>
									<ui-select class="custom_ui_select" ng-init="Data.nodaladmin[districtblock.id]=districtblock.assignednodaladmin.state_nodals_id" ng-model="Data.nodaladmin[districtblock.id]" ng-change="Com.selectNodalAdmins(Data)" theme="selectize">
                                        <ui-select-match>
                                            [[$select.selected.user.first_name]] [[$select.selected.user.last_name]]  ([[$select.selected.user.email]])
                                        </ui-select-match>
                                        <ui-select-choices repeat="item.id as item in Com.nodaladmins | filter: $select.search | orderBy: 'name' ">
                                           <span class="item-container-na" ng-if="item.display">[[item.user.first_name]] [[item.user.last_name]] ([[item.user.email]])</span>
                                        </ui-select-choices>
                                    </ui-select>
								</td>
							</tr>
						</tbody>
                    </table>
                    
                    <button class="btn btn-info" ng-click="create('stateadmin/block-nodaladmin/assign', Com.assignData )">Assign</button>
				</div>
				<div align="center" ng-if="districtblocks.length == 0">
				    <p>No blocks in Selected District</p>
                </div>
                <div ng-if="!formData.district_id">
                    <p style="margin-left:22px;">Please Select District</p>
                </div>
			</div>
		</div>
	</div>
</div>
</section>
@endsection
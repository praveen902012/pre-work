<section class="bg-rt dy-content-slide">
	<div class="">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="detail-card-st">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							@if(!is_null($nodal_admin->user->photo))
							<img class="img-responsive" src="{$nodal_admin->user->photo}}">
							@else
							<img class="img-responsive" src="{!! asset('img/user_photo.jpg') !!}">
							@endif
						</div>
						<div class="col-sm-5 col-xs-12 no-padding">

							<h2 class="">{{$nodal_admin->user->display_name}}</h2><br>

							<div class="form-group" ng-init="formData={};getDropdown('districtadmin/nodaladmin/un-assigned/blocks/{{$nodal_admin->id}}', 'unasignedblock')">
								<label>Assign Block to Nodal Admin</label>
								<ui-select class="custom_ui_select" ng-init="formData.block_id=@if(isset($nodal_admin->assigned_nodal->block_id)){{$nodal_admin->assigned_nodal->block_id}}@endif" ng-model="formData.block_id" ng-change="create('districtadmin/nodaladmin/block/assign/{{$nodal_admin->id}}', formData)" theme="selectize">
								<ui-select-match>
								[[$select.selected.name]]
								</ui-select-match>
								<ui-select-choices repeat="item.id as item in unasignedblock | filter: $select.search | orderBy: 'name' ">
								[[item.name]]
								</ui-select-choices>
								</ui-select>

								<div ng-if="{{isset($nodal_admin->assigned_nodal)}}" ng-init="nodal_block_id=@if(isset($nodal_admin->assigned_nodal)){{$nodal_admin->assigned_nodal->id}}@endif">
									<button ng-disabled="inProcess" ng-really-action="Remove" ng-really-message="Do you want to Remove this nodal?" ng-really-click="create('districtadmin/nodal/unassign/block/'+ [[nodal_block_id]],  nodal, 'deactivate')" class="btn btn-danger btn-xs city-action-btn">
										<span ng-if="!inProcess" class="font-size-11 pos-rel"><i class="fa fa-ban"></i> Remove Nodal</span>
										<span ng-if="inProcess" class="font-size-11 pos-rel">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-3 col-xs-12">
							@if($nodal_admin->status == 'active')
							<button ng-disabled="inProcess" ng-really-action="Deactivate" ng-really-message="Do you want to deactivate this nodal?" ng-really-click="create('districtadmin/nodal/deactivate/'+[[districtnodal.id]],  nodal, 'deactivate')" class="btn btn-danger btn-xs city-action-btn">
								<span ng-if="!inProcess" class="font-size-11 pos-rel"><i class="fa fa-ban"></i>  Deactivate</span>
								<span ng-if="inProcess" class="font-size-11 pos-rel">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
							@else
							<button ng-disabled="inProcess" ng-really-action="Activate" ng-really-message="Do you want to activate this nodal?" ng-really-click="create('districtadmin/nodal/activate/'+[[districtnodal.id]],  nodal, 'activate')" class="btn btn-success btn-xs city-action-btn">
								<span ng-if="!inProcess" class="font-size-11 pos-rel"><i class="fa fa-check"></i>  Activate</span>
								<span ng-if="inProcess" class="font-size-11 pos-rel">Please wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
							@endif


						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<div class="st-ad-dt-heading ">
					<h2>
					Basic Details:
					</h2>
				</div>
				<div class="st-admin-detail">
					<ul class="list-unstyled">
						<li><b>Email: </b>{{$nodal_admin->user->email}}</li>
						<li><b>Phone: </b>{{$nodal_admin->user->phone}}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

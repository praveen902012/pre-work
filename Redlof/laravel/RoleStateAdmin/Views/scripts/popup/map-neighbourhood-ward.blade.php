<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Map neighbourhood ward
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

    <div class="popup-content-ad">
		<div class="row">
			<div class="col-sm-9 col-xs-12"></div>
			<div class="col-sm-3 col-xs-12">
				<div class="form-group pull-right">
					<div class="static-form search-filter">
						<div class="form-group form-field">
							<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search locality here"
							ng-change="getAPIData('stateadmin/script/school/'+[[helper.school_id]]+'/subsublocality/all?keyword=[[keyword]]', 'sublocalities')">
						</div>
					</div>
				</div>
			</div>
		</div>

		<table class="table table-responsive custom-table" ng-if="sublocalities.length>0">
			<thead class="thead-cls">
				<tr>
					<th>Sl.no</th>
					<th>Locality</th>
					<th>Block</th>
					<th>Action</th>
				</tr>
			</thead>
			<tr ng-repeat="locality in sublocalities">
				<td>[[$index+1]]</td>
				<td>[[locality.name]]</td>
				<td>[[locality.block.name]]</td>
				<td>
					<button ng-really-action="Assign" ng-really-message="Do you want to assign this locality?"
					ng-really-click="create('stateadmin/script/school/'+[[helper.school_id]]+'/subsublocality/add', {locality_id:locality.id})" class="btn btn-success btn-xs city-action-btn">
						Assign
					</button>
				</td>
			</tr>
		</table>

	</div>
</section>

@include('state::includes.head')
@include('state::includes.header')
<style>
	.line {
    position: relative;
    z-index: 1;
    overflow: hidden;
    text-align: center;
	color: #a0a2a4;
}
	.line:before, .line:after {
	    position: absolute;
	    top: 51%;
	    overflow: hidden;
	    width: 50%;
	    height: 1px;
	    content: '\a0';
	    background-color: #d6d8da;
	}
	.line:before {
	    margin-left: -50%;
	    text-align: right;
	}
</style>
<section class="header-secondary">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<ul class="list-unstyled list-inline">
						<li>
							<a href="{{route('state', $state->slug)}}">
								<i class="fa fa-home home" aria-hidden="true"></i>
								Home
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="{{route('state.general.information', $state->slug)}}">
								General Information
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="{{route('state.student.general.information', $state->slug)}}">
								Student General Information
							</a>
						</li>
						<li>
							<span class="ion-ios-arrow-right">
							</span>
						</li>
						<li>
							<a href="">
								{{$title}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="page-height section-spacing cm-content bg-grey" ng-controller="StuController as Student">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-7 col-xs-12">
					<div class="heading-strip">
						<h2>
						Students Details
						<span class="info-icon">
							<i class="fa fa-info-circle" aria-hidden="true" uib-tooltip="Search Students Details" tooltip-class="ttc-verified" tooltip-placement="right"></i>
						</span>
						</h2>
					</div>
				</div>
			</div>
			<div ng-cloak>
				<div class="col-sm-12 col-xs-12">
					<div class="search-action clearfix">
						<form class="">
							<div class="form-group">
								<input ng-model="keyword" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Search by Registration ID">
							</div>
							<button class="btn-theme btn-blue" ng-click="Student.search({{$state->id}},keyword)" type="button">Search</button>
						</form>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12 line">
				Or
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="search-action clearfix">
						<form class="">
							<div class="form-group" style="margin-right:8px;">
								<input ng-model="firstname" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Student First Name">
							</div>
							<div class="form-group" style="margin-right:8px;">
								<input ng-model="parentname" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Parent Name">
							</div>
							<div class="form-group">
								<input ng-model="studob" search-icon type="text" class="form-control theme-blur-focus clearable" placeholder="Student DOB (DD-MM-YYYY)">
							</div>
							<button class="btn-theme btn-blue" ng-click="Student.searchname({{$state->id}},firstname,parentname,studob)" type="button">Search</button>
						</form>
					</div>
				</div>

				<div class="col-sm-12 col-xs-12" ng-if="Student.student.length > 0">
					<div ng-repeat="studentData in Student.student">
					<div class="rte-table bg-wht" style="overflow: auto;padding-bottom:  16px !important;">
						<h2 style="float: right;">
							Registration Status: <span ng-if="studentData.status == 'completed'" style="color: green;">Completed</span>
									<span ng-if="studentData.status == 'inactive'" style="color: red;">Rejected</span>
									<span ng-if="studentData.status == 'active'"  style="color: blue;">Incomplete</span>
						<br>
							{{-- Application Status: <span ng-if="studentData.registration_cycle_latest.doc_verification_status == null" style="color: blue;">Unverified</span>
									<span ng-if="studentData.registration_cycle_latest.doc_verification_status == 'Rejected'" style="color: red;">[[studentData.registration_cycle_latest.doc_verification_status]]</span>
									<span ng-if="studentData.registration_cycle_latest.doc_verification_status == 'Verified'" style="color: green;">[[studentData.registration_cycle_latest.doc_verification_status]]</span> --}}
									
							Application Status: <span ng-repeat="item in studentData.registration_cycle_latest" style="color: blue;">[[item.status]]</span>

						</h2>

						<h2>
							<span ng-if="studentData.first_name != 'Null'">[[studentData.first_name]]</span> <span ng-if="studentData.middle_name != 'Null'">[[studentData.middle_name]]</span> <span ng-if="studentData.last_name != 'Null'">[[studentData.last_name]]</span> 
							<br> [[studentData.registration_no]]
						</h2>

						<div class="col-xs-6">
							Parent's Name: [[studentData.parent_details.parent_name]]<br>
							Mobile Number: [[studentData.mobile]]<br>
							Date Of Birth: [[studentData.fmt_dob]]
						</div>

						<div class="col-xs-6" ng-repeat="item in studentData.registration_cycle_latest">
							<p ng-if="item.school.name"><b>Alloted School:</b> [[item.school.name]]</p>
							<p ng-if="item.doc_reject_reason"><b>Reject Reason:</b> [[item.doc_reject_reason]]</p>
						</div>

						<a ng-if="studentData.status == 'completed'" href="/api/{{$state->slug}}/download/registration-form/[[studentData.registration_no]]" class="btn btn-blue mrt-20">
							<i class="fa fa-print" aria-hidden="true"></i> &nbsp;&nbsp; Print application
						</a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
@include('state::includes.footer')
@include('state::includes.foot')
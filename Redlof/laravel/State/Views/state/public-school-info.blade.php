@include('state::includes.head')
@include('state::includes.header')
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
<section class="page-height page-content cm-content section-spacing">
	<div class="container" ng-controller="ListController as List" ng-cloak ng-init="List.init('school-count-list', {'getall': '{{$state->slug}}/get/schoolsData/all', 'search': '{{$state->slug}}/schools/all/'+[[selectedCycle]]+'/search'})">
		<div class="rte-container">
			<div class="heading-strip all-pg-heading ">
				<h1>
				District and Block Wise Schools Details
				</h1>
				
			</div>
			<div ng-repeat="District in List.ListService.results">
				<h2  class="instruction-heading">
				[[District.name]]
				</h2>
				<div class="tb-container">
					<div class="table-responsive bg-wht">
						<div class="rte-table"  style="border: 0;">
							<table class="table">
								<thead class="">
									<tr>
										<th class="">Block</th>
										<th class="">Applied Schools  ([[District.counttotal]])</th>
										<th class="">Verified Schools  ([[District.countverified]])</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="school in District.data">
										<td class="">[[school.block]]</td>
										<td class="">[[school.total_schools]]</td>
										<td class="">[[school.verified_schools]]</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				</div>
			
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
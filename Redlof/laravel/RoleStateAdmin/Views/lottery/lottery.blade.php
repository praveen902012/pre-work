@extends('stateadmin::includes.layout')
@section('content')
<section  class="stateadmin_dash"  ng-controller="AppController" ng-cloak>
	<div class="container-fluid" ng-controller="ListController as List" ng-cloak>
		<div ng-controller="LotteryController as Lottery" class="page-header-custom page-title-ad" >
			<div class="row" ng-init="List.init('lottery-list', {'getall': 'stateadmin/lottery', 'search':'stateadmin/lottery/search/all'})">
				<div class="col-sm-6 col-xs-12">
					<div class="state-brief">
						<h2>
						Lottery
						</h2>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					@if($status=='new')
						<button class="btn-theme btn-sm pull-right" ng-click="openPopup('stateadmin', 'lottery', 'add-lottery', 'create-popup-style')">
							लॉटरी साइकिल को जोडे
						</button>
					@elseif($status=='enrollment')
						<h2 class="pull-right">
						You may add new lottery cycle after enrollment date passes
						</h2>
					@endif

					@if($status=='lottery')
						<div class="all-admin-link pull-right">
							<button class="btn btn-blue-outline" ng-really-action="Trigger" ng-really-message="Do you want to trigger lottery? This may take some time, incase you wish to proceed do wait till the entire process completes. Please make sure you have a stable internet connection." ng-really-click="Lottery.triggerLottery('stateadmin/lottery/trigger')">
								Trigger Lottery Allotment
							</button>
						</div>
					@endif

					@if($notification_show)
						<div class="all-admin-link pull-right">
							<button class="btn btn-blue-outline" ng-really-action="Send" ng-really-message="Do you want to send lottery notification? This may take some time, incase you wish to proceed do wait till the entire process completes. Please make sure you have a stable internet connection." ng-really-click="Lottery.triggerNotification('stateadmin/lottery/send/notification/{{$application_id}}')">
								लॉटरी अधिसूचना भेजे
							</button>
						</div>
					@endif
				</div>
			</div>
		</div>

		<div>
			@include('page::app.tablelist-pagination')
		</div>

		<div ng-if="List.ListService.results.length > 0">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="tb-container">
						<div class="table-responsive ">
							<div class="rte-table rt-st-admin bg-wht">
								<table class="table">
									<thead class="thead-cls">
										<tr class="">
											<th class="">Sl.no</th>
											<th class="">पंजीकरण प्रारंभ तिथि</th>
											<th class="">पंजीकरण अन्तिम तिथि</th>
											<th class="">घोषणा की गयी</th>
											<th class="">नामांकन की अन्तिम तिथि</th>
											<th class="">लॉटरी साइकिल</th>
											<th class="">वर्ष</th>
											<th class="">एक्शन</th>
										</tr>
									</thead>
									<tr class="" ng-repeat="item in List.ListService.results">
										<td class="">[[$index+1]]</td>
										<td class="">[[item.reg_start_date]]</td>
										<td class="">[[item.reg_end_date]]</td>
										<td class="" >[[item.announcement_date]]</td>
										<td class="">[[item.enrollment_deadline]]</td>
										<td class="">[[item.cycle]]</td>
										<td class="">[[item.session_year]] - [[item.session_year+1]]</td>
										<td class="">
											<button  ng-click="helper.lottery_id=[[item.id]];openPopup('stateadmin', 'lottery', 'edit-lottery', 'create-popup-style')" class="btn btn-info btn-xs city-action-btn" ng-if="item.status=='new'">Edit</button>

											<button  ng-if="item.status=='completed'" ng-click="helper.lottery_id=[[item.id]];openPopup('stateadmin', 'lottery', 'lottery-details', 'create-popup-style')" class="btn btn-info btn-xs city-action-btn">पूर्व आंकड़े</button>

											<button  ng-if="item.status=='completed'" ng-click="create('stateadmin/lottery/'+[[item.id]]+'/district-wise-stats',  stateadmin, 'download')" class="btn btn-info btn-xs city-action-btn">Download</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p ng-if="List.ListService.results.length == 0">No lottery to display</p>
	</div>
</section>
@endsection

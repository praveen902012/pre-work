<section class="" ng-controller="AppController">

	<div class="header-popup-ad">
		<h2>
		    Update School Seat Info
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
    </div>

    <div ng-controller="SchoolFeeNSeatController as SchoolSeat">
        <div class="popup-content-ad" ng-init="SchoolSeat.initSeatDetails(helper.school_udise)">
            <form name="add-subject" class="common-form add-area" ng-submit="create('stateadmin/school/'+[[helper.school_udise]]+'/seat-info/update', SchoolSeat.seatinfo)">

                <table class="table table-responsive table-bordered custom-table">
                    <thead class="thead-cls">
                        <tr>
                            <th>Class </th>
                            <th class="text-center"> Total seats
                            </th>
                            <th class="text-center"> 25% RTE seats
                            </th>
                        </tr>
                    </thead>
                    <tr>
                        <tr ng-repeat="item in SchoolSeat.seatinfo">
                            <td ng-if="item.level" ng-bind="item.level"></td>
                            <td ng-if="item.level_info.level" ng-bind="item.level_info.level"></td>
                            <td><input type="number" class="form-control" validator="required"
                                    ng-required="true" min="0" ng-model="item.total_seats"
                                    ng-init="item = SchoolSeat.process25per(item)"
                                    ng-change="item = SchoolSeat.process25per(item)"></td>
                            <td ng-bind="item.available_seats"></td>
                        </tr>
                    </tr>
                </table>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-theme">Update</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>

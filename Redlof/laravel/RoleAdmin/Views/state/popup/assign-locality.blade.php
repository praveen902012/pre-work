<section class="pp-addstate" ng-controller="AppController"
    ng-init="formData={};formData.id=helper.id;getDropdown('admin/locality/dependencies/'+helper.id,'localData')">
    <div class="header-popup-ad">
        <h2>
            Re-Assign Locality
        </h2>
        <div class="popup-rt">
            <i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
        </div>
    </div>
    <div class="popup-content-ad" ng-controller="DownloadReportController as Download">
        <div class="text-center">
            <h3>You're about to re-assign <b>[[helper.name]]</b></h3>
            <br>
            <div class="form-group">
                <label>
                    Select block:
                </label>
                <ui-select class="" ng-model="formData.block_id" theme="select2"
                    ng-click="getDropdown('admin/get/blocks/'+[[helper.district_id]], 'blocks')">
                    <ui-select-match placeholder="Select block">
                        [[$select.selected.name]]
                    </ui-select-match>
                    <ui-select-choices repeat="item.id as item in blocks | filter:$select.search">
                        [[item.name]]
                    </ui-select-choices>
                </ui-select>
            </div>
            <button class="btn btn-danger" ng-disabled="Download.inProcess"
                ng-click="Download.triggerDownload('admin/reassign/locality/management',formData)">
                <span ng-if="!Download.inProcess">Re-Assign Anyway</span>
                <span ng-if="Download.inProcess">Please wait <i class="fa fa-spinner fa-spin"></i></span>
            </button>
        </div>
        <br>
        <h4><b>Following schools will be effected</b></h4>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>School Name</th>
                    <th>UDISE</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="school in localData.schools" ng-if="localData.schools">
                    <td>[[$index+1]]</td>
                    <td>[[school.name]]</td>
                    <td>[[school.udise]]</td>
                </tr>
                <p ng-if="localData.schools.length ==0"> No schools will be effected</p>
            </tbody>
        </table>
        <br>
        <h4><b>Following students will be effected</b></h4>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Student Name</th>
                    <th>Registration No.</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="student in localData.students" ng-if="localData.students">
                    <td>[[$index+1]]</td>
                    <td>[[student.first_name]] [[student.last_name]]</td>
                    <td>[[student.registration_no]]</td>
                </tr>
                <p ng-if="localData.students.length ==0"> No students will be effected</p>
            </tbody>
        </table>
    </div>
</section>
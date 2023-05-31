@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height" ng-controller="AppController">
    <div class="container" element-init>
        <div class="sp-form-container" ng-controller="Step3Controller as Step3" ng-init="Step3.formData={}">

            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
                    @include('state::registration.includes.inc-step-header')
                    <form id="step3" class="sp-form common-form" name="step3"
                        ng-submit="create('{{$state->slug}}/student-registration/step3/update',Step3.formData, 'step3' )">

                        <div class="row">
                            <div class="col-md-4" ng-init="Step3.formData.registration_no = helper.findIdFromUrl()">
                                <div class="form-group">
                                    <label>
                                        State <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (राज्य) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div class="form-group" ng-init="getAPIData('{{$state->slug}}/states', 'states')">
                                        <ui-select class="" ng-model="Step3.formData.state" theme="select2"
                                            ng-change="Step3.clearStateData()">
                                            <ui-select-match placeholder="State">
                                                [[$select.selected.name]]
                                            </ui-select-match>
                                            <ui-select-choices repeat="item in states | filter:$select.search">
                                                [[item.name]]
                                            </ui-select-choices>
                                        </ui-select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" click-off="Step3.districts.length = 0">
                                    <label>
                                        District <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (जिला) <span class="mand-field">*</span>
                                        </p>
                                    </label>

                                    <div class="form-group">
                                        <input ng-disabled="Step3.formData.state.length==0" class="form-control"
                                            autocomplete="off" type="text" name="state"
                                            placeholder="Type your district name"
                                            ng-model="Step3.formData.district_name"
                                            ng-click="Step3.initDistricts('{{$state->slug}}', Step3.formData.state)"
                                            ng-change="Step3.getDistricts('{{$state->slug}}', Step3.formData.state, Step3.formData.district_name)">

                                        <div class="filter-dropdown custom-dropdown"
                                            ng-if="Step3.districts.length > 0 ">
                                            <ul class="list-unstyled">
                                                <li ng-repeat="district in Step3.districts">
                                                    <a href="" ng-bind="district.name"
                                                        ng-click="Step3.chooseDistrict(district);Step3.checkDistrictStatus('{{$state->slug}}',district.id);">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" click-off="Step3.blocks.length = 0">
                                    <label>
                                        Block&nbsp;<span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (ब्लॉक) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div class="form-group">

                                        <input ng-disabled="Step3.formData.district_id.length==0" class="form-control"
                                            autocomplete="off" type="text" name="Block"
                                            placeholder="Type your block name" ng-model="Step3.formData.block_name"
                                            ng-click="Step3.initBlocks('{{$state->slug}}', Step3.formData.district_id)"
                                            ng-change="Step3.getBlocks('{{$state->slug}}', Step3.formData.district_id, Step3.formData.block_name)">

                                        <div class="filter-dropdown custom-dropdown" ng-if="Step3.blocks.length > 0; ">
                                            <ul class="list-unstyled">
                                                <li ng-repeat="block in Step3.blocks">
                                                    <a href="" ng-bind="block.name" ng-click="Step3.chooseBlock(block)">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group form-field">
                                    <label>
                                        Rural/Urban&nbsp;<span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            <span>
                                                (ग्रामीण/ शहरी)
                                            </span> <span class="mand-field">
                                                *
                                            </span>
                                        </p>
                                    </label>
                                    <ui-select class="" ng-model="Step3.formData.stateType"
                                        on-select="Step3.choosestatetype($item)" theme="select2">
                                        <ui-select-match placeholder="Rural/Urban">
                                            [[$select.selected.name]]
                                        </ui-select-match>
                                        <ui-select-choices repeat="item in Step3.stateTypeAll | filter:$select.search">
                                            [[item.name]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group form-field" click-off="Step3.blocks.length = 0">
                                    <label>
                                        Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat&nbsp;<span
                                            class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            <span>
                                                (नगर निगम / नगर पालिका परिषद / नगर पंचायत)
                                            </span> <span class="mand-field">
                                                *
                                            </span> </p>
                                    </label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input ng-disabled="Step3.formData.district_id.length==0" class="form-control"
                                            autocomplete="off" type="text" name="SubBlock" placeholder="SubBlock"
                                            ng-model="Step3.formData.sub_block_name"
                                            ng-click="Step3.initBlocks1('{{$state->slug}}', Step3.formData.block_id,Step3.formData.state_type,Step3.formData.district_id)">
                                    </div>
                                    <div class="filter-dropdown" ng-if="Step3.subblocks.length > 0; ">
                                        <ul class="custom-dropdown list-unstyled">
                                            <li ng-repeat="block in Step3.subblocks">
                                                <a href="" ng-bind="block.name" ng-click="Step3.chooseBlock1(block)"
                                                    ng-class="{ active: $index==0}">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" ng-init="Step3.show_selection_type=false">


                            <div class="col-md-4" ng-if="Step3.show_selection_type">
                                <div class="form-group">
                                    <label>
                                        Select Ward or Gram Panchayat <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (वार्ड या ग्राम पंचायत का चयन करें) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <br>
                                    <ui-select class="" ng-model="Step3.locality.type" theme="select2"
                                        ng-init="income = [{value: 'ward', name: 'Ward' }, {value: 'panchayat', name: 'Gram Panchayat' }];"
                                        ng-change="Step3.formData.block_type = '[[$select.selected.value]]';Step3.show_selection_type=true">
                                        <ui-select-match placeholder="">
                                            [[$select.selected.name]]
                                        </ui-select-match>
                                        <ui-select-choices
                                            repeat="item.value as item in income | filter:$select.search">
                                            [[item.name]]
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-md-4" ng-if="Step3.formData.block_type">
                                <div class="form-group" click-off="Step3.localities.length = 0">
                                    <label ng-if="Step3.formData.block_type=='ward'">
                                        Ward Name <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (वार्ड नाम / वार्ड संख्या) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <label ng-if="Step3.formData.block_type=='panchayat'">

                                        Gram Panchayat <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (हिंदी अनुवाद के अनुसार) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div class="form-group">
                                        <input ng-disabled="Step3.formData.block_id.length==0" class="form-control"
                                            autocomplete="off" type="text" name="Locality" placeholder="Ward Name"
                                            ng-model="Step3.formData.locality_name"
                                            ng-change="Step3.getLocalities('{{$state->slug}}', Step3.formData.sub_block_id, Step3.formData.locality_name)"
                                            ng-click="Step3.getAllLocalities('{{$state->slug}}', Step3.formData.sub_block_id)">

                                        <div class="filter-dropdown custom-dropdown"
                                            ng-if="Step3.localities.length > 0; ">
                                            <ul class="list-unstyled">
                                                <li ng-repeat="locality in Step3.localities">
                                                    <a href="" ng-bind="locality.name"
                                                        ng-click="Step3.chooseLocality(locality)">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- <div ng-controller="DownloadReportController as Download">
                                            <a href=""
                                                ng-click="Download.triggerDownload('{{$state->slug}}/download/wards/'+[[Step3.formData.district_id]])"
                                                ng-show="Step3.formData.district_name.length>0 && Step3.locality.type=='panchayat'"
                                                class="full-nm-msg">Find your Gram Panchayat</a>
                                            <a href=""
                                                ng-click="Download.triggerDownload('{{$state->slug}}/download/wards/'+[[Step3.formData.district_id]])"
                                                ng-show="Step3.formData.district_name.length>0 && Step3.locality.type=='ward'"
                                                class="full-nm-msg">Find your Ward Name</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Pincode <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (पिन कोड) <span class="mand-field">*</span>
                                        </p>
                                    </label>
                                    <div class="form-group">
                                        <input type="number" name="" ng-model="Step3.formData.pincode"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-init="Step3.initAddress('{{$state->slug}}')">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>
                                        Residential address <span class="mand-field">*</span>
                                        <p class="hindi-lbl">
                                            (घर का पता) <span class="mand-field"> - note: वार्ड और  घर  का पता वाले बॉक्स में अपनी लोकल Address Proof id का ही पता चुनें' *</span>
                                        </p>
                                    </label>
                                    <div class="form-group">
                                        <textarea required class="form-control"
                                            ng-model="Step3.formData.residential_address">

										</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button ng-disabled="inProcess" type="submit" class="btn-theme mrt-20">
                            <span ng-if="!inProcess">Save</span>
                            <span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')

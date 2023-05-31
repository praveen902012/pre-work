@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height" ng-controller="AppController">
    <div class="container" element-init>
        <div class="sp-form-container" ng-controller="Step1Controller as Step1">
            <div class="row" ng-init="Step1.initParentDetails('{{$state->slug}}')">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
                    @include('state::registration.includes.inc-step-header')
                    <form id="step2" name="step2" class="sp-form common-form"
                        ng-submit="Step1.saveParentDetails('{{$state->slug}}/student-registration/step2/update', 'step2')">
                        <div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="text-dred" ng-init="openPopup('state', 'registration', 'address-confirmation', 'create-popup-style sm-popup-style')">
                                            Details of Father/Mother/Guardian (It is mandatory to fill the details of
                                            atleast one)
                                            <p class="hindi-lbl">
                                                माता-पिता/अभिभावक का विवरण (तीनो में से किसी एक का विवरण भरना अनिवार्य
                                                है)
                                            </p>
                                        </label>
                                        <div class="form-group"
                                            ng-init="professions = [{value: 'government', name: 'Government Services' }, {value: 'business', name: 'Self employed / Business' }, {value: 'private', name: 'Private Job' }, {value: 'other', name: 'Other' }, {value: 'home-maker', name: 'Home maker' }]">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="parent"
                                                    ng-model="Registration.parent_type.father" value="father"
                                                    ng-change="Step1.changeInParentInfo('father', Registration.parent_type.father)">
                                                <b class="text-lightgrey">Father<span>पिता</span></b>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="parent"
                                                    ng-model="Registration.parent_type.mother" value="mother"
                                                    ng-change="Step1.changeInParentInfo('mother', Registration.parent_type.mother)">
                                                <b class="text-lightgrey">Mother<span>माता</span></b>
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="parent"
                                                    ng-model="Registration.parent_type.guardian" value="guardian"
                                                    ng-change="Step1.changeInParentInfo('guardian', Registration.parent_type.guardian)">
                                                <b class="text-lightgrey">Guardian<span>अभिभावक</span></b>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="Registration.parent_type.father==true">
                                <p class="text-lightgrey">
                                    Father details (पिता का विवरण)
                                </p>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>
                                                Father's Name <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> (पिता का नाम)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <input type="text" ng-model="Registration.father.parent_name"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                Father's Profession <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> पिता का पेशा)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <div class="form-group">
                                                <ui-select class="" ng-model="Registration.father.parent_profession"
                                                    theme="select2">
                                                    <ui-select-match placeholder="Select">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.value as item in professions | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="Registration.parent_type.mother==true">
                                <p class="text-lightgrey">
                                    Mother details (माता का विवरण)
                                </p>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>
                                                Mother's Name <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> (मां का नाम)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <input type="text" ng-model="Registration.mother.parent_name"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                Mother's Profession <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> (मां का पेशा)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <div class="form-group">
                                                <ui-select class="" ng-model="Registration.mother.parent_profession"
                                                    theme="select2">
                                                    <ui-select-match placeholder="Select">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.value as item in professions | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="Registration.parent_type.guardian==true">
                                <p class="text-lightgrey">
                                    Guardian details (अभिभावक का विवरण)
                                </p>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>
                                                Guardian's Name <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> (अभिभावक का नाम)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <input type="text" ng-model="Registration.guardian.parent_name"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                Guardian's Profession <span class="mand-field">*</span>
                                                <p class="hindi-lbl"> (अभिभावक का पेशा)
                                                    <span class="mand-field">*</span>
                                                </p>
                                            </label>
                                            <div class="form-group">
                                                <ui-select class="" ng-model="Registration.guardian.parent_profession"
                                                    theme="select2">
                                                    <ui-select-match placeholder="Select">
                                                        [[$select.selected.name]]
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="item.value as item in professions | filter:$select.search">
                                                        [[item.name]]
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-lightgrey pdv-15">Category under which Applied (आवेदित वर्ग)
                            </p>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>
                                            Category <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (वर्ग)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" value="ews" name="category"
                                                ng-model="Registration.category"
                                                ng-click="Registration.certificate_details={}">
                                            EWS (Economically Weaker Section)
                                            <p class="hindi-lbl">
                                                (गरीबी रेखा से नीचे/आर्थिक रूप से कमजोर वर्ग)
                                            </p>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" value="dg" name="category"
                                                ng-model="Registration.category"
                                                ng-click="Registration.certificate_details={}">
                                            DG (Disadvantaged Group)
                                            <p class="hindi-lbl">
                                                (उपवंचित वर्ग में select कर के अन्य श्रेणी चुन सकते हैं )
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5" ng-if="Registration.category=='ews'">
                                    <div class="form-group">
                                        <label>
                                            Type of certificate category <span class="mand-field">*</span>
                                            <p class="hindi-lbl">
                                                (श्रेणी प्रमाणपत्र का प्रकार) <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <ui-select class="" ng-model="Registration.certificate_details.ews_type"
                                            theme="select2"
                                            ng-init="income = [{value: 'income_certificate', name: 'Income Certificate (आय प्रमाण पत्र)' }, {value: 'bpl_card', name: 'BPL Certificate (बी.पी.एल प्रमाण पत्र)' }]">
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
                            </div>

                            <div class="row"
                                ng-if="Registration.certificate_details.ews_type=='income_certificate' && Registration.category=='ews'">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Family annual income (in INR) <span class="mand-field">*</span>
                                            <p class="hindi-lbl">
                                                (पारिवारिक वार्षिक आय (रुपये में)) <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control"
                                                ng-model="Registration.certificate_details.ews_income" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Name of Tahsil issuing income certificate
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (आय प्रमाण पत्र जारी करने वाली तहसील का नाम)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control"
                                                ng-model="Registration.certificate_details.ews_tahsil_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                </div>
                            </div>

                            <div class="row"
                                ng-if="Registration.certificate_details.ews_type=='income_certificate' && Registration.category=='ews'">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Issued Certificate No. <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (आय प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <input type="text"
                                                ng-model="Registration.certificate_details.ews_cerificate_no"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Certificate Issued Date <span class="mand-field">*</span>
                                            <p class="hindi-lbl">(आय प्रमाण पत्र जारी करने की तिथि)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4 col-xs-12" ng-init="Step1.getDates()">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.bpl_cerificate_date"
                                                        theme="select2">
                                                        <ui-select-match placeholder="Date">
                                                            [[$select.selected.date]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.id as item in Step1.dates | filter:$select.search">
                                                            [[item.date]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                                <div class="col-sm-4 col-xs-12">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.bpl_cerificate_month"
                                                        theme="select2" ng-init="Step1.getMonths()">
                                                        <ui-select-match placeholder="Month">
                                                            [[$select.selected.month]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.id as item in Step1.months | filter:$select.search">
                                                            [[item.month]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                                <div class="col-sm-4 col-xs-12" ng-init="Step1.getYears1()">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.bpl_cerificate_year"
                                                        theme="select2">
                                                        <ui-select-match placeholder="Year">
                                                            [[$select.selected.year]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.year as item in Step1.years | filter:$select.search">
                                                            [[item.year]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"
                                ng-if="Registration.certificate_details.ews_type=='bpl_card' && Registration.category=='ews'">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Name of Tahsil issuing BPL Card
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (आय प्रमाण पत्र जारी करने वाली तहसील का नाम)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control"
                                                ng-model="Registration.certificate_details.ews_tahsil_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Issued BPL Card Number. <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (बीपीएल कार्ड की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <input type="text"
                                                ng-model="Registration.certificate_details.ews_cerificate_no"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- start dg-->

                            <div class="row">
                                <div class="col-md-4" ng-if="Registration.category=='dg'">
                                    <div class="form-group">
                                        <label>
                                            Type of DG <span class="mand-field">*</span>
                                            <p class="hindi-lbl">
                                                (डीजी का प्रकार) <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <ui-select class=""
                                                ng-change="temp=Registration.certificate_details.dg_type;Registration.certificate_details={};Registration.certificate_details.dg_type=temp;"
                                                ng-model="Registration.certificate_details.dg_type" theme="select2"
                                                ng-init="income = [
												{value: 'sc', name: 'SC अनुसूचित जाति ' },
												{value: 'st', name: 'ST अनुसूचित जनजाति' },
												{value: 'obc', name: ' OBC NCL (Income less than 4.5L) अन्य पिछड़ा वर्ग' },
												{value: 'orphan', name: 'Orphan अनाथ'},
												{value: 'with_hiv', name: 'Child or Parent is HIV +ve बच्चा या माता-पिता HIV + ve है'},
												{value: 'divorced_women', name: 'Divorced women with income less than INR 80,000 ( INR 80,000 से कम आय वाली विधवा या तलाकशुदा महिलाएं)'},
												{value: 'widow_women', name: 'Widow women with income less than INR 80,000 ( INR 80,000 से कम आय वाली विधवा या तलाकशुदा महिलाएं)'},
												{value: 'disable', name: 'Disabled Child (विकलांग बच्चा)'},
												{value: 'disable_parents', name: 'Child belonging to disabled parents (Income less than 4.5L) ( INR 4.5L से कम आय वाली विकलांग माता-पिता से संबंधित बच्चा)'}
												]" ng-change="Registration.certificate_details.dg_proof = Step1.assignDGProof(Registration.certificate_details.dg_type)">

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
                                </div>
                            </div>


                            <div class="row" ng-if="Registration.category=='dg'">
                                <div class="col-md-4"
                                    ng-if="Registration.certificate_details.dg_type=='sc'||Registration.certificate_details.dg_type=='st'||Registration.certificate_details.dg_type=='obc'">
                                    <div class="form-group">
                                        <label>
                                            Name of Tahsil issuing Caste Certificate
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (जाति प्रमाण पत्र जारी करने वाली तहसील का नाम)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <div class="form-group">
                                            <input type="text" name="" class="form-control"
                                                ng-model="Registration.certificate_details.dg_tahsil_name" required>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group"
                                        ng-if="Registration.certificate_details.dg_type=='sc'||Registration.certificate_details.dg_type=='st'||Registration.certificate_details.dg_type=='obc'">
                                        <label>
                                            Issued Caste Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (जाति प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>
                                    <div class="form-group"
                                        ng-if="Registration.certificate_details.dg_type=='with_hiv'">
                                        <label>
                                            Issued Health Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (HIV + ve प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>

                                    <div class="form-group" ng-if="Registration.certificate_details.dg_type=='orphan'">
                                        <label>
                                            Issued Orphan Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (अनाथ प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>

                                    <div class="form-group"
                                        ng-if="Registration.certificate_details.dg_type=='divorced_women'">
                                        <label>
                                            Issued Divorced Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> ( तलाक प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>

                                    <div class="form-group"
                                        ng-if="Registration.certificate_details.dg_type=='widow_women'">
                                        <label>
                                            Issued Death Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> ( विधवा प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>
                                    <div class="form-group" ng-if="Registration.certificate_details.dg_type=='disable'">
                                        <label>
                                            Issued Disability Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (दिव्यांग प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>
                                    <div class="form-group"
                                        ng-if="Registration.certificate_details.dg_type=='disable_parents'">
                                        <label>
                                            Issued Health Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (विकलांग पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <input type="text" ng-model="Registration.certificate_details.dg_cerificate"
                                            class="form-control" required>

                                    </div>

                                </div>
                            </div>

                            <div class="row"
                                ng-if="Registration.category=='dg' && Registration.certificate_details.dg_type=='obc'">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>
                                            Name of Tahsil issuing Income Certificate
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (आय प्रमाण पत्र जारी करने वाली तहसील का नाम)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>

                                        <div class="form-group">
                                            <input type="text" name="" class="form-control"
                                                ng-model="Registration.certificate_details.dg_income_tahsil_name">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>
                                            Issued Income Certificate No.
                                            <span class="mand-field">*</span>
                                            <p class="hindi-lbl"> (आय प्रमाण पत्र की आवेदन संख्या)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <input type="text"
                                            ng-model="Registration.certificate_details.dg_income_cerificate"
                                            class="form-control" required>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Certificate Issued Date <span class="mand-field">*</span>
                                            <p class="hindi-lbl">(आय प्रमाण पत्र जारी करने की तिथि)
                                                <span class="mand-field">*</span>
                                            </p>
                                        </label>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4 col-xs-12" ng-init="Step1.getDates()">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.dg_cerificate_date"
                                                        theme="select2">
                                                        <ui-select-match placeholder="Date">
                                                            [[$select.selected.date]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.id as item in Step1.dates | filter:$select.search">
                                                            [[item.date]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                                <div class="col-sm-4 col-xs-12">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.dg_cerificate_month"
                                                        theme="select2" ng-init="Step1.getMonths()">
                                                        <ui-select-match placeholder="Month">
                                                            [[$select.selected.month]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.id as item in Step1.months | filter:$select.search">
                                                            [[item.month]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                                <div class="col-sm-4 col-xs-12" ng-init="Step1.getYears1()">
                                                    <ui-select class=""
                                                        ng-model="Registration.certificate_details.dg_cerificate_year"
                                                        theme="select2">
                                                        <ui-select-match placeholder="Year">
                                                            [[$select.selected.year]]
                                                        </ui-select-match>
                                                        <ui-select-choices
                                                            repeat="item.year as item in Step1.years | filter:$select.search">
                                                            [[item.year]]
                                                        </ui-select-choices>
                                                    </ui-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-md-4"><span class="fa fa-download">
									</span>
									<div class="form-group">
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='sc'||Registration.certificate_details.dg_type=='st'||Registration.certificate_details.dg_type=='obc'">Download sample caste certificate<p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='with_hiv'">Download sample Mediacl certificate<p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='orphan'">Download sample medical certificate<p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='kodh'">Download sample Kodh certificate<p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='disable'">Download sample medical certificate<p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>
										<a target="_blank" href="{{asset('img/cast.jpeg')}}" ng-if="Registration.certificate_details.dg_type=='single_women'">Download sample Widow or Divorced <p class="hindi-lbl">
												नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें
											</p></a>

									</div>
								</div> -->
                            </div>


                            <div class="row"></div>




                            <!-- start bpl-->
                            <!--
							<div class="row" ng-if="Registration.category=='bpl'">

								<div class="col-md-4">
									<div class="form-group">
										<label>
											Name of Tahsil issuing income certificate
											<span class="mand-field">*</span>
											<p class="hindi-lbl"> (आय प्रमाण पत्र जारी करने वाली तहसील का नाम)
												<span class="mand-field">*</span>
											</p>
										</label>
										<div class="form-group">
											<input type="text" name="" class="form-control" ng-model="Registration.certificate_details.bpl_tahsil_name">
										</div>
										<div class="form-group" ng-init="income = [{
																		value: 'caste_certificate',
																		name: 'Caste certificate issued by Tehsildar/Competent authority'}, {value: 'medical_certificate',name: 'Medical certificate issued by government hospital in respect of child with special needs/Disabled'},{value: 'relevant_certificate',name: 'Any relevant document'}]">
											<ui-select class="" ng-model="Registration.certificate_details.dg_proof" theme="select2" ng-disbled="true">
												<ui-select-match placeholder="">
													[[$select.selected.name]]
												</ui-select-match>
												<ui-select-choices repeat="item.value as item in income | filter:$select.search">
													[[item.name]]
												</ui-select-choices>
											</ui-select>
										</div>
									</div>
								</div>

							</div> -->

                            <button ng-disabled="Step1.inProcess" type="submit" class="btn-theme mrt-20">
                                <span ng-if="!Step1.inProcess">Save</span>
                                <span ng-if="Step1.inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')

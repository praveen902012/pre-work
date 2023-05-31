<section ng-controller="AppController">
	<div class="header-popup-ad">
		<h2>
			Change Student Category
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
	</div>

	<div ng-controller="Step1Controller as Step1">
		<div class="popup-content-ad" ng-init="Step1.initParentDetails(helper.studentData.registration_no)" ng-controller="ResumeRegistrationController as Registration">
			<form name="stateadmin-student-status-change" class="common-form add-area" ng-submit="Step1.saveParentDetails('stateadmin/script/student/category/update', 'step2')">
				<div id="primary">
					<div class="row form-group">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>
										Category <span class="mand-field">*</span>
										<p class="hindi-lbl"> (वर्ग)
											<span class="mand-field">*</span>
										</p>
									</label>
									<label class="radio-inline">
										<input type="radio" value="ews" name="category"
											ng-model="Step1.formData.category"
											ng-click="Step1.formData.certificate_details={}">
										EWS (Economically Weaker Section)
										<p class="hindi-lbl">
											(गरीबी रेखा से नीचे/आर्थिक रूप से कमजोर वर्ग)
										</p>
									</label>
									<label class="radio-inline">
										<input type="radio" value="dg" name="category"
											ng-model="Step1.formData.category"
											ng-click="Step1.formData.certificate_details={}">
										DG (Disadvantaged Group)
										<p class="hindi-lbl">
											(उपवंचित वर्ग)
										</p>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" ng-if="Step1.formData.category=='ews'">
								<div class="form-group">
									<label>
										Type of certificate category <span class="mand-field">*</span>
										<p class="hindi-lbl">
											(श्रेणी प्रमाणपत्र का प्रकार) <span class="mand-field">*</span>
										</p>
									</label>
									<ui-select class="" ng-model="Step1.formData.certificate_details.ews_type"
										theme="select2"
										ng-init="income = [{value: 'income_certificate', name: 'Income Certificate (आय प्रमाण पत्र)' }, {value: 'bpl_card', name: 'BPL Card (बी.पी.एल कार्ड)' }]">
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
							ng-if="Step1.formData.certificate_details.ews_type=='income_certificate' && Step1.formData.category=='ews'">
							<div class="col-md-6">
								<div class="form-group">
									<label>
										Family annual income (in INR) <span class="mand-field">*</span>
										<p class="hindi-lbl">
											(पारिवारिक वार्षिक आय (रुपये में)) <span class="mand-field">*</span>
										</p>
									</label>
									<div class="form-group">
										<input type="text" name="" class="form-control"
											ng-model="Step1.formData.certificate_details.ews_income" required>
									</div>
								</div>
							</div>

							<div class="col-md-6">
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
											ng-model="Step1.formData.certificate_details.ews_tahsil_name" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row"
							ng-if="Step1.formData.certificate_details.ews_type=='income_certificate' && Step1.formData.category=='ews'">

							<div class="col-md-6">
								<div class="form-group">
									<label>
										Issued Certificate No. <span class="mand-field">*</span>
										<p class="hindi-lbl"> (आय प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<div class="form-group">
										<input type="text"
											ng-model="Step1.formData.certificate_details.ews_cerificate_no"
											class="form-control" required>
									</div>
								</div>
							</div>

							<div class="col-md-6">
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
													ng-model="Step1.formData.certificate_details.bpl_cerificate_date"
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
													ng-model="Step1.formData.certificate_details.bpl_cerificate_month"
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
													ng-model="Step1.formData.certificate_details.bpl_cerificate_year"
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
							ng-if="Step1.formData.certificate_details.ews_type=='bpl_card' && Step1.formData.category=='ews'">
							<div class="col-md-6">
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
											ng-model="Step1.formData.certificate_details.ews_tahsil_name" required>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>
										Issued BPL Card Number. <span class="mand-field">*</span>
										<p class="hindi-lbl"> (बीपीएल कार्ड की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<div class="form-group">
										<input type="text"
											ng-model="Step1.formData.certificate_details.ews_cerificate_no"
											class="form-control" required>
									</div>
								</div>
							</div>
						</div>

						<!-- start dg-->

						<div class="row">
							<div class="col-md-12" ng-if="Step1.formData.category=='dg'">
								<div class="form-group">
									<label>
										Type of DG <span class="mand-field">*</span>
										<p class="hindi-lbl">
											(डीजी का प्रकार) <span class="mand-field">*</span>
										</p>
									</label>
									<div class="form-group">
										<ui-select class=""
											ng-change="temp=Step1.formData.certificate_details.dg_type;Step1.formData.certificate_details={};Step1.formData.certificate_details.dg_type=temp;"
											ng-model="Step1.formData.certificate_details.dg_type" theme="select2"
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
											]" ng-change="Step1.formData.certificate_details.dg_proof = Step1.assignDGProof(Step1.formData.certificate_details.dg_type)">

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


						<div class="row" ng-if="Step1.formData.category=='dg'">
							<div class="col-md-6"
								ng-if="Step1.formData.certificate_details.dg_type=='sc'||Step1.formData.certificate_details.dg_type=='st'||Step1.formData.certificate_details.dg_type=='obc'">
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
											ng-model="Step1.formData.certificate_details.dg_tahsil_name" required>
									</div>

								</div>
							</div>

							<div class="col-sm-6">

								<div class="form-group"
									ng-if="Step1.formData.certificate_details.dg_type=='sc'||Step1.formData.certificate_details.dg_type=='st'||Step1.formData.certificate_details.dg_type=='obc'">
									<label>
										Issued Caste Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (जाति प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>

									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>
								<div class="form-group"
									ng-if="Step1.formData.certificate_details.dg_type=='with_hiv'">
									<label>
										Issued Health Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (HIV + ve प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>

									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>

								<div class="form-group" ng-if="Step1.formData.certificate_details.dg_type=='orphan'">
									<label>
										Issued Orphan Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (अनाथ प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>

									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>

								<div class="form-group"
									ng-if="Step1.formData.certificate_details.dg_type=='divorced_women'">
									<label>
										Issued Divorced Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> ( तलाक प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>

									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>

								<div class="form-group"
									ng-if="Step1.formData.certificate_details.dg_type=='widow_women'">
									<label>
										Issued Death Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> ( विधवा प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>
								<div class="form-group" ng-if="Step1.formData.certificate_details.dg_type=='disable'">
									<label>
										Issued Disability Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (दिव्यांग प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>
								<div class="form-group"
									ng-if="Step1.formData.certificate_details.dg_type=='disable_parents'">
									<label>
										Issued Health Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (विकलांग पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<input type="text" ng-model="Step1.formData.certificate_details.dg_cerificate"
										class="form-control" required>

								</div>

							</div>
						</div>

						<div class="row" ng-if="Step1.formData.category=='dg' && Step1.formData.certificate_details.dg_type=='obc'">

							<div class="col-sm-6">
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
											ng-model="Step1.formData.certificate_details.dg_income_tahsil_name">
									</div>

								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>
										Issued Income Certificate No.
										<span class="mand-field">*</span>
										<p class="hindi-lbl"> (आय प्रमाण पत्र की आवेदन संख्या)
											<span class="mand-field">*</span>
										</p>
									</label>
									<input type="text"
										ng-model="Step1.formData.certificate_details.dg_income_cerificate"
										class="form-control" required>

								</div>
							</div>
						</div>

						<div class="row" ng-if="Step1.formData.category=='dg' && Step1.formData.certificate_details.dg_type=='obc'">
							<div class="col-md-12">
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
													ng-model="Step1.formData.certificate_details.dg_cerificate_date"
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
													ng-model="Step1.formData.certificate_details.dg_cerificate_month"
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
													ng-model="Step1.formData.certificate_details.dg_cerificate_year"
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

					</div>
				</div>

				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<button ng-disabled="inProcess" type="submit" class="btn-theme pull-right">
							<span ng-if="!inProcess">Save</span>
							<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

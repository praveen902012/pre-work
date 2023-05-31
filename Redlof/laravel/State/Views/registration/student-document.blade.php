@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height" ng-controller="AppController">
	<div class="container" ng-controller="Step4Controller as Step4" element-init>
		<div class="sp-form-container" ng-init="Step4.Registration.registration_no = helper.findIdFromUrl()">
			<div class="row" ng-init="Step4.initChecked({{$registration->state[4]}})">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
					@include('state::registration.includes.inc-step-header')
					<form id="step4" class="sp-form common-form" name="step4" ng-submit="create('{{$state->slug}}/student-registration/step4/update', Step4.Registration, 'step2')">
						<div ng-init="Step4.initFileDetails('{{$state->slug}}')">
							<p class="text-dred">Documents to be shown while reporting to the school<p>स्कूल को रिपोर्ट करते समय दिखाए जाने वाले दस्तावेज़</p></p>
							<!-- <div class="icon-notation">
								<span class="fa fa-download">
								</span>
								<span>
									Click icon to download sample<p>नमूना डाउनलोड करने के लिए आइकन पर क्लिक करें</p>
								</span>
							</div> -->
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<div class="hm-card doc-list-card ">
										<div class="heading-header landing-header-card bg-hm-theme">
											<h4>
												Proof of birth<p class="hindi-lbl">
											(जन्म तिथि का प्रमाण)
										</p>
											</h4>
										</div>
										<div class="card-content">
											<div class="row">
												<div class="col-sm-12 col-xs-12" >
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" ng-model="Step4.Registration.documents.proof_of_birth.birth_certificate">
																Birth certificate (जन्म प्रमाण पत्र)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" ng-model="Step4.Registration.documents.proof_of_birth.self_declaration">
																Self Declaration Form (स्व घोषणा प्रपत्र)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'"  ng-model="Step4.Registration.documents.proof_of_birth.aadhaar_card">
																Aadhaar card (आधार कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
											</div>
										</div>
										<!-- <div class="row">
											<div class="col-sm-12 col-xs-12">
												<div class="checkbox-sample">
													<label class="checkbox-inline">
														<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Registration.birth_accept" required>
														I acknolwedge that I have one of the above documents.
														<p class="hindi-lbl">
										(मैं मानता हूं कि मेरे पास उपरोक्त दस्तावेजों में से एक है)
										</p>
													</label>
												</div>
											</div>
										</div> -->
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="hm-card doc-list-card ">
										<div class="heading-header landing-header-card bg-hm-theme ">
											<h4>
												Parent ID
												<p class="hindi-lbl">
											(अभिभावक पहचान प्रमाण)
										</p>
											</h4>
										</div>
										<div class="card-content">
											<div class="row">
												<div class="col-sm-12 col-xs-12">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_parent.voter_card">
																Voter card (वोटर कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_parent.aadhaar_card">
																Aadhaar card (आधार कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_parent.driving_license">
																Driving license (ड्राइविंग लाइसेंस)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept"  ng-model="Step4.Registration.documents.proof_of_parent.pan_card">
																PAN card (पैन कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
											</div>
											<!-- <div class="row">
												<div class="col-sm-12 col-xs-12">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.parent_accept" required>
															I acknolwedge that I have one of the above documents.
															<p class="hindi-lbl">
																(मैं मानता हूं कि मेरे पास उपरोक्त दस्तावेजों में से एक है)
															</p>
														</label>
													</div>
												</div>
											</div> -->
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<div class="hm-card doc-list-card">
										<div class="heading-header landing-header-card bg-hm-theme ">
											<h4>
												Address proof
												<p class="hindi-lbl">
											( पते का प्रमाण)
										</p>
											</h4>
										</div>
										<div class="card-content">
											<div class="row">
												<div class="col-sm-12 col-xs-12">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.ration_card">
																Ration card (राशन कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.voter_card">
																Voter card (वोटर कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.aadhaar_card">
																Aadhaar card (आधार कार्ड)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.driving_license">
																Driving license (ड्राइविंग लाइसेंस)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.electricity_bill">
																Electricity bill (बिजली का बिल)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.residential_certificate">
																Residential Certificate (स्थायी निवास पात्र)
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
												<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
													<div class="checkbox-sample">
														<label class="checkbox-inline">
															<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.proof_of_address.bank_passbook">
																Bank Passbook बैंक पासबुक
														</label>

														<a href="" class="checkbox-inline">
															<i class="fa fa-download"></i> Download
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="hm-card doc-list-card">
										@if($candidate->category == 'ews')

											@if($candidate->certificate_details['ews_type'] == 'bpl_card')
											<div class="heading-header landing-header-card bg-hm-theme">
												<h4>
													BPL Certificate
													<p class="hindi-lbl">
													(आर्थिक रूप से कमजोर वर्ग प्रमाण पत्र)
													</p>
												</h4>
											</div>
											@elseif($candidate->certificate_details['ews_type'] == 'income_certificate')
											<div class="heading-header landing-header-card bg-hm-theme">
												<h4>
													Income Certificate
													<p class="hindi-lbl">
													(आर्थिक रूप से कमजोर वर्ग प्रमाण पत्र)
													</p>
												</h4>
											</div>
											@endif
										@elseif($candidate->category == 'dg')
											<div class="heading-header landing-header-card bg-hm-theme">
												<h4>
													DG certificate
													<p class="hindi-lbl">
											(डीजी वर्ग प्रमाण पत्र)
										</p>
												</h4>
											</div>
										@endif
										<div class="card-content">
											@if($candidate->category == 'ews')
											<div class="row">

												@if(isset($candidate->certificate_details['ews_type']) && $candidate->certificate_details['ews_type'] == 'bpl_card')
													<div class="col-sm-12 col-xs-12">
														<div class="checkbox-sample">
															<label class="checkbox-inline">
																<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.ews_documents.ration_card" required>
																	Ration card (राशन कार्ड)
															</label>

															<a href="{{asset('img/income.jpeg')}}" class="checkbox-inline">
																<i class="fa fa-download"></i> Download
															</a>
														</div>
													</div>
												@else
													<div class="col-sm-12 col-xs-12">
														<div class="checkbox-sample">
															<label class="checkbox-inline">
																<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.ews_documents.income_certificate" required>
																	Income certificate (आय प्रमाण पत्र)
															</label>

															<a href="{{asset('img/income.jpeg')}}" class="checkbox-inline">
																<i class="fa fa-download"></i> Download
															</a>
														</div>
													</div>

												@endif
											</div>
											@elseif($candidate->category == 'dg')
												@if(isset($candidate->certificate_details['dg_type']))
													<div class="row">
														@if($candidate->certificate_details['dg_type']=='sc'||$candidate->certificate_details['dg_type']=='st')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.cast_certificate" required>
																			Caste certificate (जाति प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='obc')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.income_certificate" required>
																			Income certificate (आय प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/income.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>

															<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.cast_certificate" required>
																			Caste certificate (जाति प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='orphan')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.orphan_certificate" required>
																			Orphan certificate (अनाथ प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='disable')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.disability_certificate" required>
																			Disability certificate (दिव्यांग प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='disable_parents')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.health_certificate" required>
																			Health Certificate (स्वास्थ्य प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='widow_women')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.father_death_certificate" required>
																			Death certificate of father (मृत्यु प्रमाणपत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='divorced_women')
															<div class="col-sm-12 col-xs-12" style="margin-top: 10px;">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.divorce_certificate" required>
																			Divorce Certificate (तलाक प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
														@if($candidate->certificate_details['dg_type']=='with_hiv')
															<div class="col-sm-12 col-xs-12">
																<div class="checkbox-sample">
																	<label class="checkbox-inline">
																		<input type="checkbox" ng-true-value="'true'" ng-false-value="'false'" name="accept" ng-model="Step4.Registration.documents.dg_documents.health_certificate" required>
																			Health Certificate (स्वास्थ्य प्रमाण पत्र)
																	</label>

																	<a href="{{asset('img/cast.jpeg')}}" class="checkbox-inline">
																		<i class="fa fa-download"></i> Download
																	</a>
																</div>
															</div>
														@endif
													</div>
												@endif
											@endif
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="hm-card doc-list-card">
										<div class="heading-header landing-header-card bg-hm-theme ">
											<h5>Required document list is subject to change and please consult your BRC/CRC/Deputy EO on list of documents accepted<p class="hindi-lbl">
												(आवश्यक दस्तावेज सूची में परिवर्तन के अधीन है और स्वीकार किए गए दस्तावेजों की सूची पर अपने बीआरसी / सीआरसी / डिप्टी ईओ से परामर्श करें)
											</p></h5>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<button ng-disabled="inProcess" type="submit" class="btn-theme">
										<span ng-if="!inProcess">Save</span>
										<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
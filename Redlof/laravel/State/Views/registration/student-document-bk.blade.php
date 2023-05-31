@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height" ng-controller="AppController">
	<div class="container" ng-controller="Step4Controller as Step4" ng-init="Registration = {}" element-init>
		<div class="sp-form-container" ng-init="Registration.registration_no = helper.findIdFromUrl()">
			<div class="row">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
					@include('state::registration.includes.inc-step-header')
					<form id="step4" class="sp-form common-form" name="step4" ng-submit="create('{{$state->slug}}/student-registration/step4/update', Registration, 'step2')">
						<div ng-init="Step4.initFileDetails('{{$state->slug}}')">
							<p class="text-dred">Documents to be shown while reporting to the school</p>
							
							<div class="row">
								<div class="col-sm-4 col-xs-12">
									<div class="form-group document_list">
										<label>
											Proof of birth
										</label>
										<ul class="list-unstyled">
											<li>
												Birth certificate <span class="pull-right"><a href="">
													Download sample
												</a></span>
											</li>
											<li>
												Aadhaar card <span class="pull-right"><a href="">
													Download sample
												</a></span>
											</li>
										</ul>
										<label class="checkbox-inline">
											<input type="checkbox" name="accept" ng-model="Registration.birth_accept" required>
											I acknolwedge that I have one of the above documents.
										</label>
									</div>
								</div>
								<div class="col-sm-4 col-xs-12">
									<div class="form-group document_list">
										<label>
											Parent ID
										</label>
										<div class="onlylist">
											<ul class="list-unstyled">
												<li>
													Voter card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Driving license <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Aadhaar card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													PAN card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
											</ul>
										</div>
										<label class="checkbox-inline">
											<input type="checkbox" name="accept" ng-model="Registration.parent_accept" required>
											I acknolwedge that I have one of the above documents.
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4 col-xs-12">
									<div class="form-group document_list">
										<label>
											Address proof
										</label>
										<div class="onlylist">
											<ul class="list-unstyled">
												<li>
													Ration card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Voter card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Aadhaar card <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Driving license <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
												<li>
													Electricity bill <span class="pull-right">
														<a href="">
															Download sample
														</a>
													</span>
												</li>
											</ul>
										</div>
										<label class="checkbox-inline">
											<input type="checkbox" name="accept" ng-model="Registration.address_accept" required>
											I acknolwedge that I have one of the above documents.
										</label>
									</div>
								</div>
								<div class="col-sm-4 col-xs-12">
									<div class="form-group document_list">
										@if($candidate->category == 'bpl')
										<label>
											EWS certificate
										</label>
										@elseif($candidate->category == 'dg')
										<label>
											DG certificate
										</label>
										@endif
										@if($candidate->category == 'bpl')
										<p>
											Income certificate
											<span class="pull-right">
												<a href="{{$income_certificate}}">Download sample</a>
											</span>
										</p>
										@elseif($candidate->category == 'dg')
										@if(isset($candidate->certificate_details['dg_type']))

										<div class="row">
											<div class="col-sm-7 col-xs-12">
												<p>
													@if($candidate->certificate_details['dg_proof']=='caste_certificate')
													Caste certificate
													@elseif($candidate->certificate_details['dg_proof']=='medical_certificate')
													Medical certificate
													@elseif($candidate->certificate_details['dg_proof']=='relevant_certificate')
													Sample certificate
													@elseif($candidate->certificate_details['dg_proof']=='transgender_certificate')
													Documentary Evidence for transgender
													@endif
												</p>
											</div>
											<div class="col-sm-5 col-xs-12">
												<span class="pull-right">
													@if($candidate->category == 'dg')
													@if(isset($candidate->certificate_details['dg_type']))
													@if($candidate->
													certificate_details['dg_proof']=='caste_certificate')
													<a href="{{$caste_certificate}}">Download sample</a>
													@elseif($candidate->certificate_details['dg_proof']=='medical_certificate')
													<a href="{{$medical_certificate}}">Download sample </a>
													@elseif($candidate->certificate_details['dg_proof']=='transgender_certificate')
													<a href="{{$income_certificate}}">Download sample</a>
													@elseif($candidate->certificate_details['dg_proof']=='relevant_certificate')
													<a href="{{$income_certificate}}">Download sample</a>
													@endif
													@endif
													@endif
												</span>
											</div>
										</div>
										@endif
										@endif
										<label class="checkbox-inline">
											<input type="checkbox" name="accept" ng-model="Registration.category_accept" required>
											I acknolwedge that I have one of the above documents.
										</label>
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
						</form>
					</div>
				</div>
			</section>
			@include('state::includes.footer')
			@include('state::includes.foot')
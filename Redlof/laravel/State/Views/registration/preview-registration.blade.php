@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-sp-success" ng-controller="AppController">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					@include('state::registration.includes.inc-step-header')
				</div>
			</div>
			<br>
			<div ng-controller="Step1Controller as Step1">
				<div class="row" ng-init="Step1.initPersonalDetails('{{$state->slug}}')" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Primary Details</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tr>
										<td><b>First Name</b></td>
										<td>[[ Step1.formData.first_name ]]</td>
									</tr>
									<tr>
										<td><b>Middle Name</b></td>
										<td>[[ Step1.formData.middle_name ]]</td>
									</tr>
									<tr>
										<td><b>Last Name</b></td>
										<td>[[ Step1.formData.last_name ]]</td>
									</tr>
									<tr>
										<td><b>Student Photo</b></td>
										<td><img src="[[ Step1.formData.fmt_photo ]]" height="80px" width="80px"></td>
									</tr>
									<tr>
										<td><b>Gender</b></td>
										<td>[[ Step1.formData.gender | capitalize]]</td>
									</tr>
									<tr>
										<td><b>Date Of Birth</b></td>
										<td>[[ Step1.formData.fmt_dob ]]</td>
									</tr>
									<tr>
										<td><b>Selected Class</b></td>
										<td>[[ Step1.formData.level_selected[0].level]]</td>
									</tr>
									<tr>
										<td><b>Mobile No.</b></td>
										<td>[[ Step1.formData.mobile ]]</td>
									</tr>
									<tr>
										<td><b>Email ID</b></td>
										<td ng-if="Step1.formData.email != null">[[ Step1.formData.email ]]</td>
										<td ng-if="Step1.formData.email == null">No email provided</td>
									</tr>
									<tr>
										<td><b>Aadhaar no. of the Child</b></td>
										<td ng-if="Step1.formData.aadhar_no != null">[[ Step1.formData.aadhar_no ]]</td>
										<td ng-if="Step1.formData.aadhar_no == null">Aadhaar No. is not provided</td>
									</tr>
									<tr>
										<td><b>Aadhaar Enrollment no. of the Child</b></td>
										<td ng-if="Step1.formData.aadhar_enrollment_no != null">[[ Step1.formData.aadhar_enrollment_no ]]</td>
										<td ng-if="Step1.formData.aadhar_enrollment_no == null">Aadhaar Enrollment No. is not provided</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div><br>
				<div class="row" ng-init="Step1.initParentDetails('{{$state->slug}}','{{$registration->age_relaxation}}')" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Parent Details</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tr ng-if="Registration.parent_type.father">
										<td><b>Father's Name</b></td>
										<td>[[ Registration.father.parent_name ]]</td>
									</tr>
									<tr ng-if="Registration.parent_type.father">
										<td><b>Father's Profession</b></td>
										<td>
											<span ng-if="Registration.father.parent_profession== 'government'">
												Government Services
											</span>
											<span ng-if="Registration.father.parent_profession== 'business'">
												Self employed / Business
											</span>
											<span ng-if="Registration.father.parent_profession== 'private'">
												Private Job
											</span>
											<span ng-if="Registration.father.parent_profession== 'other'">
												Other
											</span>
											<span ng-if="Registration.father.parent_profession== 'home-maker'">
												Home maker
											</span>
										</td>
									</tr>
									<tr ng-if="Registration.parent_type.mother">
										<td><b>Mother's Name</b></td>
										<td>[[ Registration.mother.parent_name ]]</td>
									</tr>
									<tr ng-if="Registration.parent_type.mother">
										<td><b>Mother's Profession</b></td>
										<td>
											<span ng-if="Registration.mother.parent_profession== 'government'">
												Government Services
											</span>
											<span ng-if="Registration.mother.parent_profession== 'business'">
												Self employed / Business
											</span>
											<span ng-if="Registration.mother.parent_profession== 'private'">
												Private Job
											</span>
											<span ng-if="Registration.mother.parent_profession== 'other'">
												Other
											</span>
											<span ng-if="Registration.mother.parent_profession== 'home-maker'">
												Home maker
											</span>
										</td>
									</tr>
									<tr ng-if="Registration.parent_type.guardian">
										<td><b>Guardian's Name</b></td>
										<td>[[ Registration.guardian.parent_name ]]</td>
									</tr>
									<tr ng-if="Registration.parent_type.guardian">
										<td><b>Guardian's Profession</b></td>
										<td>
											<span ng-if="Registration.guardian.parent_profession== 'government'">
												Government Services
											</span>
											<span ng-if="Registration.guardian.parent_profession== 'business'">
												Self employed / Business
											</span>
											<span ng-if="Registration.guardian.parent_profession== 'private'">
												Private Job
											</span>
											<span ng-if="Registration.guardian.parent_profession== 'other'">
												Other
											</span>
											<span ng-if="Registration.guardian.parent_profession== 'home-maker'">
												Home maker
											</span>
										</td>
									</tr>
									<tr>
										<td><b>Category</b></td>
										<td>
											<span ng-if="Registration.category == 'dg'">DG (Disadvantaged Group)</span>
											<span ng-if="Registration.category == 'ews'">EWS (Economically Weaker Section)</span>
										</td>
									</tr>

									<tr ng-if="Registration.category == 'ews'  && Registration.certificate_details.ews_type == 'income_certificate'">
										<td>
											<b>Family annual income (in INR)</b>
										</td>
										<td>
											[[Registration.certificate_details.ews_income]]
										</td>
									</tr>

									<tr ng-if="Registration.category == 'dg'">
										<td>
											<b>Type of DG</b>
										</td>
										<td>
											<span ng-if="Registration.certificate_details.dg_type == 'sc'">SC अनुसूचित जाति </span>
											<span ng-if="Registration.certificate_details.dg_type == 'st'">ST अनुसूचित जनजाति</span>
											<span ng-if="Registration.certificate_details.dg_type == 'obc'">OBC (NC)</span>
											<span ng-if="Registration.certificate_details.dg_type == 'orphan'">Orphan अनाथ</span>
											<span ng-if="Registration.certificate_details.dg_type == 'with_hiv'">Child or Parent is HIV +ve बच्चा या माता-पिता HIV + ve है</span>
											<span ng-if="Registration.certificate_details.dg_type == 'disable'">Child or Parent is Differently Abled(बच्चे या माता-पिता दिव्यांग)</span>
											<span ng-if="Registration.certificate_details.dg_type == 'widow_women'">Widow women with income less than INR 80,000 ( INR 80,000 से कम आय वाली विधवा महिलाएं)</span>
											<span ng-if="Registration.certificate_details.dg_type == 'divorced_women'">Divorced women with income less than INR 80,000 ( INR 80,000 से कम आय वाली तलाकशुदा महिलाएं)</span>
											<span ng-if="Registration.certificate_details.dg_type == 'disable_parents'">Parent is Differently Abled(विकलांग माता-पिता से संबंधित बच्चा)</span>
										</td>
									</tr>

									<tr ng-if="(Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate') || (Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc')">
										<td>
											<b>Name of Tahsil issuing income certificate</b>
										</td>
										<td ng-if="Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate'">
											[[Registration.certificate_details.ews_tahsil_name]]
										</td>
										<td ng-if="Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc'">
											[[Registration.certificate_details.dg_income_tahsil_name]]
										</td>
									</tr>
									
									<tr ng-if="(Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate') || (Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc')">
										<td>
											<b>Issued Income Certificate No.</b>
										</td>
										<td ng-if="Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate'">
											[[Registration.certificate_details.ews_cerificate_no]]
										</td>
										<td ng-if="Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc'">
											[[Registration.certificate_details.dg_income_cerificate]]
										</td>

									</tr>

									<tr ng-if="(Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate') || (Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc')">
										<td>
											<b>Certificate Issued Date</b>
										</td>
										<td ng-if="Registration.category == 'ews' && Registration.certificate_details.ews_type == 'income_certificate'">
											[[Registration.certificate_details.bpl_cerificate_date]]/[[Registration.certificate_details.bpl_cerificate_month]]/[[Registration.certificate_details.bpl_cerificate_year]]
										</td>
										<td ng-if="Registration.category == 'dg' && Registration.certificate_details.dg_type == 'obc'">
											[[Registration.certificate_details.dg_cerificate_date]]/[[Registration.certificate_details.dg_cerificate_month]]/[[Registration.certificate_details.dg_cerificate_year]]
										</td>

									</tr>
									<tr ng-if="Registration.category == 'ews' && Registration.certificate_details.ews_type == 'bpl_card'">
										<td>
											<b>Issued BPL Card No.</b>
										</td>
										<td>
											[[Registration.certificate_details.ews_cerificate_no]]
										</td>
									</tr>
									<tr ng-if="Registration.category == 'ews' && Registration.certificate_details.ews_type == 'bpl_card'">
										<td>
											<b>Name of Tahsil issuing BPL Card</b>
										</td>
										<td>
											[[Registration.certificate_details.ews_tahsil_name]]
										</td>
									</tr>



									<tr ng-if="Registration.certificate_details.dg_type == 'obc' || Registration.certificate_details.dg_type == 'sc'|| Registration.certificate_details.dg_type == 'st'">
										<td>
											<b>Name of Tahsil issuing cast certificate</b>
										</td>
										<td ng-if="Registration.category == 'dg'">
											[[Registration.certificate_details.dg_tahsil_name]]
										</td>
									</tr>
									<tr ng-if="Registration.category == 'dg'">
										<td>
											<b>Issued Certificate No.</b>
										</td>

										<td >
											[[Registration.certificate_details.dg_cerificate]]
										</td>
									</tr>


								</table>
							</div>
						</div>
					</div>
				</div><br>
				<div class="row" ng-controller="Step3Controller as Step3" ng-init="Step3.initAddress('{{$state->slug}}')" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Address Details</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tr>
										<td><b>District</b></td>
										<td>[[ Step3.formData.district_name ]]</td>
									</tr>
									<tr>
										<td><b>Block</b></td>
										<td>[[ Step3.formData.block_name ]]</td>
									</tr>
									<tr>
										<td><b>Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat</b></td>
										<td>[[ Step3.formData.sub_block_name ]]</td>
									</tr>
									<tr>
										<td><b>Ward Name</b></td>
										<td>[[ Step3.formData.locality_name ]]</td>
									</tr>
									<tr>
										<td><b>Pincode</b></td>
										<td>[[ Step3.formData.pincode ]]</td>
									</tr>
									<tr>
										<td><b>Residential address</b></td>
										<td>[[ Step3.formData.residential_address ]]</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div><br>

				<div class="row" ng-controller="Step4Controller as Step4" ng-init="Step4.initFileDetails('{{$state->slug}}')" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Documents Details</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tr>
										<td><b>Proof of birth</b></td>
										<td><span ng-if="Step4.formData.files.proof_of_birth.self_declaration">
												Self Declaration Certificate,
											</span>
											<span ng-if="Step4.formData.files.proof_of_birth.birth_certificate">
												Birth Certificate,
											</span>
											<span ng-if="Step4.formData.files.proof_of_birth.aadhaar_card">
												Aadhaar Card
											</span>
										</td>
									</tr>
									<tr>
										<td><b>Parent ID</b></td>
										<td>
											<span ng-if="Step4.formData.files.proof_of_parent.voter_card">
												Voter ID,
											</span>
											<span ng-if="Step4.formData.files.proof_of_parent.aadhaar_card">
												Aadhaar Card,
											</span>
											<span ng-if="Step4.formData.files.proof_of_parent.driving_license">
												Driving license,
											</span>
											<span ng-if="Step4.formData.files.proof_of_parent.pan_card">
												PAN card
											</span>
										</td>
									</tr>
									<tr>
										<td><b>Address proof</b></td>
										<td>
											<span ng-if="Step4.formData.files.proof_of_address.ration_card">
												Ration Card,
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.voter_card">
												Voter ID,
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.aadhaar_card">
												Aadhaar Card,
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.driving_license">
												Driving license,
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.electricity_bill">
												Electricity Bill
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.residential_certificate">
												Residential Certificate
											</span>
											<span ng-if="Step4.formData.files.proof_of_address.bank_passbook">
												Bank Passbook
											</span>
										</td>
									</tr>
									<tr>
										<td ng-if="Registration.category == 'ews'"><b>EWS certificate</b></td>
										<td ng-if="Registration.category == 'ews'">
											<span ng-if="Step4.formData.files.ews_documents.income_certificate">
												Income Certificate,
											</span>
											<span ng-if="Step4.formData.files.ews_documents.ration_card">
												Ration Card,
											</span>
										</td>
										<td ng-if="Registration.category == 'dg'"><b>DG certificate</b></td>
										<td ng-if="Registration.category == 'dg'">
											<span ng-if="Step4.formData.files.dg_documents.income_certificate">
												Income Certificate,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.cast_certificate">
												Cast Certificate,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.orphan_certificate">
												Orphan certificate,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.disability_certificate">
												Disability certificate,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.health_certificate">
												Health Certificate,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.father_death_certificate">
												Death certificate of father,
											</span>
											<span ng-if="Step4.formData.files.dg_documents.divorce_certificate">
												Divorce Certificate,
											</span>
										</td>

									</tr>

								</table>
							</div>
						</div>
					</div>
				</div><br>

				@if(!empty($candidate->registration_cycle->preferences))
				<div class="row" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Schools selected according to your preference from your Ward/Gram Panchayat</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tbody>
										<thead>
											<tr>
												<th class="text-center">Priority No.</th>
												<th class="text-center">UDISE</th>
												<th class="text-center">School Name</th>
											</tr>
										</thead>
										@if($candidate->registration_cycle->preferences)
										@foreach($candidate->registration_cycle->preferences as $key => $value)
											@foreach($schoolData as $school)
												@if(!empty($school))
													@if($school['id'] == $value)

														@php $schoolname = $school['name']; $schooludise = $school['udise']; @endphp
														
														<tr>
															<td>{{$key+1}}</td>
															<td>{{$schooludise}}</td>
															<td>{{$schoolname}}</td>
														</tr>

													@endif
												@endif
											@endforeach
										@endforeach
										@endif

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div><br>
				@endif
				@if(!empty($candidate->registration_cycle->nearby_preferences))
				<div class="row" ng-cloak>
					<div class="col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Schools selected according to your preference from Neighboring Ward/Gram Panchayat</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tbody>
										<thead>
											<tr>
												<th class="text-center">Priority No.</th>
												<th class="text-center">UDISE</th>
												<th class="text-center">School Name</th>
											</tr>
										</thead>

										@if($candidate->registration_cycle->nearby_preferences)
										@foreach($candidate->registration_cycle->nearby_preferences as $key => $value)
										@foreach($schoolNearbyData as $school)
										@if(!empty($school))
										@if($school['id'] == $value)
										@php $schoolname = $school['name']; $schooludise = $school['udise']; @endphp
										<tr>
											<td>{{$key+1}}</td>
											<td>{{$schooludise}}</td>
											<td>{{$schoolname}}</td>
										</tr>
										@endif
										@endif
										@endforeach
										@endforeach
										@endif

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div><br>
				@endif
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="text-center" ng-cloak ng-init="data={};data.registration_no = {{$registration->registration_no}}">
						<a href="{{route('state.registration.update',[$state->slug,$registration->registration_no])}}" role="button" class="btn-theme step-link">Edit Details</a>
						<button ng-click="create('{{$state->slug}}/student-registration/apply',data)" class="btn-theme step-link">
							Apply Now
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
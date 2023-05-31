@extends('districtadmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="heading-strip"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">Personal details</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<th>
								<tr>
									<th>Student Photo</th>
									<td><img class="img-thumbnail" src="{{$student->fmt_photo}}"></td>
								</tr>
								<tr>
									<th>First Name</th>
									<td>{{$student->first_name}}</td>
								</tr>
								<tr>
									<th>Middle Name</th>
									<td>{{$student->middle_name}}</td>
								</tr>
								<tr>
									<th>Last Name</th>
									<td>{{$student->last_name}}</td>
								</tr>
								<tr>
									<th>Gender</th>
									<td>{{$student->gender}}</td>
								</tr>
								<tr>
									<th>Date of birth</th>
									<td>{{$student->fmt_dob_form}}</td>
								</tr>
								<tr>
									<th>Selected Class</th>
									<td>{{$student->level['level']}}</td>
								</tr>
								<tr>
									<th>Mobile Number</th>
									<td>{{$student->mobile}}</td>
								</tr>
								<tr>
									<th>Email Id</th>
									<td>{{$student->email}}</td>
								</tr>
								<tr>
									<th>Aadhaar No.</th>
									<td>{{$student->aadhar_no}}</td>
								</tr>
								<tr>
									<th>Aadhaar Enrollment No.</th>
									<td>{{$student->aadhar_enrollment_no}}</td>
								</tr>

								@if ($student->registration_cycle)
									<tr>
										<th>Status</th> 
										<td>{{$student->registration_cycle->status}}</td>
									</tr>

									@if ($student->registration_cycle->status == 'enrolled' && $student->registration_cycle->enrolled_on)
										<tr>
											<th>Enrolled On</th> 
											<td>{{ \Carbon::parse($student->registration_cycle->enrolled_on)->format("d-m-Y") }}</td>
										</tr>
									@endif
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="panel panel-success">
					<div class="panel-heading">Parent Details</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tbody>
								@if($student->parent_details['parent_type'] == 'father')
								<tr>
									<th>Father's Name</th>
									<td>{{$student->parent_details['parent_name']}}</td>
								</tr>
								<tr>
									<th>Fathers's Mobile No.</th>
									<td>{{$student->parent_details['parent_mobile_no']}}</td>
								</tr>
								<tr>
									<th>Fathers's Profession</th>
									<td>@if($student->parent_details['parent_profession'] == 'government')
										Government Services
										@elseif($student->parent_details['parent_profession'] == 'business')
										Self employed / Business
										@elseif($student->parent_details['parent_profession'] == 'private')
										Private Job
										@elseif($student->parent_details['parent_profession'] == 'other')
										Other
										@elseif($student->parent_details['parent_profession'] == 'home-maker')
										Home maker
										@endif
									</td>
								</tr>
								@endif
								@if($student->parent_details['parent_type'] == 'mother')
								<tr>
									<th>Mother's Name</th>
									<td>{{$student->parent_details['parent_name']}}</td>
								</tr>
								<tr>
									<th>Mother's Mobile No.</th>
									<td>{{$student->parent_details['parent_mobile_no']}}</td>
								</tr>
								<tr>
									<th>Mother's Profession</th>
									<td>{{$student->parent_details['parent_profession']}}</td>
								</tr>
								@endif
								@if($student->parent_details['parent_type'] == 'guardian')
								<tr>
									<th>Guardian's Name</th>
									<td>{{$student->parent_details['parent_name']}}</td>
								</tr>
								<tr>
									<th>Guardian's Mobile No.</th>
									<td>{{$student->parent_details['parent_mobile_no']}}</td>
								</tr>
								<tr>
									<th>Guardian's Profession</th>
									<td>{{$student->parent_details['parent_profession']}}</td>
								</tr>
								@endif
								<tr>
									<th>Applied Category</th>
									<td>@if($student->personal_details['category'] == 'dg')
										DG
										@endif
										@if($student->personal_details['category'] == 'ews')
										EWS
										@endif
									</td>
								</tr>
								@if($student->personal_details['category']=='ews')
								
									@if($student->personal_details['certificate_details']['ews_type'] == 'income_certificate')
										<tr>
											<th>Total Annual Income of both the Parents from all sources</th>
											<td>{{$student->personal_details['certificate_details']['ews_income']}}</td>
										</tr>
										<tr>
											<th>Certificate issued Date</th>
											<td>
												{{$student->personal_details['certificate_details']['bpl_cerificate_date']}}/{{$student->personal_details['certificate_details']['bpl_cerificate_month']}}/{{$student->personal_details['certificate_details']['bpl_cerificate_year']}}
											</td>
										</tr>
									@endif	
								@endif
								@if($student->personal_details['category']=='dg')
								<tr>
									<th>Type of DG</th>
									<td>
										@if($student->personal_details['certificate_details']['dg_type'] =='sc')
										SC
										@elseif($student->personal_details['certificate_details']['dg_type'] =='st')
										ST
										@elseif($student->personal_details['certificate_details']['dg_type'] =='obc')
										OBC NCL (Income less than 4.5L)
										@elseif($student->personal_details['certificate_details']['dg_type'] =='orphan')
										Orphan
										@elseif($student->personal_details['certificate_details']['dg_type'] =='with_hiv')
										Child or Parent is HIV +ve
										@elseif($student->personal_details['certificate_details']['dg_type'] =='disable')
										Child or Parent is Differently Abled
										@elseif($student->personal_details['certificate_details']['dg_type'] =='widow_women')
										Widow women with income less than INR 80,000.
										@elseif($student->personal_details['certificate_details']['dg_type'] =='divorced_women')
										Divorced women with income less than INR 80,000
										@elseif($student->personal_details['certificate_details']['dg_type'] =='disable_parents')
										Parent is Differently Abled
										@endif
									</td>
								</tr>
								@endif

								<tr>
									<th>Name of Tahsil issuing income certificate</th>
									@if($student->personal_details['category']=='dg')
										<td>{{ $student->personal_details['certificate_details']['dg_tahsil_name'] }}</td>
									@endif
									@if($student->personal_details['category']=='ews')
										<td>{{ $student->personal_details['certificate_details']['ews_tahsil_name'] }}</td>
									@endif
								</tr>

								<tr>
									<th>Issued Certificate No.</th>
									@if($student->personal_details['category']=='dg')
										<td>{{ $student->personal_details['certificate_details']['dg_cerificate'] }}</td>
									@endif
									@if($student->personal_details['category']=='ews')
										<td>{{ $student->personal_details['certificate_details']['ews_cerificate_no'] }}</td>
									@endif
								</tr>

								@if($student->personal_details['category']=='dg' && $student->personal_details['certificate_details']['dg_type'] == 'obc')
								
									<tr>
										<td><b>Name of Tahsil issuing Income Certificate</b></td>
										<td>
										{{$student->personal_details->certificate_details['dg_income_tahsil_name']}}
										</td>
									</tr>
									<tr>
										<td><b>Issued Income Certificate No.</b></td>
										<td>
										{{$student->personal_details->certificate_details['dg_income_cerificate']}}
										</td>
								    </tr>

								    <tr>
										<th>Certificate Issued Date</th>
										<td>
											{{ $student->personal_details['certificate_details']['dg_cerificate_date'] }}/{{ $student->personal_details['certificate_details']['dg_cerificate_month'] }}/{{ $student->personal_details['certificate_details']['dg_cerificate_year'] }}
										</td>
									</tr>
								@endif
								
								@php
									$files_birth = array();
									$files_parent = array();
									$files_address = array();
									$files_ews_doc = array();
									$files_dg_doc = array();

									foreach($student->personal_details->files['proof_of_birth'] as $key => $file){

										if($file == 'false'){
											continue;
										}
										array_push($files_birth, $key);
									}

									foreach($student->personal_details->files['proof_of_parent'] as $key => $file){

										if($file == 'false'){
											continue;
										}
										array_push($files_parent, $key);
									}

									foreach($student->personal_details->files['proof_of_address'] as $key => $file){

										if($file == 'false'){
											continue;
										}
										array_push($files_address, $key);
									}

									if($student->personal_details['category']=='ews'){

										foreach($student->personal_details->files['ews_documents'] as $key => $file){

											if($file == 'false'){
												continue;
											}
											array_push($files_ews_doc, $key);
										}
									}

									if($student->personal_details['category']=='dg'){
										foreach($student->personal_details->files['dg_documents'] as $key => $file){

											if($file == 'false'){
												continue;
											}
											array_push($files_dg_doc, $key);
										}
									}

								@endphp

								<tr>
									<th>Proof of birth</th>
									<td>
										@if(in_array( 'self_declaration' ,$files_birth))
											Self Declaration Certificate, 
										@endif
										@if(in_array( 'birth_certificate' ,$files_birth))
											Birth Certificate, 
										@endif
										@if(in_array( 'aadhaar_card' ,$files_birth))
											Aadhaar Card
										@endif
									</td>
								</tr>

								<tr>
									<th>Parent ID</th>
									<td>
										@if(in_array( 'voter_card' ,$files_parent))
											Voter ID, 
										@endif
										@if(in_array( 'aadhaar_card' ,$files_parent))
											Aadhaar Card, 
										@endif
										@if(in_array( 'driving_license' ,$files_parent))
											Driving license, 
										@endif
										@if(in_array( 'pan_card' ,$files_parent))
											PAN card
										@endif
									</td>
								</tr>

								<tr>
									<th>Address proof</th>
									<td>
										@if(in_array( 'ration_card' ,$files_address))
											Ration Card, 
										@endif
										@if(in_array( 'voter_card' ,$files_address))
											Voter ID, 
										@endif
										@if(in_array( 'aadhaar_card' ,$files_address))
											Aadhaar Card, 
										@endif
										@if(in_array( 'driving_license' ,$files_address))
											Driving license, 
										@endif
											@if(in_array( 'electricity_bill' ,$files_address))
											Electricity Bill, 
										@endif
										@if(in_array( 'residential_certificate' ,$files_address))
											Residential Certificate, 
										@endif
										@if(in_array( 'bank_passbook' ,$files_address))
											Bank Passbook
										@endif
									</td>
								</tr>

								<tr>

									@if($student->personal_details['category']=='ews')

										<th>EWS certificate</th>
										<td>
											@if(in_array( 'income_certificate' ,$files_ews_doc))
												Income Certificate, 
											@endif
											@if(in_array( 'ration_card' ,$files_ews_doc))
												Ration Card
											@endif
										</td>
									@endif


									@if($student->personal_details['category']=='dg')

										<th>DG certificate</th>
										<td>
											@if(in_array( 'income_certificate' ,$files_dg_doc))
												Income Certificate, 
											@endif
											@if(in_array( 'cast_certificate' ,$files_dg_doc))
												Cast Certificate, 
											@endif
											@if(in_array( 'orphan_certificate' ,$files_dg_doc))
												Orphan certificate, 
											@endif
											@if(in_array( 'disability_certificate' ,$files_dg_doc))
												Disability certificate, 
											@endif
											@if(in_array( 'health_certificate' ,$files_dg_doc))
												Health Certificate, 
											@endif
											@if(in_array( 'father_death_certificate' ,$files_dg_doc))
												Death certificate of father, 
											@endif
											@if(in_array( 'divorce_certificate' ,$files_dg_doc))
												Divorce Certificate
											@endif
										</td>
									@endif

								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="panel panel-danger">
					<div class="panel-heading">Address Details</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th>State</th>
									<td>{{$student->country_state['name']}}</td>
								</tr>
								<tr>
									<th>District</th>
									<td>{{$student->personal_details->district['name']}}</td>
								</tr>
								<tr>
									<th>Block/Nagar/Panchayat</th>
									<td>{{$student->personal_details->block['name']}}</td>
								</tr>
								<tr>
									<th>Ward Name</th>
									<td>{{$student->personal_details->locality['name']}}</td>
								</tr>
								<tr>
									<th>Pincode</th>
									<td>{{$student->personal_details['pincode']}}</td>
								</tr>
								<tr>
									<th>Residential address</th>
									<td>{{$student->personal_details['residential_address']}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="panel panel-warning">
					<div class="panel-heading">School Selection</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tbody>
								<thead>
									<tr>
										<th class="text-center">Priority No.</th>
										<th class="text-center">School ID</th>
										<th class="text-center">School Name</th>
									</tr>
								</thead>
								@if($student->registration_cycle)
									@if($student->registration_cycle->preferences)
										@foreach($student->registration_cycle->preferences as $key => $value)
											@foreach($schoolData as $school)
												@if($school['id'] == $value)
													@php $schoolname =  $school['name']; $schooludise = $school['udise']; @endphp
												@endif
											@endforeach
										<tr>
											<td>{{$key+1}}</td>
											<td>{{$schooludise}}</td>
											<td>{{$schoolname}}</td>
										</tr>
										@endforeach
									@endif

									@if($student->registration_cycle->nearby_preferences)
										@foreach($student->registration_cycle->nearby_preferences as $key => $value)
											@foreach($nearbySchoolData as $school)
												@if($school['id'] == $value)
													@php $schoolname =  $school['name']; $schooludise = $school['udise']; @endphp
												@endif
											@endforeach
										<tr>
											<td>{{$key+1}}</td>
											<td>{{$schooludise}}</td>
											<td>{{$schoolname}}</td>
										</tr>
										@endforeach
									@endif
								@endif
							</tbody>
						</table></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
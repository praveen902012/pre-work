@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xs-12 text-right">
				<div class="heading-strip">
					<button ng-click="openPopup('stateadmin', 'student', 'update-student-details', 'create-popup-style');helper.student={{$student}}" class="btn btn-blue-outline">Update Student</button>

					<button class="btn btn-blue-outline" ng-click="openPopup('stateadmin', 'student', 'update-student-category', 'create-popup-style');helper.studentData={{$student}}">
						Change Category
					</button>
					<button class="btn btn-blue-outline" ng-click="openPopup('stateadmin', 'student', 'update-student-dob', 'create-popup-style');helper.studentData={{$student}}">
						Change DOB
					</button>
				</div>


			</div>
		</div>

        <div class="row">
			<div class="col-sm-6 col-xs-6">
				<div class="panel panel-success">
					<div class="panel-heading">Basic Details</div>
					<div class="panel-body">
						<p>
							<strong>Registration Number:</strong> {{$student->registration_no}}
						</p>
						<p>
							<strong>First Name:</strong> {{$student->first_name}}
						</p>
						<p>
							<strong>Middle Name:</strong> {{$student->middle_name}}
						</p>
						<p>
							<strong>Last Name:</strong> {{$student->last_name}}
						</p>
						@if(isset($student->mobile))
						<p>
							<strong>Mobile:</strong> {{$student->mobile}}
						</p>
						@endif
						@if(isset($student->email))
						<p>
							<strong>Email:</strong> {{$student->email}}
						</p>
						@endif
						@if(isset($student->gender))
						<p>
							<strong>Gender:</strong> {{$student->gender}}
						</p>
						@endif
						<p>
							<strong>Dob:</strong> {{ date('d F, Y', strtotime($student->dob))}}
						</p>
						<p>
							<strong>Class:</strong> {{$student->level->level}}
						</p>
						@if(isset($student->personal_details->category))
						<p>
							<strong>Category:</strong> {{$student->personal_details->category}}
						</p>
						@endif
						<p>
							<strong>Parent:</strong> {{$student->parent_details->parent_type}}
						</p>
						<p>
							<strong>Parent Name:</strong> {{$student->parent_details->parent_name}}
						</p>
						@if(isset($student->parent_details->parent_mobile_no))
						<p>
							<strong>Parent Mobile:</strong> {{$student->parent_details->parent_mobile_no}}
						</p>
						@endif
						<p>
							<strong>Parent Profession:</strong> {{$student->parent_details->parent_profession}}
						</p>

						@if(isset($student->personal_details->category) && $student->personal_details->category=='ews')

							@if(isset($certificate_details['ews_type']) && $certificate_details['ews_type']=='income_certificate')
								<p>
									<strong>EWS Type: </strong> Income Certificate
								</p>
								<p>
									<strong>Family annual income: </strong> {{ $certificate_details['ews_income'] }}
								</p>
								<p>
									<strong>Name of Tahsil issuing income certificate: </strong> {{ $certificate_details['ews_tahsil_name'] }}
								</p>
								<p>
									<strong>Income Certificate No.: </strong> {{ $certificate_details['ews_cerificate_no'] }}
								</p>
								<p>
									<strong>Income Certificate Issued Date: </strong>
									{{ $certificate_details['bpl_cerificate_date'] }}/
									{{ $certificate_details['bpl_cerificate_month'] }}/
									{{ $certificate_details['bpl_cerificate_year'] }}
								</p>
							@endif

							@if(isset($certificate_details['ews_type']) && $certificate_details['ews_type']=='bpl_card')
								<p>
									<strong>EWS Type: </strong> BPL Certificate
								</p>
								<p>
									<strong>Name of Tahsil issuing BPL card: </strong> {{ $certificate_details['ews_tahsil_name'] }}
								</p>
								<p>
									<strong>Issued BPL Card No: </strong> {{ $certificate_details['ews_cerificate_no'] }}
								</p>
							@endif
						@endif

						@if(isset($student->personal_details->category) && $student->personal_details->category=='dg')
							<p>
                            <strong>DG Type: </strong>
								@if(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='sc')
									SC
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='st')
									ST
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='obc')
									OBC (NC)
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='orphan')
									Orphan
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='with_hiv')
									Child or Parent is HIV +ve
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='disable')
									Child or Parent is Differently Abled
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='widow_women')
									Widow women with income less than INR 80,000
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='divorced_women')
									Divorced women with income less than INR 80,000
								@elseif(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='disable_parents')
									Parent is Differently Abled
								@endif
							</p>

							@if(isset($certificate_details['dg_type']) && $certificate_details['dg_type']=='obc')
								<p>
									<strong>Name of Tahsil issuing DG certificate: </strong> {{ $certificate_details['dg_income_tahsil_name'] }}
								</p>
								<p>
									<strong>DG Certificate No.: </strong> {{ $certificate_details['dg_income_cerificate'] }}
								</p>
								<p>
									<strong>DG Certificate Issued Date: </strong>
									{{ $certificate_details['dg_cerificate_date'] }}/
									{{ $certificate_details['dg_cerificate_month'] }}/
									{{ $certificate_details['dg_cerificate_year'] }}
								</p>

							@endif

							@if(isset($certificate_details['dg_type']))

								@if($certificate_details['dg_type']=='sc' || $certificate_details['dg_type']=='st' || $certificate_details['dg_type']=='obc')
									<p>
										<strong>Name of Tahsil issuing Cast certificate: </strong> {{ $certificate_details['dg_tahsil_name'] }}
									</p>
									<p>
										<strong>Cast Certificate No.: </strong> {{ $certificate_details['dg_cerificate'] }}
									</p>
								@endif

							@endif

						@endif

						@if ($student->registration_cycle)
							<p>
								<strong>Status:</strong> {{$student->registration_cycle->status}}
							</p>

							@if ($student->registration_cycle->status == 'enrolled' && $student->registration_cycle->enrolled_on)
								<p>
									<strong>Enrolled On:</strong> {{ \Carbon::parse($student->registration_cycle->enrolled_on)->format("d-m-Y") }}
								</p>
							@endif
						@endif
					</div>
				</div>

				<div class="panel panel-danger">
					<div class="panel-heading">Residential Details</div>
					<div class="panel-body">
						<p>
							<strong>Residential Address:</strong> {{$student->personal_details->residential_address}}
						</p>
						<p>
							<strong>Venue:</strong> {{$student->personal_details->venue}}
						</p>
						<p>
							<strong>Pincode:</strong> {{$student->personal_details->pincode}}
						</p>
						<p>
							<strong>State:</strong> {{$student->statename->name}}
						</p>
						<p>
							<strong>District:</strong> {{$student->personal_details->district->name}}
						</p>
						<p>
							<strong>Block:</strong> {{$student->personal_details->block->name}}
						</p>
						<p>
							<strong>Locality:</strong> {{$student->personal_details->locality->name}}
						</p>
						@if(isset($student->personal_details->sublocality->name))
						<p>
							<strong>Sub Locality:</strong> {{$student->personal_details->sublocality->name}}
						</p>
						@endif
						@if(isset($student->personal_details->subsublocality->name))
						<p>
							<strong>Sub Sub Locality:</strong> {{$student->personal_details->subsublocality->name}}
						</p>
						@endif
					</div>
				</div>

            </div>

            <div class="col-sm-6 col-xs-6">
				@if(!empty($student->registration_cycle->preferences))
					<div class="panel panel-warning">
						<div class="panel-heading">Schools selected according to student preference</div>
						<div class="panel-body">
							@if($student->registration_cycle->preferences)
								@foreach($student->registration_cycle->preferences as $key => $value)
									@foreach($schoolData as $school)
										@if(!empty($school))
											@if($school['id'] == $value)

												@php
													$schoolname = $school['name'];
													$schooludise = $school['udise'];
													$schoolphone = $school['phone'];
													$schooladdress = $school['address'];
													$schoolnodal = $school['nodal']['nodaladmin']['user'];
												@endphp

												<p>
													<strong>Preference No.:</strong> {{$key+1}}
												</p>
												<p>
													<strong>School name:</strong> {{$schoolname}}
												</p>
												<p>
													<strong>Udise:</strong> {{$schooludise}}
												</p>
												<p>
													<strong>Phone:</strong> {{$schoolphone}}
												</p>
												<p>
													<strong>Address:</strong> {{$schooladdress}}
												</p>

												<p>
													<strong>Block admin name:</strong> {{$schoolnodal['display_name']}}
												</p>

												<p>
													<strong>Block admin email:</strong> {{$schoolnodal['email']}}
												</p>

												<hr>
											@endif
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
					</div>
				@endif

				@if(!empty($student->registration_cycle->nearby_preferences))
					<div class="panel panel-warning">
						<div class="panel-heading">Schools selected according to student Neighboring preference</div>
						<div class="panel-body">
							@if($student->registration_cycle->nearby_preferences)
								@foreach($student->registration_cycle->nearby_preferences as $key => $value)
									@foreach($schoolNearbyData as $school)
										@if(!empty($school))
											@if($school['id'] == $value)

												@php
													$schoolname = $school['name'];
													$schooludise = $school['udise'];
													$schoolphone = $school['phone'];
													$schooladdress = $school['address'];
													$schoolnodal = $school['nodal']['nodaladmin']['user'];
												@endphp

												<p>
													<strong>Preference No.:</strong> {{$key+1}}
												</p>
												<p>
													<strong>School name:</strong> {{$schoolname}}
												</p>
												<p>
													<strong>Udise:</strong> {{$schooludise}}
												</p>
												<p>
													<strong>Phone:</strong> {{$schoolphone}}
												</p>
												<p>
													<strong>Address:</strong> {{$schooladdress}}
												</p>

												<p>
													<strong>Block admin name:</strong> {{$schoolnodal['display_name']}}
												</p>

												<p>
													<strong>Block admin email:</strong> {{$schoolnodal['email']}}
												</p>

												<hr>
											@endif
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
					</div>
				@endif
			</div>

        </div>
    </div>
</section>
@endsection

@extends('nodaladmin::includes.layout')
@section('content')
<section  class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">

		@if($student->registration_cycle->status == 'withdraw')
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">Student Action</div>
					<div class="panel-body">
						@if(isset($student->dropout_reason->reason))
						<p><strong>Reason given by School Admin:</strong> {{$student->dropout_reason->reason}}</p>
						@endif
						<button ng-really-action="Dropout" ng-really-message="Do you want to mark this student as dropout?" ng-really-click="create('nodaladmin/student/mark-dropout/{{$student->id}}',  student, 'dropout')" class="btn btn-danger">Mark as dropout</button>
						<button ng-really-action="Reject" ng-really-message="Do you want to reject the dropout request for this student?" ng-really-click="create('nodaladmin/student/reject-dropout/{{$student->id}}',  student, 'reject')" class="btn btn-primary">Reject</button>
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($student->registration_cycle->document_verification_status == 'rejected')
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">Student Action</div>
					<div class="panel-body">
						@if(isset($student->registration_cycle->doc_reject_reason))
						<p><strong>Document Reject Reson:</strong> {{$student->registration_cycle->doc_reject_reason}}</p>
						@endif
						{{-- <button ng-really-action="Dropout" ng-really-message="Do you want to mark this student as dropout?" ng-really-click="create('nodaladmin/student/mark-dropout/{{$student->id}}',  student, 'dropout')" class="btn btn-danger">Mark as dropout</button>
						<button ng-really-action="Reject" ng-really-message="Do you want to reject the dropout request for this student?" ng-really-click="create('nodaladmin/student/reject-dropout/{{$student->id}}',  student, 'reject')" class="btn btn-primary">Reject</button> --}}
					</div>
				</div>
			</div>
		</div>
		@endif

		@if($student->registration_cycle->status == 'dismissed')
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading">Student Reject Action</div>
					<div class="panel-body">
						@if($student->rejected_reason)
						<div class="alert alert-warning">
							<strong>Reason given by school:</strong> {{$student->rejected_reason}}
						</div>
						@endif
						<div class="text-center ">
							@if($student->rejected_document)
							<label>Document uploaded by school:</label><span><a class="btn btn-default"href="{{$student->fmt_rejected_document}}">Download File</a></span><br><br>
							@endif
							<button ng-really-action="Reject" ng-really-message="Do you want to mark this student as reject?" ng-really-click="create('nodaladmin/student/mark-reject/{{$student->id}}',  student, 'reject')" class="btn btn-danger">Mark as  Rejected</button>
							<button ng-really-action="Cancel and enroll" ng-really-message="Do you want to cancel the reject request for this student and enroll the student?" ng-really-click="create('nodaladmin/student/reject-reject/{{$student->id}}',  student, 'reject')" class="btn btn-primary">Cancel Rejection</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif

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

							@if(isset($student->certificate_details->ews_type) && $student->certificate_details->ews_type=='income_certificate')
								<p>
									<strong>EWS Type: </strong> Income Certificate
								</p>
								<p>
									<strong>Family annual income: </strong> {{ $student->certificate_details->ews_income }}
								</p>
								<p>
									<strong>Name of Tahsil issuing income certificate: </strong> {{ $student->certificate_details->ews_tahsil_name }}
								</p>
								<p>
									<strong>Income Certificate No.: </strong> {{ $student->certificate_details->ews_cerificate_no }}
								</p>
								<p>
									<strong>Income Certificate Issued Date: </strong> 
									{{ $student->certificate_details->bpl_cerificate_date }}/
									{{ $student->certificate_details->bpl_cerificate_month }}/
									{{ $student->certificate_details->bpl_cerificate_year }}
								</p>
							@endif

							@if(isset($student->certificate_details->ews_type) && $student->certificate_details->ews_type=='bpl_card')
								<p>
									<strong>EWS Type: </strong> BPL Certificate
								</p>
								<p>
									<strong>Name of Tahsil issuing BPL card: </strong> {{ $student->certificate_details->ews_tahsil_name }}
								</p>
								<p>
									<strong>Issued BPL Card No: </strong> {{ $student->certificate_details->ews_cerificate_no }}
								</p>
							@endif
						@endif

						@if(isset($student->personal_details->category) && $student->personal_details->category=='dg')
							<p>
								<strong>DG Type: </strong> 
								@if(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='sc')
									SC
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='st')
									ST
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='obc')
									OBC (NC)
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='orphan')
									Orphan
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='with_hiv')
									Child or Parent is HIV +ve
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='disable')
									Child or Parent is Differently Abled
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='widow_women')
									Widow women with income less than INR 80,000
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='divorced_women')
									Divorced women with income less than INR 80,000
								@elseif(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='disable_parents')
									Parent is Differently Abled
								@endif
							</p>

							@if(isset($student->certificate_details->dg_type) && $student->certificate_details->dg_type=='obc')
								<p>
									<strong>Name of Tahsil issuing DG certificate: </strong> {{ $student->certificate_details->dg_income_tahsil_name }}
								</p>
								<p>
									<strong>DG Certificate No.: </strong> {{ $student->certificate_details->dg_income_cerificate }}
								</p>
								<p>
									<strong>DG Certificate Issued Date: </strong> 
									{{ $student->certificate_details->dg_cerificate_date }}/
									{{ $student->certificate_details->dg_cerificate_month }}/
									{{ $student->certificate_details->dg_cerificate_year }}
								</p>

							@endif

							@if(isset($student->certificate_details->dg_type))

								@if($student->certificate_details->dg_type=='sc' || $student->certificate_details->dg_type=='st' || $student->certificate_details->dg_type=='obc')
									<p>
										<strong>Name of Tahsil issuing Cast certificate: </strong> {{ $student->certificate_details->dg_tahsil_name }}
									</p>
									<p>
										<strong>Cast Certificate No.: </strong> {{ $student->certificate_details->dg_cerificate }}
									</p>
								@endif

							@endif
							
						@endif
					
						@if ($candidate->registration_cycle)
							<p>
								<strong>Status:</strong> {{$candidate->registration_cycle->status}}
							</p>

							@if ($candidate->registration_cycle->status == 'enrolled' && $candidate->registration_cycle->enrolled_on)
								<p>
									<strong>Enrolled On:</strong> {{ \Carbon::parse($candidate->registration_cycle->enrolled_on)->format("d-m-Y") }}
								</p>
							@endif
						@endif
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-6">
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

			@if(!empty($candidate->registration_cycle->preferences))
				<div class="col-sm-6 col-xs-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Schools selected according to student preference</div>
						<div class="panel-body">
							@if($candidate->registration_cycle->preferences)
								@foreach($candidate->registration_cycle->preferences as $key => $value)
									@foreach($schoolData as $school)
										@if(!empty($school))
											@if($school['id'] == $value)

												@php 
													$schoolname = $school['name']; 
													$schooludise = $school['udise']; 
													$schoolphone = $school['phone']; 
													$schooladdress = $school['address']; 
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
												
												<hr>
											@endif
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
					</div>
				</div>
			@endif

			@if(!empty($candidate->registration_cycle->nearby_preferences))
				<div class="col-sm-6 col-xs-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Schools selected according to student Neighboring preference</div>
						<div class="panel-body">
							@if($candidate->registration_cycle->nearby_preferences)
								@foreach($candidate->registration_cycle->nearby_preferences as $key => $value)
									@foreach($schoolNearbyData as $school)
										@if(!empty($school))
											@if($school['id'] == $value)

												@php 
													$schoolname = $school['name']; 
													$schooludise = $school['udise']; 
													$schoolphone = $school['phone']; 
													$schooladdress = $school['address']; 
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

												<hr>
											@endif
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
					</div>
				</div>
			@endif

		</div>
	</div>
</section>
@endsection
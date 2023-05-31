@extends('schooladmin::includes.layout')
@section('content')
<section  class="schooladmin_dash cm-content" ng-controller="AppController" ng-cloak>
	<div class="container-fluid">
		@if(count($student->bank_details)==0)
		<div class="alert alert-danger">
			 Please add student bank details.
			<button  ng-click="helper.registration_id={{$student->id}};openPopup('schooladmin', 'student', 'add-bank', 'create-popup-style')" class="pull-right btn btn-info btn-xs ">Add Bank Details</button>
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
				@if($student->registration_cycle->status=='enrolled' && count($student->bank_details)>0)
					<div class="panel panel-success">
						<div class="panel-heading">Bank Details</div>
						<div class="panel-body">
							<p>
								<strong>Bank name:</strong> {{$student->bank_details->bank_name}}
								<button ng-click="helper.registration_id={{$student->id}};openPopup('schooladmin', 'student', 'edit-bank', 'create-popup-style')"  class="pull-right btn btn-info btn-xs city-action-btn">Edit Bank Details</button>
							</p>
							<p>
								<strong>Account holder name:</strong> {{$student->bank_details->account_holder_name}}
							</p>
							<p>
								<strong>Account number:</strong> {{$student->bank_details->account_number}}
							</p>
							<p>
								<strong>IFSC:</strong> {{$student->bank_details->ifsc_code}}
							</p>
						</div>
					</div>
					<div class="panel panel-success">
						<div class="panel-heading">Grade Report</div>
						<div class="panel-body">
							<table class="table table-responsive custom-table">
								<thead class="thead-cls">
									<tr>
										<th>Subject</th>
										<th>Total Marks</th>
										<th>Marks Obtained</th>
										<th>Average Class Marks</th>
									</tr>
								</thead>
								@if(!empty($student->report_card))
									@foreach($student->report_card->grade_report as $item)
									<tr>
										<td>{{$item->subject->name}}</td>
										<td>{{$item->total_marks}}</td>
										<td>{{$item->scored_marks}}</td>
										<td>{{$item->avg_marks}}</td>
									</tr>
									@endforeach
								@endif
							</table>
						</div>
					</div>
				@endif
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

				@if($student->registration_cycle->status=='enrolled')
				<div class="panel panel-danger">
					<div class="panel-heading">Attendance Report</div>
					<div class="panel-body">
						<table class="table table-responsive custom-table">
							<thead class="thead-cls">
								<tr>
									<th>Month</th>
									<th>Total Days</th>
									<th>Attended Days</th>
								</tr>
							</thead>
							@if(!empty($student->report_card))
								@foreach($student->report_card->attendance_report as $item)
								<tr>
									<td>{{$item->month}}</td>
									<td>{{$item->total_days}}</td>
									<td>{{$item->attended_days}}</td>
								</tr>
								@endforeach
							@endif
						</table>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</section>
@endsection

@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height cm-content section-spacing" ng-controller="AppController">
	<div class="container" ng-init="getAPIData('{{$state->slug}}/school/get-details/{{$school_id}}/for/{{$registration_id}}', 'school')" ng-cloak>
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-8 col-xs-12">
					<div class="heading-strip all-pg-heading">
						<h2>
						School Details
						</h2>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">

				</div>
			</div>
			<div class="hm-card bg-wht school-info ">
				<div class="info-row-heading">
					<div class="row">
						<div class="col-sm-3">
							<h4>
							UDISE Code
							</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.udise]]
							</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>School Name</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.name]]
							</p>
						</div>
					</div>
				</div>
				<div ng-if="school.website.length>0" class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>School website</h4>
						</div>
						<div class="col-sm-5">
							<p>
								<a href="" tergt="_blank">
									[[school.website]]
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Contact number</h4>
						</div>
						<div class="col-sm-5">
							<p>[[school.phone]]</p>
						</div>
					</div>
				</div>
				<div ng-if="school.fmt_logo.length>0" class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>School Photo
							</h4>
						</div>
						<div class="col-sm-5">
							<img src="[[school.fmt_logo]]" class="img-responsive" alt="name">
						</div>
					</div>
				</div>

				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Class upto</h4>
						</div>
						<div class="col-sm-5">
							<p>[[school.type]]</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Medium of Instruction</h4>
						</div>
						<div class="col-sm-5">
							<p>[[school.language.name]]</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Type</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.school_type]]
							</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Fees</h4>
						</div>
						<div class="col-sm-5">
							<p>
								Rs. [[school.total_fees]]
							</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Block</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.block.name]]
							</p>
						</div>
					</div>
				</div>
				<div class="info-row ">
					<div class="row">
						<div class="col-sm-3">
							<h4>Ward Name/Gram Panchayat</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.locality.name]]
							</p>
						</div>
					</div>
				</div>
				<div ng-class="school.description.length>0?'info-row':'info-row no-border'">
					<div class="row">
						<div class="col-sm-3">
							<h4>Postal Address</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.address]],
							</p>
							<p>
								[[school.locality.name]], [[school.block.name]],
							</p>
							<p>
								[[school.district.name]],
							</p>
							<p>
								[[school.state.name]], [[school.pincode]].
							</p>
						</div>
					</div>
				</div>
				<div ng-if="school.description.length>0" class="info-row no-border">
					<div class="row">
						<div class="col-sm-3">
							<h4>School Description</h4>
						</div>
						<div class="col-sm-5">
							<p>
								[[school.description]]
							</p>
						</div>
					</div>
				</div>


			</div>

		</div>
	</div>
</div>
</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
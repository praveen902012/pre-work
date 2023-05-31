@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="page-height step-schoolselect" ng-controller="AppController">
	<div class="container" >
		<div class="sp-form-container" ng-controller="Step5Controller as Step5">
			<div class="row" ng-init="Step5.getStep5Data('{{$state->slug}}',{{$registration->id}})">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 col-xlg-12">
					@include('state::registration.includes.inc-step-header')
					<form id="step5" class="sp-form common-form" name="step5" ng-submit="create('{{$state->slug}}/student-registration/step5/update', Step5.formData, 'step5')" ng-cloak>
						<div ng-init="Step5.initSchools('{{$state->slug}}', '0-1')">
							<div class="row" ng-init="Step5.initNearbySchools('{{$state->slug}}', '1-3')">
								<div class="col-md-4">
									<!-- <div class="form-group">
												<label>
															Select range based on your location <span class="mand-field">*</span>
															<p class="hindi-lbl"> (हिंदी अनुवाद के अनुसार)
																		<span class="mand-field">*</span>
															</p>
												</label>
												<div class="form-group" ng-init="location = [{value: '0-1', name: 'Ward/Gram Panchayat' }, {value: '1-3', name: 'Neighboring Ward/Gram Panchayat' }];Step5.location = {value: '0-1', name: 'Ward' }">
															<ui-select class="" ng-model="Step5.location" theme="select2" ng-change="Step5.initSchools('{{$state->slug}}', Step5.location)">
																<ui-select-match placeholder="Select">
																	[[$select.selected.name]]
																</ui-select-match>
																<ui-select-choices repeat="item.value as item in location | filter:$select.search">
																	[[item.name]]
																</ui-select-choices>
															</ui-select>
												</div>
									</div> -->
								</div>
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									<label>
										<a href="{{ route('state.school.general.information.registered', $state->slug) }}" target="_blank">See the list of all the available schools<p>सभी उपलब्ध स्कूलों की सूची देखें</p></a>
									</label>
								</div>
							</div>

							<div class="row">
								<div class="col-md-11">
									<marquee id="school-select-marquee" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"
										style="color: red;">

										{{ googletrans('एडमिशन पाने की संभावनाएं बढ़ाने के लिए कृपया एक से ज्यादा स्कूल यदि उपलब्ध हो तो अवश्य चुनें।', $_COOKIE['lang']) }}

									</marquee>
								</div>
							</div>

							{{-- pref --}}
							<p class="text-center pdv-20">Add atleast 1 school according to your preference from your Ward/Gram Panchayat</p><p class="text-center ">अपने वार्ड/ग्राम पंचायत से अपनी पसंद के अनुसार कितने भी स्कूल चुन सकते हैं </p>
							<div class="col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-md-5 no-padding">
										<p class="pdb-5">[[Step5.schools.length]]  available choices<p>उपलब्ध विकल्प</p></p>
										<div class="school-list-box">
											<table class="table table-fixed">
												<thead>
													<tr>
														<th class="font-sm col-xs-2">Add<p>जोडें</p></th>
														<th class="font-sm col-xs-4">School Name<p>विद्यालय का नाम</p></th>
														<th class="col-xs-6 search-blk">
															<i class="fa fa-search search-icon" aria-hidden="true"></i>
															<input type="text" class="form-control" ng-model="search_school.name" placeholder="Search school">
														</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="school in Step5.schools| filter:search_school">
														<td class="col-xs-2">
															<button type="button" class="btn btn-theme" ng-click="Step5.selectSchool($index, school)">
															+
															</button>
														</td>
														<td class="col-xs-10">
															<p class="font-sm">
																<span ng-bind="school.name"></span><br>
																<span ng-bind="school.address"></span><br>
																Total No. of Seats Available: [[school.total_seats_available]]<br>
																<a  target="_blank" ng-href="/{{$state->slug }}/school/[[school.id]]/details/{{$registration_no}}">More details</a>
															</p>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-2 no-padding hidden-xs">
										<div class="dtable sp-arrow-block text-center">
											<div class="table-child">
												<i class="fa fa-long-arrow-right icon-arrow" aria-hidden="true"></i>
												<i class="fa fa-long-arrow-left icon-arrow" aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div class="col-md-5 no-padding">
										<p class="text-theme-green pdb-5">
										[[Step5.selected_schools.length]]  selected choices<p>चयनित विकल्प</p></p>
										<div class="school-list-box">
											<table class="table table-fixed table-fixed-selected">
												<thead>
													<tr>
														<th class="font-sm col-xs-2">Remove<p>हटाएँ</p></th>
														<th class="font-sm col-xs-2">Priority<p>प्राथमिकता</p></th>
														<th class="font-sm col-xs-8">School Name<p>विद्यालय का नाम</p></th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="school in Step5.selected_schools">
														<td class="col-xs-2 text-center">
															<button type="button" class="btn btn-danger btn-rm" ng-click="Step5.removeSchool($index, school)">
															x
															</button>
														</td>
														<td class="col-xs-2 text-center">
															<p ng-bind="$index+1"></p>
														</td>
														<td class="col-xs-8">
															<p class="font-sm">
																<span ng-bind="school.name"></span>
																<span ng-bind="school.address"></span>
															</p>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="text-center">
											<p class="text-lightgrey pdt-8">
												<small>Did not find your school? <a href="" ng-click="helper.slug='{{$state->slug}}';helper.registration_no={{$registration_no}};openPopup('state', 'registration', 'report-school', 'create-popup-style sm-popup-style')">Report.</a></small>
											</p>
										</div>
									</div>
								</div>
							</div>

							{{-- nearby pref --}}
							<p class="text-center pdv-20">Add school according to your preference from Neighboring Ward/Gram Panchayat</p><p class="text-center">अपने वार्ड/ग्राम पंचायत से अपनी पसंद के अनुसार कितने भी स्कूल चुन सकते हैं </p>
							<div class="col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-md-5 no-padding">
										<p class="pdb-5">[[Step5.nearby_schools.length]]  available choices<p>उपलब्ध विकल्प</p></p>
										<div class="school-list-box">
											<table class="table table-fixed">
												<thead>
													<tr>
													<th class="font-sm col-xs-2">Add<p>जोडें</p></th>
														<th class="font-sm col-xs-4">School Name<p>विद्यालय का नाम</p></th>
														<th class="col-xs-6 search-blk">
															<i class="fa fa-search search-icon" aria-hidden="true"></i>
															<input type="text" class="form-control" ng-model="search_school.name" placeholder="Search school">
														</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="school in Step5.nearby_schools| filter:search_school">
														<td class="col-xs-2">
															<button type="button" class="btn btn-theme" ng-click="Step5.selectNearbySchool($index, school)">
															+
															</button>
														</td>
														<td class="col-xs-10">
															<p class="font-sm">
																<span ng-bind="school.name"></span><br>
																<span ng-bind="school.address"></span><br>
																Total No. of Seats Available: [[school.total_seats_available]]<br>
																<a  target="_blank" ng-href="/{{$state->slug }}/school/[[school.id]]/details/{{$registration_no}}">More details</a>
															</p>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-2 no-padding hidden-xs">
										<div class="dtable sp-arrow-block text-center">
											<div class="table-child">
												<i class="fa fa-long-arrow-right icon-arrow" aria-hidden="true"></i>
												<i class="fa fa-long-arrow-left icon-arrow" aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div class="col-md-5 no-padding">
										<p class="text-theme-green pdb-5">[[Step5.selected_schools.length]]  selected choices<p>चयनित विकल्प</p></p>
										<div class="school-list-box">
											<table class="table table-fixed table-fixed-selected">
												<thead>
													<tr>
													<th class="font-sm col-xs-2">Remove<p>हटाएँ</p></th>
														<th class="font-sm col-xs-2">Priority<p>प्राथमिकता</p></th>
														<th class="font-sm col-xs-8">School Name<p>विद्यालय का नाम</p></th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="school in Step5.selected_nearby_schools">
														<td class="col-xs-2 text-center">
															<button type="button" class="btn btn-danger btn-rm" ng-click="Step5.removeNearbySchool($index, school)">
															x
															</button>
														</td>
														<td class="col-xs-2 text-center">
															<p ng-bind="$index+1"></p>
														</td>
														<td class="col-xs-8">
															<p class="font-sm">
																<span ng-bind="school.name"></span>
																<span ng-bind="school.address"></span>
															</p>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="text-center">
											<p class="text-lightgrey pdt-8">
												<small>Did not find your school? <a href="" ng-click="helper.slug='{{$state->slug}}';helper.registration_no={{$registration_no}};openPopup('state', 'registration', 'report-school', 'create-popup-style sm-popup-style')">Report.</a></small>
											</p>
										</div>
									</div>
								</div>
							</div>

							{{-- Declaration --}}
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="text-lightgrey pdv-20 label-declaration">
											<div class="">
												<div class="checkbox-block">
													<input type="checkbox" name="accept" ng-model="Step5.formData.accept" required>
												</div>
												<div class="checkbox-content">
													I {{$candidate->parent_details->parent_name}}, {{$candidate->parent_details->parent_type}} of {{$candidate->first_name}}
													@if($candidate->middle_name!='Null')
													{{$candidate->middle_name}}
													@endif
													@if($candidate->last_name!='Null')
													{{$candidate->last_name}}
													@endif
													hereby declare that the information given above is true and correct to the best of my knowledge and belief. I have read and understood all the provisions of the notification in this regard. In case any information is found false or incorrect on verification, the admission of my ward may be cancelled and I will be liable for the action to be taken against me as per law.
													<p>
														मैं {{$candidate->personal_details->parent_name}}, {{$candidate->first_name}}
														@if($candidate->middle_name!='Null')
														{{$candidate->middle_name}}
														@endif
														@if($candidate->last_name!='Null')
														 {{$candidate->last_name}}
														@endif

														@if($candidate->personal_details->parent_type=='father')
														का पिता
														@elseif($candidate->personal_details->parent_type=='mother')
														की माता
														@else
														का अभिभावक
														@endif
														एतद् द्वारा घोषणा करती हूं कि मेरी पूरी जानकारी और विश्वास के अनुसार उक्त जानकारी सत्य एवं सही है। मैंने इस संबंध में अधिसूचना के सारे उपबन्ध पढ़कर समझ लिये हैं। यदि सत्यापन करने पर कोई जानकारी झूठी या असत्य पाई जाती है तो मेरे बच्चे का प्रवेश रद्द किया जा सकता है व मैं अपने विरुद्ध कानून के अनुसार की जाने वाली कार्रवाई के लिए उत्तरदायी हूँ ।
													</p>
												</div>
											</div>
										</label>
									</div>
								</div>
							</div>

							<a ng-click="create('{{$state->slug}}/student-registration/step5/save', Step5.formData, 'step5')" class="btn-theme mrt-20">
								<span ng-if="!inProcess">Save & Submit Later</span>
								<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</a>&nbsp;&nbsp;or&nbsp;&nbsp;

							<button ng-disabled="inProcess" type="submit" class="btn-theme mrt-20">
								<span ng-if="!inProcess">Save & Continue</span>
								<span ng-if="inProcess">Please Wait.. <i class="fa fa-spinner fa-spin"></i></span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script>

    document.addEventListener('DOMContentLoaded', function(event) {

        var element = document.getElementById('school-select-marquee');

		setTimeout(function() {
			element.start();
        }, 500);
    });

</script>

@include('state::includes.footer')
@include('state::includes.foot')

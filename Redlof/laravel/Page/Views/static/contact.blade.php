@include('page::includes.head')
@include('page::includes.header')
<section class="cm-content bg-grey" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div class="rte-container all-sm-top bg-grey margin-top ">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<h2>Contact Us</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-7 col-xs-12">
					<div class="address-box">
						<ul class="list-unstyled">
							<li>
								<a href="">
									<p>Indus Action<br>
										K-112, 1st Floor, B K Dutt Colony, Jor Bagh Road,<br>
										New Delhi - 110003
									</p>
								</a>
							</li>
							<li class="contact-link">
								<a href="">
									<strong>
									Tel:
									</strong>
									080 - 2545 5455
								</a>
							</li>
							<li class="contact-link">
								<a href="">
									<strong>
									Email:
									</strong>
									info@rte.com
								</a>
							</li>
						</ul>
					</div>
					<div class="social-media">
						<p>
							Contact via social media
						</p>
						<a href="" class="fb">
							<img src="{!! asset('img/rte-fb-link.png') !!}" class="" alt="rte-fb-link">
						</a>
						<a href="" class="twt">
							<img src="{!! asset('img/rte-twitter-link.png') !!}" class="" alt="rte-twitter-link">
						</a>
					</div>
				</div>
				<div class="col-sm-5 col-xs-12">
					<form name="contact_form" ng-submit="create('contact/send', formData)" class="contact-form ng-pristine ng-invalid ng-invalid-required ng-valid-email hide_element" element-init>
						<div class="form-group">
							<label>
								State <span>(हिंदी अनुवाद के अनुसार)</span>
								<span class="mand-field">
									&nbsp;*
								</span>
							</label>
							<ui-select class="" ng-model="formData.state" theme="select2" ng-init="getDropdown('allstates', 'states')" >
							<ui-select-match placeholder="Select State">
							[[$select.selected.name]]
							</ui-select-match>
							<ui-select-choices repeat="item in states | filter:$select.search">
							[[item.name]]
							</ui-select-choices>
							</ui-select>
							<!-- <input validator="required" valid-method="blur" type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="first_name" placeholder="State" ng-model="formData.first_name" required="" aria-invalid="true"> -->
						</div>
						<div class="form-group">
							<label>
								Name <span>(हिंदी अनुवाद के अनुसार)</span>
								<span class="mand-field">
									&nbsp;*
								</span>
							</label>
							<input validator="required" valid-method="blur" type="text" class="form-control ng-pristine ng-untouched ng-empty  ng-invalid ng-invalid-required" id="name" placeholder="Name" ng-model="formData.name" required="" aria-invalid="true">
						</div>
						<div class="form-group">
							<label>
								Email <span>(हिंदी अनुवाद के अनुसार)</span>
								<span class="mand-field">
									&nbsp;*
								</span>
							</label>
							<input validator="required" valid-method="blur" type="email" class="form-control ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="email" placeholder="Email" ng-model="formData.email" required="" aria-invalid="true">
						</div>
						<div class="form-group">
							<label>
								Contact No. <span>(हिंदी अनुवाद के अनुसार)</span>
								<span class="mand-field">
									&nbsp;*
								</span>
							</label>
							<input validator="required" valid-method="blur" type="tel" class="form-control ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="number" placeholder="Number" ng-model="formData.phone" required="" aria-invalid="true">
						</div>
						<div class="form-group">
							<label>
								Message <span>(हिंदी अनुवाद के अनुसार)</span> <span class="mand-field">
								*
							</span>								</label>
							<textarea validator="required" valid-method="blur" rows="6" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="email" placeholder="Message" ng-model="formData.message" required="" aria-invalid="true"></textarea>
						</div>
						<div class="form-group">
							<button class="btn-theme">SEND</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@if(\AuthHelper::isSignedInWithCookie())
@include('page::includes.footer')
@else
@include('page::includes.footer')
@endif
@include('page::includes.foot')
@include('page::includes.head')
@include('page::includes.header')
<section class="cm-content bg-grey" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div class="rte-container all-sm-top bg-grey margin-top ">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<h2>Team</h2>
					<div class="page-content">
						<p class="st-page-haeding">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at porttitor sem.  Aliquam erat volutpat. Donec placerat nisl magna, et faucibus arcu condimentum sed.
						</p>
					</div>
					<div class="hm-card team-card">
						<img src="{!! asset('img/rte-indus-action-logo.png') !!}" class="img-responsive center-block logo-indus" alt="rte-indus-action-logo">
						<div class="team-card-content">
							<p>
								Indus action is a non-profit organisation that has been working in the space of Policy Implementation in India since 2012.
							</p>
							<p>
								Indus Action’s low-cost, high-stake policy implementation campaigns, like Project Eklavya, nurture existing leadership within the community and Partner Entrepreneurs. This network organizes existing resources within governments and civil society to achieve our mission across India.
							</p>
							<a href="http://www.indusaction.org/" target="_blank">
								Visit Website <i class="ion-ios-arrow-down" style="vertical-align:middle"></i>
							</a>
						</div>
					</div>
					<div class="hm-card team-card">
						<img src="{!! asset('img/rte-think201-logo.png') !!}" class="img-responsive center-block" alt="rte-indus-action-logo">
						<div class="team-card-content">
							<p>
								A design focused tech startup helping other entrepreneurs and enterprises build their dream ideas in the world of Websites and Mobile Applications.
							</p>
							<p>
								We provide end-end solution to a business, right from ideation through conceptualization to design and development of web apps, mobile apps and websites relevant to the business requirement. We don’t just believe in delivering a quality product, we strive to provide a strong value add to your product.
							</p>
							<a href="https://think201.com/" target="_blank">
								Visit Website <i class="ion-ios-arrow-down" style="vertical-align:middle"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('page::includes.footer')
@include('page::includes.foot')
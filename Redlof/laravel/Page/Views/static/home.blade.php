@include('page::includes.head')
@include('page::includes.header')
<section class="home-map-section">
	<div class="container">
		<div class="rte-container bg-wht state-list-home">
			<div class="row">
				<div class="col-sm-5 col-xs-12">
					<h2>Select your State</h2>
					<ul class="list-unstyled">
						@if(!empty($states))
						@foreach($states as $state)
						<li >
							<a href="{{ route('state', $state->slug) }}">{{$state->name}}</a>
						</li>
						@endforeach
						@endif
					</ul>
				</div>
				<div class="col-sm-7 col-xs-12">
					@include("page::static.homepage-map")
				</div>
			</div>
		</div>
	</div>
</section>
<section class="state-about cm-content hm-sec-space">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="hm-card bg-hm-theme st-card-land">
						<div class="">
							<h2 class="text-center">
							What is RTE?
							</h2>
						</div>
						<div class="wht-rte">
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<p>
										The Right of Children to Free and Compulsory Education Act or Right to Education Act (RTE), is an Act of the Parliament of India enacted on 4 August 2009, which describes the modalities of the importance of free and compulsory education for children between 6 and 14 in India under Article 21a of the Indian Constitution. India became one of 135 countries to make education a fundamental right of every child when the Act came into force on 1 April 2010.
									</p>
									<div id="foo" style="display:none;"><p>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit,
										sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
									</p></div>
									<a href="#" onclick="toggle_visibility('foo');">	Read more
									<i class="ion-ios-arrow-down" style="vertical-align:middle"></i></a>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="embed-responsive embed-responsive-16by9">
										<iframe allowfullscreen="" frameborder="0" height="360" scrolling="no" src="http://www.youtube.com/embed/1e8xgF0JtVg?feature=player_detailpage" width="640">
										</iframe>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="state-about cm-content hm-sec-space">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="hm-card bg-hm-theme state-dy-card">
						<div class="card-content">
							<h2>
							Few words from honourable Prime Minister Narendra Modi
							</h2>
							<div class="minister-content">
								<div class="row hidden-xs">
									<div class="col-sm-6 col-xs-12">
										<p>
											Despite making right to education a fundamental right, India struggles to fill its schools with teachers across the hinterland
										</p>
										<h6 class="minister-nm">
										Narendra Modi
										</h6>
										<h6>
										Prime Minister (India)
										</h6>
									</div>
									<div class="col-sm-6 col-xs-12">
										<img src="https://uc.uxpin.com/files/91911/99228/uxpmod_2aec2ffd6ec31545c682b21d68503fb2_76948904_download-2.jpeg" class="img-responsive center-block pull-right" alt="name">
									</div>
								</div>
							</div>
							<div class="minister-content">
								<div class="row hidden-lg">
									<div class="col-sm-6 col-xs-12">
										<img src="https://uc.uxpin.com/files/91911/99228/uxpmod_273e5f6260bb6ebce9ca6439d19693f7_77154640_180px-Dr_Raman_Singh_at_Press_Club_Raipur_Mood_2.jpg" class="img-responsive center-block" alt="name">
									</div>
									<div class="col-sm-6 col-xs-12">
										<p>
											The future of the children of the state is safe and they have a bright career both in Chhattisgarh and national-level ahead.
										</p>
										<h6 class="minister-nm">
										Dr. Raman Singh
										</h6>
										<h6>
										Chief Minister (Chhattisgarh)
										</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="hm-card state-dy-card ">
						<div class="heading-header landing-header-card bg-hm-theme ">
							<h4 class="text-center">
							Global statistics
							</h4>
						</div>
						<div class="bg-wht">
							<div class="globl-st">
								<h2>
								{{$schools}}
								</h2>
								<p>
									Total School Registrations
								</p>
							</div>
							<div class="globl-st">
								<h2>
								{{$students}}
								</h2>
								<p>
									Total Student Registrations
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="state-media cm-content hm-sec-space">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="hm-card media-card md-card-lg bg-hm-theme">
						<div class="card-content">
							<div class="">
								<ul class="">
									<li>
										<img src="https://uc.uxpin.com/files/91911/99228/logo_nav.png" / class="img-responsive center-block">
										<p>
											School Education Department has issued guidelines to the public related to free admission in private schools under Right to Education Act in state. As per the provision in the Act 25 per cent admission will be given in Class-I of non-grant and recognised private schools.
										</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="cm-content hm-sec-space quotes-section">
	<div class="container">
		<div class="rte-container">
			<div class="quote-circle">
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<h2>
					Inspirational Quotes
					</h2>
					<h4>
					The function of education is to teach one to think intensively and to think critically. Intelligence plus character - that is the goal of true education.
					</h4>
					<p>
						- Nelson Mandela
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="state-gallery cm-content hm-sec-space">
	<div class="container">
		<div class="rte-container">
			<div class="heading-strip">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h2>
						Gallery
						</h2>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="hm-single-link">
							<a href="{{ route('gallery.get') }}">
								See all gallery
								<span>
									<i class="ion-ios-arrow-right"></i>
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<a class="gly-crop" href="" style="background-image: url('https://uc.uxpin.com/files/91911/99228/1__3_.png')">
					</a>
				</div>
				<div class="col-sm-3 col-xs-12">
					<a class="gly-crop" href="" style="background-image: url('{{ asset('img/rte-404-page.gif') }}')">
					</a>
				</div>
				<div class="col-sm-3 col-xs-12">
					<a class="gly-crop" href="" style="background-image: url('https://uc.uxpin.com/files/91911/99228/uxpmod_6b5e891228e5198021ef518fc6c90076_77154640_photo-1495983239379-7f250e210f10.jpg')">
					</a>
				</div>
				<div class="col-sm-3 col-xs-12">
					<a class="gly-crop" href="" style="background-image: url('https://uc.uxpin.com/files/91911/99228/1__3_.png')">
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
@include('page::includes.footer')
@include('page::includes.foot')
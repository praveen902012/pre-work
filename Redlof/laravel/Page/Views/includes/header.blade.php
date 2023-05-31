<header class="header header-outer">
	<div class="container">
		<div class="rte-container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-10">
					<a class="logo" href="{{ url('/') }}">
						<img src="{!! asset('img/rte-logo.png') !!}" class="rte-img" alt="RTE - PARADARSHI
						">
						<h2 class="logo-rte">
						RTE - PARADARSHI
						</h2>
						<h4 class="logo-name">
						Right of Children to Free and Compulsory Education Act
						</h4>
					</a>
				</div>
				<div class="col-md-6 col-sm-6 hidden-xs">
					<div class="header-action">
						<ul class="list-inline list-unstyled">
							<li>
								<div class="form-group">
									<select class="form-control language-select">
										<option value="1" selected>
											Select language
										</option>
										<option value="2">
											English
										</option>
										<option value="3">
											Hindi
										</option>
									</select>
								</div>
							</li>
						</ul>
					</div>
					<nav class="main-nav">
						<ul class="list-inline list-unstyled  clearfix">
							<li>
								<a href="{{ route('team.get') }}">
									Team
								</a>
							</li>
							<li>
								<a href="{{ route('gallery.get') }}">
									Gallery
								</a>
							</li>
							<li>
								<a href="{{ route('report.get') }}">
									Reports
								</a>
							</li>
							<li>
								<a href="{{ route('faqs.get')}}">
									FAQs
								</a>
							</li>
							<li>
								<a href="{{ route('contact.get') }}">
									Contact Us
								</a>
							</li>
						</ul>
					</nav>
				</div>
				<div class="col-xs-2 hidden-lg">
					<div class="navbar-header clearfix">
						<button data-toggle="collapse-side" data-target=".side-collapse" type="button" class="navbar-toggle">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
					</div>
					<div class="side-collapse" id="side-collapse">
						<nav class="navbar-collapse">
							<ul class="list-unstyled">
								<li class="nav-item">
									<div class="text-right">
										<a id="close_menu" class="btn btn-xs">
											<i class="fa fa-times" aria-hidden="true"></i>
										</a>
									</div>
								</li>
								<li>
									<div class="form-group">
										<select class="form-control">
											<option class="selected">
												Select language
											</option>
											<option>
												English
											</option>
											<option>
												Hindi
											</option>
										</select>
									</div>
								</li>
								<li>
									<a href="">
										School Login
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="wrapper">
	<header class="admin-header app_navigation">
		<!-- Logo -->
		<a ui-sref="stateadmin.dashboard" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini">
				<img src="{{ asset('img/rte-logo.png') }}" class="img-responsive" alt="{!! config('redlof.name') !!}">
			</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg">
				<img src="{{ asset('img/rte-logo.png') }}" class="img-responsive" alt="{!! config('redlof.name') !!}">
			</span>
				<span class="span-txt">
				RTE - State Admin
			</span>
		</a>
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a redlof-sidebar class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<ul class="list-unstyled list-inline titile-admin-action">
				<li>
					<a href="{{ route('stateadmin.dashboard') }}">
						<i class="fa fa-home home" aria-hidden="true"></i>
						डैशबोर्ड
					</a>
				</li>
			</ul>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu admin-profile">
				<ul class="list-unstyled">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img height="35" width="35" src="{{ $stateadmin->photo_thumb  }}" class="img-circle" alt="">
							<i class="fa ion-ios-arrow-down dropdown-icon" aria-hidden="true"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="{{ route('stateadmin.dashboard') }}">डैशबोर्ड</a>
							</li>
							<li>
								<a href="{{ route('stateadmin.profile') }}">प्रोफ़ाइल</a>
							</li>
							<li ng-click="signout('{{$state_slug}}')">
								<a href="">
									साईन आउट (बाहर आये)
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
<div class="wrapper">
	<header class="admin-header app_navigation">
		<!-- Logo -->
		<a ui-sref="admin.dashboard" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini">
				<img src="{{ asset('img/rte-logo.png') }}" class="img-responsive" alt="{!! config('redlof.name') !!}">
			</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg">
				<img src="{{ asset('img/rte-logo.png') }}" class="img-responsive" alt="{!! config('redlof.name') !!}">
			</span>
			<span class="span-txt">
				RTE - Admin
			</span>
		</a>
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a redlof-sidebar class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<p class="titile-admin-action">


				<a href="{{ route('admin.dashboard') }}">
					<i class="fa fa-home home" aria-hidden="true"></i>
					Dashboard
				</a>&nbsp;
				@if(isset($breadcrumbs) && count($breadcrumbs) > 0)

				@foreach($breadcrumbs as $key=>$value)
				<i class="fa fa-angle-right"></i>
				<a href="{{$value}}">{{$key}}</a>
				@endforeach
				@endif

			</p>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu admin-profile">
				<ul class="list-unstyled">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							@if(isset($admin->photo))
							<img src="{{ $admin->photo_thumb  }}" class="" alt="rte-admin">
							<i class="fa ion-ios-arrow-down dropdown-icon" aria-hidden="true"></i>
							@endif
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="{{ route('admin.dashboard') }}">Dashboard</a>
							</li>
							<li>
								<a href="{{ route('admin.profile') }}">Profile</a>
							</li>
							<li ng-click="signout('admin-signin')">
								<a href="">
									Sign Out
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
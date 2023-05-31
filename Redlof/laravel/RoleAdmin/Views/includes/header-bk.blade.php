<div class="wrapper">
	<header class="admin-header app_navigation">

			<!-- Logo -->

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a redlof-sidebar class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="list-unstyled">
						<li class="dropdown header-right-list">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								@if(isset($admin->photo))
								<img height="35" width="35" src="{{ $admin->photo  }}" class="img-circle" alt="User">
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
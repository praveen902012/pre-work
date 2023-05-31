<aside class="main-sidebar member-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" redlof-sidebar>
			<li>
				<a href="{{ route('admin.dashboard') }}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>

			<li>
				<a href="{{ route('admin.state.get') }}">
					<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>States</span>
				</a>
			</li>

			<li>
				<a href="{{ route('admin.manage.districts') }}">
					<i class="fa fa-tasks" aria-hidden="true"></i>&nbsp; <span>Manage Districts</span>
				</a>
			</li>

			<li>
				<a href="#">
					<i class="fa fa-database" aria-hidden="true"></i>
					<span>Data Repo</span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="{{ route('admin.language.all') }}">
							<i class="fa fa-language" aria-hidden="true"></i>&nbsp; <span>Languages</span>
						</a>
					</li>

				</ul>
			</li>

		</ul>
	</section>
	<section class="sidebar-footer">
		<p>&copy; <?php echo date('Y'); ?>. All rights Reserved. RTE</p>
	</section>
</aside>
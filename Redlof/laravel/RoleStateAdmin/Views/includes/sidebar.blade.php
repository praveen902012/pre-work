<aside class="main-sidebar member-sidebar">

	<section class="sidebar">

		<ul class="sidebar-menu" redlof-sidebar>
			<li>
				<a href="{{ route('stateadmin.dashboard') }}">
					<i class="fas fa-tachometer-alt"></i></i> <span>डैशबोर्ड</span>
				</a>
			</li>

			<li>
				<a href="{{ route('stateadmin.school.getall') }}">
					<i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span>विद्यालय</span>
				</a>
			</li>

			<li>
				<a href="{{ route('stateadmin.district.get') }}">
					<i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span>जिला एडमिन</span>
				</a>
			</li>

			<li>
				<a href="{{ route('stateadmin.nodal.nodal-admin') }}">
					<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>नोडल एडमिन</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.state.gallery') }}">
					<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>गेलरी का प्रबन्धन</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.lottery') }}">
					<i class="fas fa-ticket-alt"></i></i>&nbsp; <span>लॉटरी</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.registeredstudents') }}">
					<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>छात्र</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.documents') }}">
					<i class="fa fa-file" aria-hidden="true"></i>&nbsp; <span>दस्तावेज़</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.notifications-all') }}">
					<i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp; <span>Communication</span>
				</a>
			</li>
			<li>
				<a href="{{ route('stateadmin.block.nodal-admin') }}">
					<i class="fa fa-file" aria-hidden="true"></i>&nbsp; <span>Assign Block</span>
				</a>
			</li>
			{{-- <li>
				<a href="{{ route('stateadmin.manage-student') }}">
					<i class="fa fa-file" aria-hidden="true"></i>&nbsp; <span>Manage Student</span>
				</a>
			</li> --}}
			<li>
				<a href="{{ route('stateadmin.reports') }}">
					<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>Reports</span>
				</a>
			</li>
		</ul>
	</section>
	<section class="sidebar-footer">
		<span>© <?php echo date('Y'); ?>. All rights Reserved. RTE</span>
	</section>
</aside>
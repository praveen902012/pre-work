<aside class="main-sidebar member-sidebar">

	<section class="sidebar">

		<ul class="sidebar-menu" redlof-sidebar>
			<li>
				<a href="{{ route('schooladmin.dashboard') }}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li>
				<a href="{{ route('schooladmin.allotted-students') }}">
					<i class="fa fa-users"></i> <span>Students</span>
				</a>
			</li>
			<li>
				<a  href="{{ route('schooladmin.attendance') }}">
					<i class="fa fa-file"></i> <span>Attendence</span>
				</a>
			</li>
			<li>
				<a href="{{ route('schooladmin.grade') }}">
					<i class="fa fa-star"></i> <span>Grades</span>
				</a>
			</li>
			<li>
				<a href="{{ route('schooladmin.reimbursement') }}">
					<i class="fa fa-toggle-left"></i> <span>Reimbursement</span>
				</a>
			</li>
			<li>
				<a href="">
					<i class="fa fa-line-chart"></i> <span>Reports</span>
				</a>
			</li>

			<li>
				<a  href="{{ route('schooladmin.add-subject') }}">
					<i class="fa fa-book"></i> <span>Subjects</span>
				</a>
			</li>

			<li>
				<a  href="{{ route('schooladmin.school-profile-primary') }}">
					<i class="fa fa-cogs"></i> <span>School Profile</span>
				</a>
			</li>

			<!-- <li>
				<a  href="{{ route('schooladmin.edit-school') }}">
					<i class="fa fa-edit"></i> <span>Edit School </span>
				</a>
			</li> -->

			<!-- @if(($school->application_status != 'verified' && $has_current_cycle == true) || ($has_current_cycle == false))

				<li>
					<a  href="{{ route('schooladmin.edit-school') }}">
						<i class="fa fa-edit"></i> <span>Edit School </span>
					</a>
				</li>

			@endif -->

		</ul>
	</section>
	<section class="sidebar-footer">
		<span>©  <?php echo date('Y'); ?>. All rights Reserved. RTE</span>
	</section>
</aside>
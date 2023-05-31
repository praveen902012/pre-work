<aside class="main-sidebar member-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" redlof-sidebar>
			<li>
				<a href="{{ route('districtadmin.dashboard') }}">
					<i class="fa fa-dashboard"></i> <span>डैशबोर्ड</span>
				</a>
			</li>
			<ul class="sidebar-menu" redlof-sidebar>
				<li>
					<a href="{{ route('schools.all') }}">
						<i class="fa fa-building" aria-hidden="true"></i>&nbsp; <span>विद्यालय</span>
					</a>
				</li>
				<li>
					<a href="{{ route('districtadmin.students') }}">
						<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>छात्र </span>
					</a>
				</li>
				<li>
					<a href="{{ route('districtadmin.nodal.nodal-admin') }}">
						<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>नोडल एडमिन</span>
					</a>
				</li>
				<li>
					<a href="{{ route('districtadmin.nodal.bulk-upload') }}">
						<i class="fa fa-upload" aria-hidden="true"></i>&nbsp; <span>Bulk अपलोड</span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-toggle-left" aria-hidden="true"></i>
						<span>प्रतिपूर्ति</span><i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="{{ route('schools.reimbursement.school') }}">
								<i class="fa fa-language" aria-hidden="true"></i>&nbsp; <span>विद्यालय प्रतिपूर्ति</span>
							</a>
						</li>
						<li>
							<a href="{{ route('schools.reimbursement.student') }}">
								<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>छात्र प्रतिपूर्ति</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-support" aria-hidden="true"></i>
						<span>शिकायत</span><i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="{{ route('districtadmin.student.school-reports') }}">
								<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>छात्र शिकायत</span>
							</a>
						</li>
						<li>
							<a href="{{ route('districtadmin.student.admission.denied') }}">
								<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp; <span>विद्यालय मे दाखिले से वंचित</span>
							</a>
						</li>
						<li>
							<a href="{{ route('districtadmin.student.student-suspicious') }}">
								<i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp; <span>पंजीकरण मे  संदेह</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="{{ route('districtadmin.reports') }}">
						<i class="fa fa-flag" aria-hidden="true"></i>&nbsp; <span>Reports</span>
					</a>
				</li>
			</ul>
		</section>
		<section class="sidebar-footer">
			<span>©  <?php echo date('Y'); ?>. All rights Reserved. RTE</span>
		</section>
	</aside>
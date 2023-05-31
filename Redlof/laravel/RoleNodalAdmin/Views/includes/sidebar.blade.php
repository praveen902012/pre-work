<aside class="main-sidebar member-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" redlof-sidebar>
			<li>
				<a href="{{ route('nodaladmin.dashboard') }}">
					<i class="fa fa-dashboard"></i> <span>डैशबोर्ड</span>
				</a>
			</li>
			<li>
				<a href="{{ route('school.all-schools') }}">
					<i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span>विद्यालय </span>
				</a>
			</li>
			<li>
				<a href="{{ route('nodaladmin.allstudents') }}">
					<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>छात्र</span>
				</a>
			</li>
			<li>
				<a href="{{ route('nodaladmin.dropout.pending') }}">
					<i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span>शाला त्यागी छात्र</span>
				</a>
			</li>
			<li>
				<a href="{{ route('nodaladmin.admission.denied') }}">
					<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp; <span>विद्यालय मे दाखिले से वंचित</span>
				</a>
			</li>
			<li>
				<a href="{{ route('nodaladmin.students.verify') }}">
					<i class="fa fa-vcard" aria-hidden="true"></i>&nbsp; <span>प्रमाण पत्रों का सत्यापन</span>
				</a>
			</li>
			@if($udise_requested)
			<li>
				<a href="{{ route('nodaladmin.udise.upload') }}">
					<i class="fa fa-upload" aria-hidden="true"></i>&nbsp; <span>Upload Udise</span>
				</a>
			</li>
			@endif
		</ul>
	</section>
	<section class="sidebar-footer">
		<span>©  <?php echo date('Y'); ?>. All rights Reserved. RTE</span>
	</section>
</aside>
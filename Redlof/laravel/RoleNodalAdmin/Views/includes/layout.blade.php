@include('nodaladmin::includes.head')
@include('nodaladmin::includes.header')
@include('nodaladmin::includes.sidebar')

<div class="content-wrapper">
	<section class="content" init-redlof>
		@yield('content')
	</section>
</div>

@include('nodaladmin::includes.footer')
@include('nodaladmin::includes.foot')
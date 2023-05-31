@include('districtadmin::includes.head')
@include('districtadmin::includes.header')
@include('districtadmin::includes.sidebar')

<div class="content-wrapper">
	<section class="content" init-redlof>
		@yield('content')
	</section>
</div>

@include('districtadmin::includes.footer')
@include('districtadmin::includes.foot')
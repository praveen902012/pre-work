@include('schooladmin::includes.head')
@include('schooladmin::includes.header')
@include('schooladmin::includes.sidebar')

<div class="content-wrapper">
	<section class="content" init-redlof>
		@yield('content')
	</section>
</div>

@include('schooladmin::includes.footer')
@include('schooladmin::includes.foot')
@include('admin::includes.head')
@include('admin::includes.header')
@include('admin::includes.sidebar')

<div class="content-wrapper">
	<section class="content" init-redlof>
		@yield('content')
	</section>
</div>

@include('admin::includes.footer')
@include('admin::includes.foot')
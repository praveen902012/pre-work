@include('stateadmin::includes.head')
@include('stateadmin::includes.header')
@include('stateadmin::includes.sidebar')

<div class="content-wrapper">
	<section class="" init-redlof>
		@yield('content')
	</section>
</div>

@include('stateadmin::includes.footer')
@include('stateadmin::includes.foot')
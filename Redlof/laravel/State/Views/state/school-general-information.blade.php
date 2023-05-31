@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')

<section class="page-height">
	<div class="container">
		<li><a href="{{route('state.school.general.information.registered', $state->slug)}}">Registered Schools</a> </li>
		<li><a href="{{route('state.school.general.information.status', $state->slug)}}">Schools Status</a> </li>

	</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
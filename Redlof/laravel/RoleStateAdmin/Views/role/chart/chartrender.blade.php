
@if($chart)

{!! $chart->render() !!}

@else
<h3 class="text-center no_data_found">
	No data found, please change options and try again!
</h3>
@endif
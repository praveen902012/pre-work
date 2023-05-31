@include('admin::includes.head')


<div ui-view>
   	<div class="base-loader">
   		<img src="{!! AppHelper::logoUrl() !!}" class="img-responsive" alt="{!! config('redlof.name') !!}">
   	</div>
</div>


@include('admin::includes.foot')
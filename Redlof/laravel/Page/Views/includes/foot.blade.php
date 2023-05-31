<span class="loading-rte" spinner-start-active="showspinner" us-spinner spinner-key="redlofspinner" spinner-theme="rteSpinner"></span>

<div id="loader">
	<img src="{!! asset('img/h-loader.gif') !!}">
</div>
<div style="display: none">

</div>
{!! Html::script(getAsset('js/vendor.js')) !!}
{!! Html::script(getAsset('js/redlof.js')) !!}
{!! Html::script(getAsset('js/page.js')) !!}
<script type="text/javascript">
var root = '{!!url("/")!!}';
var app_name = '{!! config('app.name') !!}';
var AppConst = {!! json_encode(\AppHelper::getConstants()) !!}
</script>
<script type="text/javascript">
	function toggle_visibility(id) {
var e = document.getElementById(id);
e.style.display = ((e.style.display!='none') ? 'none' : 'block');
}
</script>

@if(env('APP_ENV') === 'production')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117675731-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-117675731-1');
</script>
@endif

@include('page::includes.toast')
</body>
</html>

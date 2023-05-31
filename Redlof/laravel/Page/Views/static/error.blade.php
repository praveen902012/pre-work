@include('page::includes.head')
@include('page::includes.header')
<section class="cm-content bg-grey page-height" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div class="rte-container all-sm-top bg-grey margin-top page-content">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="text-center page-404">
						<img src="{!! asset('img/rte-404-page.gif') !!}" class="img-responsive center-block" alt="rte-404-page">
						<h2>Something went wrong.</h2>
						<p>
							Our servers are not accepting the request made by you.<br>
							Possible cause: {{ isset($error['message']) ? $error['message'] : "" }}
						</p>
						<a href="" class="btn-theme btn-blue">Back to homepage</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('page::includes.footer')
@include('page::includes.foot')
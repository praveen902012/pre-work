@include('page::includes.head')
@include('page::includes.header')
<section class="cm-content bg-grey page-height" ng-app="app" ng-controller="AppController">
	<div class="container">
		<div class="rte-container all-sm-top bg-grey margin-top page-content">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="text-center page-404">
					<img src="{!! asset('img/rte-404-page.gif') !!}" class="img-responsive center-block" alt="rte-404-page">
						<h2>404 | Page not found</h2>
						<p>
							Sorry, we can't seem to find the page you are looking for.
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
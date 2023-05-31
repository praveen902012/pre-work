@include('state::includes.head')
@include('state::includes.header')
@include('state::includes.header-secondary')
<section class="state-gallery cm-content section-spacing all-single">
	<div class="container">
		<div class="rte-container">
			<div class="heading-strip">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h2>
						Gallery
						</h2>
						<p>
							Some of the latest images from our past successes.
						</p>
					</div>
					<div class="col-sm-6 col-xs-12">
					</div>
				</div>
			</div>
			<div class="" ng-controller="AppController" >
				<div class="" ng-controller="ListController as List" ng-cloak ng-init="List.init('image-list', {'getall': 'gallery/all/{{$state->id}}'})">
					<div class="row">
						<div ng-repeat="images in List.ListService.results" class="col-sm-3 col-xs-12">
							<a class="gly-crop" target="_blank" href="[[images.name]]">
								<img src="[[images.name]]" class="" alt="name">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')
<section class="state-gallery cm-content hm-sec-space" ng-controller="ListController as List" ng-cloak ng-init="List.init('image-list', {'getall': 'gallery/featured/{{$state->id}}'})">
	<div ng-show="List.ListService.results.length>0" class="container">
		<div class="rte-container">
			<div class="heading-strip">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h2>
						Notifications
						</h2>
						
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="hm-single-link">
							<a href="{{ route('state.gallery', $state->slug) }}">
								See all notifications
								<span>
									<i class="ion-ios-arrow-right"></i>
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
	<div class="" ng-controller="AppController" >
		<div class="">
			<div class="row">
				<div ng-repeat="images in List.ListService.results" class="col-sm-4 col-xs-12">
					<a class="gly-crop" target="_blank" href="[[images.name]]"><img src="[[images.name]]" class="" alt="name"></a>
				
				</div>
			</div>
		</div>
	</div>
		</div>
	</div>
</section>
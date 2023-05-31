(function() {

	"use strict";

	angular
		.module('app')
		.run(appStart);

	appStart.$inject = ['AccessService', '$rootScope'];

	function appStart(AccessService, $rootScope) {

		// Handle rootscope variables
		AccessService.setRootScopeData();

		$rootScope.$back = function() {
			window.history.back();
		};

		$rootScope.$on('$locationChangeStart', function() {
			$("html, body").animate({
				scrollTop: 0
			}, 0);
		});
	}

})();
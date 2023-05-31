(function() {

	'use strict';

	var Directives = angular.module('app.core');

	Directives.directive('elementInit', function() {
		return {
			link: function(scope, elem, attrs) {

				angular.element(elem).removeClass('hide_element');
				angular.element(elem).addClass('show_element');

			}
		};
	});

	Directives.directive('escKey', function() {
		return function(scope, element, attrs) {
			element.bind('keydown keypress', function(event) {
				if (event.which === 27) { // 27 = esc key
					scope.$apply(function() {
						scope.$eval(attrs.escKey);
					});

					event.preventDefault();
				}
			});
		};
	});

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('initSlider', [function() {
        return {
            restrict: 'A',
            link: function(rootScope, element, attrs) {
                setTimeout(function() {
                    initHomeGallery();
                }, 2000);

            }
        };
    }]);

})();
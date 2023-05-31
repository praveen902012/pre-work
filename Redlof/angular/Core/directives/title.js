(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('pageTitle', ['$rootScope', '$timeout', function($rootScope, $timeout) {
        return {
            link: function(scope, element, attrs) {

                $timeout(function() {
                    $rootScope.title = attrs.pageTitle + ' | MyMily';
                });
            }
        };
    }]);

})();
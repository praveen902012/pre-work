(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('redlofSidebar', [function() {
        return {
            restrict: 'A',
            link: function(rootScope, element, attrs) {
                rootScope.sidebarInitiated = false;
                if (rootScope.sidebarInitiated === false) {
                    $.RedlofDashboard.load();
                    rootScope.sidebarInitiated = true;
                }
            }
        };
    }]);

})();
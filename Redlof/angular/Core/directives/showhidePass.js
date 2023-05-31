(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('showHideContainer', function() {
        return {
            scope: {

            },
            controller: ['$scope', '$element', '$attrs', function($scope, $element, $attrs) {
                $scope.show = false;

                $scope.toggleType = function($event) {
                    $event.stopPropagation();
                    $event.preventDefault();

                    $scope.show = !$scope.show;

                    // Emit event
                    $scope.$broadcast("toggle-type", $scope.show);
                };
            }],
            template: '<div class="show-hide-input" ng-transclude></div><a class="password-show toggle-view-anchor" ng-click="toggleType($event)"><span ng-show="show"><i class="fa fa-eye"></i></span><span ng-show="!show"><i class="fa fa-eye"></i></span></a>',
            restrict: 'A',
            replace: false,
            transclude: true
        };
    })


    .directive('showHideInput', function() {
        return {
            scope: {},

            link: function(scope, element, attrs) {
                // listen to event
                scope.$on("toggle-type", function(event, show) {
                    var password_input = element[0],
                        input_type = password_input.getAttribute('type');

                    if (!show) {
                        password_input.setAttribute('type', 'password');
                    }

                    if (show) {
                        password_input.setAttribute('type', 'text');
                    }
                });
            },
            require: '^showHideContainer',
            restrict: 'A',
            replace: false,
            transclude: false
        };
    });

})();
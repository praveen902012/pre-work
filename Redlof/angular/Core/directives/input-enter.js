(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('inputEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if (event.which === 13) {
                    scope.$apply(function() {
                        scope.$eval(attrs.inputEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });

    Directives.directive('clickOff', ['$parse', '$document', function($parse, $document) {
        var dir = {
            compile: function($element, attr) {
                // Parse the expression to be executed
                // whenever someone clicks _off_ this element.
                var fn = $parse(attr.clickOff);
                return function(scope, element, attr) {
                    // add a click handler to the element that
                    // stops the event propagation.
                    element.bind("click", function(event) {
                        event.stopPropagation();
                    });
                    angular.element($document[0].body).bind("click", function(event) {
                        scope.$apply(function() {
                            fn(scope, {
                                $event: event
                            });
                        });

                        $("#search-input").val('');
                    });
                };
            }
        };
        return dir;
    }]);

})();
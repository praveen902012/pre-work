(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('ngReallyClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs, SweetAlert) {
                element.bind('click', function() {
                    var message = attrs.ngReallyMessage;
                    var action = attrs.ngReallyAction;
                    var actiontext = attrs.ngActionText;

                    action = "Yes, " + action + " it!";

                    if (typeof actiontext !== 'undefined') {
                        console.log(actiontext);
                        action = actiontext;
                    }

                    console.log(action);

                    swal({
                        title: "Are you sure?",
                        text: message,
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: action,
                        closeOnConfirm: true
                    }, function() {
                        scope.$apply(attrs.ngReallyClick);
                    });
                });
            }
        };
    }]);

})();
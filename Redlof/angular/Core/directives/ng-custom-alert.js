(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('ngCustomAlertClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs, SweetAlert) {

                element.bind('click', function() {

                    var message = attrs.ngCustomAlertMessage;
                    var action = attrs.ngCustomAlertAction;
                    var actiontext = attrs.ngActionText;
                    var cancletext = attrs.ngCancleText;
                    var titletext = attrs.ngTitleText;

                    action = "Yes, " + action + " it!";

                    if (typeof actiontext !== 'undefined') {
                        action = actiontext;
                    }

                    if (typeof actiontext !== 'undefined') {
                        action = actiontext;
                    }

                    if (typeof titletext !== 'undefined') {
                        titletext = titletext;
                    } else {
                        titletext = 'Are you sure?';
                    }

                    swal({
                        title: titletext,
                        text: message,
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: action,
                        cancelButtonText: cancletext,
                        closeOnConfirm: true
                    }, function() {
                        scope.$apply(attrs.ngCustomAlertClick);
                    });
                });
            }
        };
    }]);

})();
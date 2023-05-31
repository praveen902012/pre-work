(function() {

    'use strict';

    var Filters = angular.module('app.core');

    Filters.filter('labelCase', function($sce) {
            return function(input) {
                input = input.replace(/([A-Z])/g, ' $1');
                return input[0].toUpperCase() + input.slice(1);
            };
        })
        .filter('keyFilter', function() {
            return function(obj, query) {
                var result = {};

                angular.forEach(obj, function(val, key) {
                    if (key !== query) {
                        result[key] = val;
                    }
                });

                return result;
            };
        })
        .filter('unique', function() {
            return function(collection, keyname) {
                var output = [],
                    keys = [];

                angular.forEach(collection, function(item) {
                    var key = item[keyname];
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                    }
                });

                return output;
            };
        })
        .filter('trustUrl', function($sce) {
            return function(url) {
                return $sce.trustAsResourceUrl(url);
            };
        })
        .filter('capitalize', function() {
            return function(input) {
                return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
            };
        })
        .filter('num', function() {
            return function(input) {
                return parseInt(input, 10);
            };
        })
        .filter('stringToDate', function() {
            return function(input) {
                if (!input)
                    return null;

                var date = moment(input);
                return date.isValid() ? date.toDate() : null;
            };
        })
        .filter('hourmin', function() {
            return function(input) {
                return input.slice(0, -3);
            };
        });
})();
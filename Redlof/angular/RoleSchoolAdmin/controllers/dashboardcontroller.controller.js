(function() {

    "use strict";

    angular
        .module('app.role-schooladmin')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast', '$sce'];

    function DashboardController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast, $sce) {

        var vm = this;
        vm.filterData = {};
        vm.admissionCycle = {};
        vm.schoolFilteredData = {};
        vm.inProcess = false;



        function showPieChart(chartData, divId, svgId) {

            d3.select('#' + svgId).remove();
            var height = 400;
            var width = 400;

            var chart = nv.models.pieChart()
                .x(function(d) {
                    return d.label;
                })
                .y(function(d) {
                    return d.value;
                })
                .labelSunbeamLayout(true)
                // .pieLabelsOutside(true)
                .valueFormat(d3.format(".0f"))
                .width(width)
                .height(height)
                .showLabels(false);

            d3.select('#' + divId).append("svg")
                .attr("id", svgId);

            d3.select('#' + svgId)
                .datum(chartData)
                .transition().duration(500)
                .attr('width', width)
                .attr('height', height)
                .call(chart);

            return chart;

        }

        vm.initAdmissionCycle = function() {


            ApiHelper.getData('schooladmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.applySchoolFilter = function(API, formData) {

            ApiHelper.postData(API, formData).then(function(response) {

                vm.schoolFilteredData = response.data;
                showPieChart(response.data.graph_fill_rate, 'studentFill', 'studentFillSvg');
                showPieChart(response.data.rejection_graph, 'rejectionGraph', 'rejectionGraphSvg');

            });


        };

        vm.editSchool = function(API, formData){

            vm.inProcess = true;

            ApiHelper.addItem(API, formData).then(function(response) {

                vm.inProcess = false;

                ServerMessage.show(response.data);
                
            }).catch(function () {
                
                vm.inProcess = false;
            });
        }


    }

})();
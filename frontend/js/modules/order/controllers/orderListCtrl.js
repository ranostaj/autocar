/**
 * Created by ranostajj on 21. 9. 2015.
 */

'use strict';

(function (order_controllers) {

    order_controllers.controller('orderListCtrl', orderListCtrl);

    function orderListCtrl($scope,$mdDialog, orderFactory) {


        var $this = this;
        this.orders = [];
        $this.onPage = 20;
        this.filters = {};
        this.operations = [];
        this.statuses = [];
        this.isLoading = false;

        this.loadOrders = function callServer(tableState) {

            var pagination = tableState.pagination;
            $this.isLoading = true;
            var start = pagination.start || 0;
            var number = pagination.number ||  $this.onPage;
            orderFactory.getAll(start,number,tableState)
                .then(function(result) {
                    tableState.pagination.numberOfPages = result.pages;
                    $this.orders = result.data;
                    $this.total = result.total;
                    $this.operations = result.operations;
                    $this.statuses = result.statuses;
                    $this.isLoading = false;
                })

        }


        /**
         *
         * Copy Order
         * @param $id
         * @param $event
         */
        this.copy = function($id,$event) {
            $event.preventDefault();
            var confirm = $mdDialog.confirm()
                .title('Naozaj chcete kopírovať  ponuku '+$id+'?')
                .ok('Áno')
                .cancel('Nie');
            $mdDialog.show(confirm).then(function() {
                orderFactory.copy($id)
                    .then(function(response){
                        $this.orders.splice(0,0,response);
                    })
            });

        }


        /**
         *
         * @param $id
         * @param $event
         */
        this.deleteItem = function($id,$index,$event) {
            console.log($index);
            $event.preventDefault();
            var confirm = $mdDialog.confirm()
                .title('Naozaj chcete vymazať ponuku '+$id+'?')
                .ok('Áno')
                .cancel('Nie');
            $mdDialog.show(confirm).then(function() {
                orderFactory.deleteOrder($id)
                    .then(function(response){
                        $this.orders.splice($index,1);
                    })
            });
        }


    }

})(angular.module('order.controllers'));
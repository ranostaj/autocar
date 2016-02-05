/**
 * Created by ranostajj on 16. 9. 2015.
 */

'use strict';

(function (app_controllers) {

    app_controllers.controller('homeCtrl',homeCtrl);

    function homeCtrl($scope,$state,orderFactory,$document,$mdToast,orders,ordersPayed) {
       var $this = this;
       this.orders = orders;
       this.ordersPayed = ordersPayed;


        this.goTo = function($id){
            $state.go('orders.add',{id:$id});
        }

        this.confirm = function($order) {
            orderFactory.confirm($order.id).then(function(response){
                angular.forEach($this.ordersPayed, function(item,i){
                    if(item.id == $order.id) {
                        $this.ordersPayed.splice(i,1);
                    }
                })
                $mdToast.show($mdToast.simple()
                    .content('Ponuka bola potvrdená!')
                    .position('right top')
                    .theme('success')
                    .parent($document[0].querySelector('body'))
                    .hideDelay(2000));
            });
        }
    }

})(angular.module('app.controllers'));
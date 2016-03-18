/**
 * App Routers
 */

'use strict';

(function (autocar) {

    autocar.config(function($stateProvider,$urlRouterProvider) {

        var home = {
            url:'/',
            templateUrl: "/templates/home/index",
            controller: "homeCtrl",
            controllerAs:"ctrl",
            resolve: {
                orders: function(orderFactory) {
                    return   orderFactory.getByUser();
                },
                ordersPayed: function(orderFactory){
                    return  orderFactory.getAllPayed();

                }
            }
        }


        var users = {
            url:'/users',

            templateUrl: "/templates/user/list",
            controller: "userListCtrl",
            controllerAs:"ctrl",
            resolve: {
                users: function(userFactory) {
                    return userFactory.getAll();
                }
            }
        }

        var orders_list = {
            url:"/orders",
            templateUrl: "/templates/order/list",
            controller: "orderListCtrl",
            controllerAs: "ctrl"
        }

        var orders_add = {
            url:"/add/:id",
            views: {
                '@': {
                    templateUrl:  "/templates/order/add",
                    controller:"orderCtrl",
                    controllerAs:"ctrl",
                    resolve: {
                        statuses: function (orderFactory) {
                            return orderFactory.getStatuses()
                        },
                        operations: function (orderFactory) {
                            return orderFactory.getOperations()
                        },
                        order: function ($stateParams,orderFactory) {
                            return $stateParams.id ?  orderFactory.get($stateParams.id) : null;
                        }
                    }
                }
            }
        };

        $stateProvider
            .state('home',home)
            .state('orders',orders_list)
            .state('orders.add', orders_add)
            .state('users', users)


        $urlRouterProvider.otherwise('/');

    })
        .config(function($mdThemingProvider) {
            $mdThemingProvider.theme('success')
                .primaryPalette('green')
                .backgroundPalette('green')
        });;


})(angular.module('app.configs'));
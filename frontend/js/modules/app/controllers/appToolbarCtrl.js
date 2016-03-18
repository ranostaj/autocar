/**
 * Created by ranostajj on 16. 9. 2015.
 */

'use strict';

(function (app_controllers) {

    app_controllers.controller('appToolbarCtrl',appToolbarCtrl);


    function appToolbarCtrl($scope,$mdDialog) {


        this.addUser = function($event) {
            $mdDialog.show({
                controller: 'userAddCtrl as ctrl',
                preserveScope: true,
                parent:angular.element(document.body),
                templateUrl: 'templates/user/user_add',
                clickOutsideToClose:true
            });
        }

    }

})(angular.module('app.controllers'));
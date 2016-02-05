/**
 * Created by ranostajj on 16. 9. 2015.
 */

'use strict';

(function (user_controllers) {

    user_controllers.controller('userAddCtrl', userAddCtrl);


    function userAddCtrl($scope,$mdDialog, $state, $timeout, userFactory) {

        var $this = this;
        this.submitted = false;
        this.errors = false;
        this.success = false;
        this.user_data = angular.copy(this.user ? this.user.user : {});
        this.formData = this.user ? this.user.user : {};

        /**
         * Save User data
         */
        this.save = function() {
           if($scope.userAddForm.$valid) {
               userFactory.save(this.formData).then(function(response){
                   $this.success = response.data;
                   $timeout(function(){
                       $this.close($this.success);
                   },3000);
                   $state.go('users');
               }, function(error){
                  $this.errors = error.data.errors;
               });

           } else {
               this.submitted  = true;
           }
        }

        /**
         * Close Modal
         */
        this.close = function($data) {
            $mdDialog.hide($data ? $data : $this.formData);
        }

    }

})(angular.module('user.controllers'));
/**
 *
 */

'use strict';

(function (user_controllers) {

    user_controllers.controller('userEmailCtrl', userEmailCtrl);


    function userEmailCtrl($scope,$mdDialog, $state, $timeout,orderFactory, $sce,order) {

        var $this = this;
        this.submitted = false;
        this.errors = false;
        this.success = false;
        this.formData = {};
        this.order = order ? order : {};
        this.emailPreview = null;
        this.previewMessage = null;


        orderFactory.emailPreview(this.order).then(function(response){
            $this.emailPreview =  $sce.trustAsHtml(response.data.data);
        });

        $scope.$watch('ctrl.formData.message', function(n,o){
            $this.previewMessage = null;
            if(n){
              var string = n.split("\n");
                 $this.previewMessage =   $sce.trustAsHtml(string.join("<br>"));
            };
        })

        /**
         * Save User data
         */
        this.save = function() {
            if($scope.userEmailForm.$valid) {
                orderFactory.sendEmail({order:$this.order,message:$this.formData}).then(function(response){
                    $this.success = "Email bol odoslaný";
                    $timeout(function(){
                        $this.close($this.success);
                    },3000);
                }, function(error){
                    $this.errors = error.statusText;
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
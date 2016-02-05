/**
 * Created by ranostajj on 16. 9. 2015.
 */

'use strict';


(function (user_controllers) {

    user_controllers.controller('userLoginCtrl',userLoginCtrl);

    function userLoginCtrl($scope, userFactory) {

        var $this = this;
        $this.success =false;
        $this.error = false;
        $this.toggler = false;

        this.forgot = function() {
            userFactory.forgot($this.username).
                then(function(response){
                $this.success  = true;
            }, function(error){
                $this.error = true;
            })
        }


        this.toggle = function($event) {
            $event.preventDefault();
            $this.toggler = $this.toggler ? false : true;
        }
    }

})(angular.module('user.controllers'))

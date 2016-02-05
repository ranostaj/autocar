/**
 * Created by ranostajj on 16. 9. 2015.
 */

'use strict';

(function (user_controllers) {

    user_controllers.controller('userListCtrl', userListCtrl);


    function userListCtrl($scope,$mdDialog, $timeout, userFactory, users) {

      var $this = this;
      this.users = users;
      this.success = false;

      this.edit = function($user) {
          $this.success = false;
           $mdDialog.show({
               controller: 'userAddCtrl as ctrl',
               preserveScope: true,
               locals: {
                 user: userFactory.get($user.id)
               },
               parent:angular.element(document.body),
               templateUrl: 'templates/user/user_add',
               bindToController:true,
               clickOutsideToClose:true
           })
               .then(function(response){
                   $this.success = "Užívateľ bol upravený";
                    angular.forEach($this.users, function(user,index){
                        if(response.id === user.id) {
                            $this.users.splice(index,1,response);
                        }
                    })
               });

       }


        /**
         * vymazanie
          * @param $user
         */
        this.confirmDelete = function($user) {
            $this.success = false;
            var confirm = $mdDialog.confirm()
                .title('Naozaj chcete vymazať užívateľa?')
                .ok('Áno')
                .cancel('Nie');

            $mdDialog.show(confirm).then(function() {
                userFactory.remove($user.id).then(function(response){
                    $this.success = "Užívateľ bol vymazaný";
                    angular.forEach($this.users, function(user,index){
                        if($user.id == user.id) {
                            $this.users.splice(index,1);
                        }
                    })
                });
            });


        }

    }

})(angular.module('user.controllers'));
/**
 * Created by ranostajj on 17. 9. 2015.
 */

'use strict';

(function (user_factories) {

    user_factories.factory('userFactory', userFactory);

    function userFactory($http,$mdDialog,$interval,$timeout) {




        var factory = {
            save:save,
            get:get,
            getAll:getAll,
            remove:remove,
            forgot:forgot,
            keepSession:keepSession
        }

        return factory;

        //////////////


        function get($id) {
            return $http.get('api/users/'+$id).then(function(response){
                return response.data
            });
        }

        function remove($id) {
            return $http.delete('api/users/'+$id).then(function(response){
                return response.data
            });
        }

        function getAll($params) {
            return $http.get('api/users/').then(function(response){
                return response.data.rows
            });
        }

        function save($data) {
            if( 'id' in $data) {
                return edit($data.id,$data);
            }
            return $http.post('api/users', $data);
        }


        function edit($id,$data) {
            return $http.put('api/users/'+$id, $data)
        }

        function forgot($data) {
            return $http.post('api/users/forgot', {username:$data})
        }


        /**
         * Keep user logged in
         */
        function keepSession() {
            $http.get('api/users/session');
        }




    }

})(angular.module('user.factories'));
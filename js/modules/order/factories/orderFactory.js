/**
 * Created by ranostajj on 17. 9. 2015.
 */

'use strict';

(function (order_factories) {

    order_factories.factory('orderFactory', orderFactory);

    function orderFactory($http) {

        var factory = {
            save:save,
            get:get,
            getAll:getAll,
            getStatuses: getStatuses,
            getOperations:getOperations,
            deleteAccessory:deleteAccessory,
            deleteFile:deleteFile,
            deleteImage:deleteImage,
            sendEmail:sendEmail,
            deleteOrder: deleteOrder,
            copy:copy,
            getByUser:getByUser,
            getAllPayed:getAllPayed,
            confirm:confirm,
            emailPreview:emailPreview
        }

        return factory;

        //////////////


        function get($id) {
            return $http.get('/api/orders/'+$id).then(function(response){
                var object =  angular.extend(response.data.row,{
                    date_delivery:new Date(response.data.row.date_delivery),
                    date_deposit:response.data.row.date_deposit ? new Date(response.data.row.date_deposit) : null,
                    date_order:response.data.row.date_order ? new Date(response.data.row.date_order) : null
                });
                return object;
            });
        }

        /**
         * Send Email
         * @param $data
         * @returns {*}
         */
        function sendEmail($data) {
            var order = $data.order;
            var email = $data.order.email;
            var message= $data.message;

            return $http.post('/api/orders/email/'+order.id,angular.extend({email:email},message)).then(function(response){
                return response.data.row;
            });
        }

        /**
         * Delete Accessory
         * @param $item
         * @returns {*}
         */
        function deleteAccessory($item){
            return $http.delete('/api/orders/accessory/'+$item.id).then(function(response){
                return response.data.row
            });
        }

        /**
         * Delete Image
         * @param $file
         * @returns {*}
         */
        function deleteImage($file){
            return $http.delete('/api/orders/image/'+$file.id).then(function(response){
                return response.data.row
            });
        }

        /**
         * Delete File
         * @param $file
         * @returns {*}
         */
        function deleteOrder($order){
            return $http.delete('/api/orders/'+$order).then(function(response){
                return response.data.row
            });
        }

        /**
         * Delete File
         * @param $file
         * @returns {*}
         */
        function deleteFile($file){
            return $http.delete('/api/orders/file/'+$file.id).then(function(response){
                return response.data.row
            });
        }

        /**
         * Copy
         * @returns {*}
         */
        function copy($id) {
            return $http.post('/api/orders/copy/'+$id).then(function(response){
                return response.data.row
            });
        }

        /**
         * Statuses
         * @returns {*}
         */
        function getStatuses() {
            return $http.get('/api/orders/statuses').then(function(response){
                return response.data.rows
            });
        }

        /***
         * Get Operations
         * @returns {*}
         */
        function getOperations() {
            return $http.get('/api/orders/operations').then(function(response){
                return response.data.rows
            });
        }

        /**
         * Vsetky zaplatene a nepotvrdene
         * @returns {*}
         */
        function getAllPayed() {
            return $http.get('/api/orders/', {params:{payed:1}}).then(function(response){
              return response.data.rows
            })
        }

        function getAll($start, $number, $params) {

            var tableParams = $params.search.predicateObject.$ != undefined ? $params.search.predicateObject.$ : $params;
            var params = angular.extend( { limit : $number, offset : $start }, tableParams );
            return $http.get('/api/orders/', {params:params}).then(function(response){
                return {
                   data:  response.data.rows,
                   total: response.data.total,
                   operations: response.data.operations,
                   statuses: response.data.statuses,
                   pages: Math.ceil(response.data.total / $number)
                }
            });
        }

        function getByUser() {
            return $http.get('/api/orders/user').then(function(response){
                return response.data.rows
            });
        }

        /**
         * Potvrdenie objednavky
         * @param $id
         * @returns {*}
         */
        function confirm($id) {
            return edit($id,{deposit_confirmed:1});
        }
        /**
         * Save method
         * @param $data
         * @returns {*}
         */
        function save($data) {
           // $data.date_delivery = $data.date_delivery.toISOString().substring(0, 10);
            if( 'id' in $data) {
                return edit($data.id,$data);
            }
            return $http.post('/api/orders', $data);
        }


        function edit($id,$data) {
            return $http.put('/api/orders/'+$id, $data)
        }


        /**
         * Display email version order preview
         * @param $order
         * @returns {*}
         */
        function emailPreview($order) {
            return $http.get('/api/orders/email/'+$order.id);
        }

    }

})(angular.module('order.factories'));
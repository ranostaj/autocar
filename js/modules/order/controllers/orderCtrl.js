/**
 * Created by ranostajj on 21. 9. 2015.
 */

'use strict';

(function (order_controllers) {

    order_controllers.controller('orderCtrl', orderCtrl);

    function orderCtrl($scope,$mdDialog,$state, $filter,Upload,$mdToast,$document,$interval,userFactory, orderFactory,statuses,operations,order) {

        var $this = this;
        this.order = order;
        this.formData = angular.extend( {
            managed_through:"phone",
            total_price:0.00,
            base_price:0.00,
            status_id:1,
            operation_id:1,
            accessories:[],
            images:[],
            files:[],
            date_delivery:new Date()
        },$this.order);


        var formData_default = angular.copy(this.formData);
        this.statuses = statuses;
        this.operations = operations;
        this.success = false;
        this.selected_images = [];
        this.selected_file = false;
        var interval = null;
        interval = $interval(function() {
            userFactory.keepSession();
        },30000);

        $scope.$on('$destroy', function(){
            $interval.cancel(interval);
        });

        $scope.$watch('ctrl.formData.accessories', function(value, old){
            var price  = $this.formData.base_price;
            angular.forEach(value, function(val,indx){
                if(val.price !== undefined && val.price!=0) {
                    price += val.price*val.amount
                }
            });

            $this.formData.total_price = Math.ceil(price*100)/100;
        }, true);


        $scope.$watch('ctrl.formData.base_price', function(value, old){
            console.log( typeof value);
            var val = typeof value === 'number' ? value : 0;
            var old_val = typeof old === 'number' ? old : 0;
            $this.formData.total_price  = Math.ceil( ($this.formData.total_price + (val-old_val)) * 100)/100;
        }, true);


        /**
         * Deposit date
         */
        $scope.$watch('ctrl.formData.partial_price', function(value, old){
              if(value != old) {
                  if(value > 0) {
                      $this.formData.date_deposit =  new Date();
                      $this.date_deposit_changed = true;
                  } else {
                      $this.formData.date_deposit =   null;
                      $this.date_deposit_changed = false;
                  }

              }


        });



        /**
         * Add new Item
         */
        this.itemAdd = function($event) {
            $event.preventDefault();
            var item  = {
                code:"", name:"", amount:1, price:""
            }
            this.formData.accessories.push(item);
        };

        /**
         * Delete Item
         * @param $item
         * @param $event
         */
        this.itemDelete = function($index,$item,$event) {
            $event.preventDefault();
            
            var confirm = $mdDialog.confirm()
                .title('Naozaj chcete vymazať tento doplnok?')
                .ok('Áno')
                .cancel('Nie');

            $mdDialog.show(confirm).then(function() {
                if('id' in $item) {
                    orderFactory.deleteAccessory($item)
                        .then(function (response) {
                            $this.formData.accessories.splice($index, 1);
                        })

                } else {
                    $this.formData.accessories.splice($index, 1);
                }

            });

        };


        /**
         * Save Form
         */
        this.saveForm = function() {
            orderFactory.save(this.formData)
                .then(function(response){
                   var order_id = response.data.row.id;
                   $this.formData.accessories = response.data.row.accessories;

                    // Upload Images
                   if($this.selected_images.length) {
                       Upload.upload({
                           url: '/api/orders/images/' + order_id,
                           data: {files: $this.selected_images}
                       }).success(function (data) {
                           $this.selected_images = [];
                           angular.forEach(data.row, function (file) {
                               $this.formData.images.push(file);
                           });
                       });
                   }

                   // Upload File
                    if($this.selected_file) {
                        Upload.upload({
                            url: '/api/orders/file/' + order_id,
                            data: {file: $this.selected_file}
                        }).success(function (data) {
                            $this.selected_file = {};
                            $this.formData.files.push(data.row);
                        });
                    }


                   $mdToast.show($mdToast.simple()
                        .content('Ponuka bola uložená!')
                        .position('right top')
                        .theme('success')
                        .parent($document[0].querySelector('.footer-toolbar'))
                        .hideDelay(1000)).then(function(){
                        $state.go('orders.add',{id:order_id});
                   });
            })
        }


        this.selectImages = function($files,$event) {
            angular.forEach($files,function(file,index){
                $this.selected_images.push(file);
            })

        }

        /**
         * Select File to upload
         * @param $file
         * @param $event
         */
        this.selectFile = function($file,$event) {
            $this.selected_file = $file;
        }



        /**
         * Delete Single image
         * @param $file
         */
        this.deleteImage = function($image, $event) {
            $event.preventDefault();

            if($image.id) {
                orderFactory.deleteImage($image).then(function(response){
                    $this.formData.images = $filter('filter')($this.formData.images, {id:'!'+$image.id});
                    $mdToast.show($mdToast.simple()
                        .content('Obrázok odstránený')
                        .position('right top')
                        .theme('success')
                        .parent($document[0].querySelector('.footer-toolbar'))
                        .hideDelay(1000));
                });
            } else {

                $this.selected_images.splice($image);

            }

        }


        /**
         * Delete Single File
         * @param $file
         */
        this.deleteFile = function($file) {
            orderFactory.deleteFile($file).then(function(response){
                $this.formData.files = $filter('filter')($this.formData.files, {id:'!'+$file.id});
                $mdToast.show($mdToast.simple()
                    .content('Súbor odstránený')
                    .position('right top')
                    .theme('success')
                    .parent($document[0].querySelector('.footer-toolbar'))
                    .hideDelay(1000));
            })
        }

        /**
         * Create Order
         */
        this.createOrder = function($event) {
            $event.preventDefault();
            orderFactory.save(this.formData)
              .then(function(response) {
                  if (response.data.row.id) {
                      window.open("/orders/generate/" + response.data.row.id, "Objednavka", "toolbar=no, scrollbars=no, resizable=no, location=no, directories=no, top=100, width=800, height=600", true);
                  }
            })
        }


        /**
         *
         * Copy Order
         * @param $id
         * @param $event
         */
        this.copyOrder = function($id,$event) {
            $event.preventDefault();
            var confirm = $mdDialog.confirm()
                .title('Naozaj chcete kopírovať túto ponuku?')
                .ok('Áno')
                .cancel('Nie');
            $mdDialog.show(confirm).then(function() {
                orderFactory.copy($id)
                    .then(function(response){
                        $mdToast.show($mdToast.simple()
                            .content('Ponuka bola skopírovaná!')
                            .position('right top')
                            .theme('success')
                            .parent($document[0].querySelector('.footer-toolbar'))
                            .hideDelay(1000)).then(function(){
                            $state.go('orders.add',{id:response.id});
                        });
                    })
            });


        }

        /**
         * Print Order
         */
        this.printOrder = function($id,$event) {
            $event.preventDefault();
            window.open("/orders/print/" + $id, "Objednavka", "toolbar=no, scrollbars=no, resizable=no, location=no, directories=no, top=20, width=800, height=700", true);
        }

        /**
         * Send Email client
         * @param $data
         */
        this.sendClient = function($event) {
            $event.preventDefault();

            if(!$this.formData.email) {
                var alert = $mdDialog.alert()
                    .title('Chýba email zákazníka')
                    .ok('OK');
                $mdDialog.show(alert);
            } else {

                $mdDialog.show({
                    controller: 'userEmailCtrl',
                    controllerAs: 'ctrl',
                    preserveScope: true,
                    locals: {
                        order: $this.formData
                    },
                    parent:angular.element(document.body),
                    templateUrl: 'templates/user/user_email',
                    clickOutsideToClose:true
                });

            }


        }

        /**
         *
         * @param $id
         * @param $event
         */
        this.deleteItem = function($event) {
            $event.preventDefault();
            if($this.formData.id) {
                var confirm = $mdDialog.confirm()
                    .title('Naozaj chcete vymazať ponuku '+$this.formData.id+'?')
                    .ok('Áno')
                    .cancel('Nie');
                $mdDialog.show(confirm).then(function() {
                    orderFactory.deleteOrder($this.formData.id)
                        .then(function(response){
                            $mdToast.show($mdToast.simple()
                                .content('Ponuka bola vymazaná!')
                                .position('right top')
                                .theme('success')
                                .parent($document[0].querySelector('.footer-toolbar'))
                                .hideDelay(1000)).then(function(){
                                $state.go('orders')
                            });

                      })
                });
            }

        }

    }

})(angular.module('order.controllers'));
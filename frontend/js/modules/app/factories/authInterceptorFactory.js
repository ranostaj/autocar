/*
 *
 * @desc Auth interceptor factory
 *
 */


'user strict';
(function() {

    angular.module( 'app.factories' )
            .factory( 'authInterceptor', authInterceptor );


    function authInterceptor( $q, $location, $window, $timeout, $injector, $rootScope ) {

        var factory = {
            request : request,
            responseError : responseError,
            response : response

        };

        return factory;

        //////////////////////////////


        /**
         * Request
         * @param {type} config
         * @returns {unresolved}
         */
        function request( config ) {


            return config;

        }
        ;


        /**
         * Response Error
         * @param {type} response
         * @returns {unresolved}
         */
        function responseError( response ) {

            if ( response.status == 403 || response.status == 401 ) {
                $timeout(function(){
                    var $mdDialog =  $injector.get('$mdDialog');
                    var alert = $mdDialog.alert()
                        .title('Odhlásenie')
                        .content('<ng-md-icon icon="lock"></ng-md-icon> Pre nečinnosť ste boli odhlásený zo systému')
                        .ok('Prihlásiť znova');
                    $mdDialog.show(alert).then(function(e){
                        $window.location.href= '/';
                    });
                })

            } else {
                $timeout(function(){
                    var $mdDialog =  $injector.get('$mdDialog');
                    var alert = $mdDialog.alert()
                        .title(response.statusText+ " "+ response.status)
                        .content('<ng-md-icon icon="warning"></ng-md-icon> '+response.data.message.message)
                        .ok('Skúste znova');
                    $mdDialog.show(alert);
                })

            }

            return $q.reject( response );

        }
        ;

        /**
         * Response
         * @param {type} response
         * @returns {unresolved}
         */
        function response( response ) {

            return response;
        }
    }


})();
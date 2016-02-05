/**
 * Created by ranostajj on 6. 10. 2015.
 */

'use strict';

(function (app) {

    app.config(function($httpProvider){
        $httpProvider.interceptors.push('authInterceptor');
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    })


})(angular.module('app.configs'));
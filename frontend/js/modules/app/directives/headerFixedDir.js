/**
 * Created by ranostajj on 24. 9. 2015.
 */

'use strict';

(function (app_directives,$window) {

    app_directives.directive('headerFixed', headerFixed);

    function headerFixed() {
        return {

            link:function(scope, ele, attr, ctrl){
                angular.element($window).bind("scroll", function() {
                    if(this.pageYOffset > 100) {
                        ele.addClass('fixed')
                    } else {
                        ele.removeClass('fixed')
                    }
                })
            }
        };
    }

})(angular.module('app.directives'),window);
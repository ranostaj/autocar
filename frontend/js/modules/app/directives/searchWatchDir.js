/**
 * Created by ranostajj on 24. 9. 2015.
 */

'use strict';

(function (app_directives) {

    app_directives.directive('searchWatchModel', searchWatchModel);

    function searchWatchModel() {
        return {
            require:'^stTable',
            scope:{
                searchWatchModel:'='
            },
            link:function(scope, ele, attr, ctrl){
                scope.$watch('searchWatchModel',function(val){
                    ctrl.search(val);
                },true);

            }
        };
    }

})(angular.module('app.directives'));
/**
 * autocar main JS
 */

angular.module('core', ['ngMaterial','ngMessages','smart-table', 'ngFileUpload', 'ngMdIcons', 'angular-loading-bar']);

angular.module('app.controllers', []);
angular.module('app.directives', []);
angular.module('app.factories', []);
angular.module('app.configs', ['ui.router']);
angular.module('app', [ 'app.controllers', 'app.configs', 'app.directives', 'app.factories']);


angular.module('order.controllers', []);
angular.module('order.factories', []);
angular.module('order', ['order.controllers','order.factories']);

angular.module('user.controllers', []);
angular.module('user.factories', []);
angular.module('user', ['user.controllers', 'user.factories']);

angular.module('autocar', ['core','app', 'user', 'order']);

<!DOCTYPE html>
<html ng-app="autocar">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('loading-bar.css') ?>
    <?= $this->Html->css('main.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

<div class="container" layout="column" >
    <?php echo $this->fetch('header') ?>
    <md-content  layout-padding class="content">
        <?php echo $this->fetch('content') ?>
    </md-content>
    <?php echo $this->fetch('footer') ?>
</div>

    <script src="/js/libs/angular/angular.min.js" ></script>
    <script src="/js/libs/angular-ui-router/release/angular-ui-router.js" ></script>
    <script src="/js/libs/angular-animate/angular-animate.min.js" ></script>
    <script src="/js/libs/angular-loading-bar/src/loading-bar.js"></script>
    <script src="/js/libs/angular-aria/angular-aria.min.js" ></script>
    <script src="/js/libs/angular-smart-table/dist/smart-table.min.js"></script>
    <script src="/js/libs/angular-material-icons/angular-material-icons.min.js" ></script>
    <script src="/js/libs/angular-material/angular-material.min.js" ></script>
    <script src="/js/libs/angular-messages/angular-messages.min.js" ></script>
    <script src="/js/libs/ng-file-upload/ng-file-upload.min.js" ></script>
    <script src="/js/main.js" ></script>
    <script src="/js/modules/app/controllers/appToolbarCtrl.js" ></script>
    <script src="/js/modules/app/controllers/homeCtrl.js" ></script>
    <script src="/js/modules/app/configs/routerConfig.js" ></script>
    <script src="/js/modules/app/configs/httpConfig.js" ></script>
    <script src="/js/modules/app/factories/authInterceptorFactory.js" ></script>
    <script src="/js/modules/app/directives/searchWatchDir.js"></script>
    <script src="/js/modules/app/directives/headerFixedDir.js"></script>
    <script src="/js/modules/user/controllers/userLoginCtrl.js" ></script>
    <script src="/js/modules/user/controllers/userAddCtrl.js" ></script>
    <script src="/js/modules/user/controllers/userListCtrl.js" ></script>
    <script src="/js/modules/user/controllers/userEmailCtrl.js" ></script>
    <script src="/js/modules/user/factories/userFactory.js" ></script>
<script src="/js/modules/order/controllers/orderCtrl.js" ></script>
<script src="/js/modules/order/controllers/orderListCtrl.js" ></script>
<script src="/js/modules/order/factories/orderFactory.js" ></script>
</body>
</html>

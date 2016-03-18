<div layout="column"  >
    <md-content layout-padding >



        <h2>Zoznam užívatelov</h2>

        <div class="alert alert-success" ng-if="ctrl.success">
            {{ctrl.success}}
        </div>


        <div class="pull-right">

        </div>


        <div class="clear" style="clear:both"></div>
            <div layout="row" layout-sm="column" layout-wrap >

                <md-card flex="50" flex-md="25"    flex-gt-md="20"  flex-sm="100" style="background: #fff;" ng-repeat="user in ctrl.users">

                    <md-toolbar>
                        <h4 class="md-toolbar-tools">{{user.name}}</h4>
                    </md-toolbar>
                        <md-card-content>
                            <p>
                                Email: {{user.username}} <br>
                                Rola: {{user.role}}
                            </p>
                        </md-card-content>
                        <md-card-footer layout="row"  layout="end center">
                            <?php if($auth['role'] == 'admin') : ?>
                                    <div flex></div>
                                    <md-button    ng-click="ctrl.edit(user)"  class="md-primary">Uprav</md-button>
                                    <md-button  ng-if="user.id != <?php echo $auth['id'] ?> "   ng-click="ctrl.confirmDelete(user)"  class=" md-warn">vymaz</md-button>

                            <?php endif; ?>
                        </md-card-footer>


                </md-card>


            </div>


    </md-content>
</div>
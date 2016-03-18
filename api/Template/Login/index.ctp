<div ng-controller="userLoginCtrl as ctrl" layout="row" layout-align="center center" >
    <div flex="30">
    <md-card>
        <md-card-content>

            <?php echo $this->Form->create(null, ['url'=>['controller'=>'Login', 'action'=>'login'], 'name'=>"LoginForm"]); ?>
            <h1 class="md-display-1">
                <ng-md-icon icon="lock"></ng-md-icon>
                Prihlásenie
            </h1>
            <?php echo  $this->Flash->render('auth') ?>
            <md-input-container>
                <label>Meno</label>
                <input   name="username" ng-model="ctrl.username" required type="text" />
            </md-input-container>
            <md-input-container>
                <label>Heslo</label>
                <input type="password" required name="password" />
            </md-input-container>
            <md-input-container layout="row">
                <md-button ng-click="ctrl.toggle($event)" flex class="md-raised">
                    <span>
                         <ng-md-icon icon="perm_identity"></ng-md-icon> Zabudol som heslo
                    </span>
                </md-button>
                <md-button flex class="md-raised md-primary">
                    <span>
                          <ng-md-icon icon="login"></ng-md-icon>
                        Prihlásiť
                    </span>
                </md-button>
            </md-input-container>
            <?php echo $this->Form->end() ?>
        </md-card-content>
   </md-card>

            <md-card class="forgot" ng-if="ctrl.toggler">
            <md-card-content>




                <div class="alert alert-success" ng-if="ctrl.success"  >
                    <h3> <ng-md-icon icon="check"></ng-md-icon>  Nové heslo bolo vygenerované</h3>
                    Heslo bolo odoslané na e-mail,
                    zmenu hesla musíte potvrdiť kliknutím na odkaz v e-mailovej správe.
                </div>

                <div ng-if="!ctrl.success">
                    <h3>
                        <ng-md-icon icon="perm_identity"></ng-md-icon>
                        Vygenerovanie nového hesla
                    </h3>
                    <div class="alert alert-danger" ng-if="ctrl.error">
                        <ng-md-icon icon="report_problem"></ng-md-icon>  Neplatný email
                    </div>
                <md-input-container>
                    <label>Zadajte e-mail</label>
                    <input  name="username" ng-model="ctrl.username" required type="email" />
                </md-input-container>
                <md-input-container layout="row">
                   <div flex="50"></div>
                    <md-button ng-click="ctrl.forgot()" flex class="md-raised md-primary">
                    <span>
                        Odoslať
                    </span>
                    </md-button>
                </md-input-container>
                </div>
                </md-card-content>
            </md-card>
    </div>
</div>
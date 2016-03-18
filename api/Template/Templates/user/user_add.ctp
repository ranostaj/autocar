
<md-dialog flex="50">
    <md-toolbar class="md-primary">
        <h1 class="md-toolbar-tools" ng-if="!ctrl.user_data.id">
           Pridaj uzivatela
        </h1>
        <h1 class="md-toolbar-tools" ng-if="ctrl.user_data.id">
            Uprav:  {{::ctrl.user_data.name}}
        </h1>
    </md-toolbar>
        <md-dialog-content  >
            <div class="alert alert-danger" ng-if="ctrl.errors">
                <span ng-repeat="error in ctrl.errors">
                    {{error}}
                </span>

            </div>
            <div class="alert alert-success" ng-if="ctrl.success">
                <h3>Užívateľ bol uložený</h3>

                meno: {{ctrl.success.user.name}} <br>
                e-mail: {{ctrl.success.user.username}}
            </div>

            <form name="userAddForm" ng-show="!ctrl.success">

            <md-input-container>
                <label>Meno</label>
                <input type="text" required name="name" ng-model="ctrl.formData.name">
                <div ng-messages="userAddForm.name.$error" ng-show="ctrl.submitted">
                    <div ng-message="required">  Vyplnte meno</div>
                </div>

            </md-input-container>

                <md-input-container>
                    <label>Email (prihlasovacie meno):</label>
                    <input type="email" email required name="username" ng-model="ctrl.formData.username">
                    <div ng-messages="userAddForm.username.$error" ng-show="ctrl.submitted">
                        <div ng-message="required">  Vyplnte prihlasovacie meno (email)</div>
                        <div ng-message="email">  Neplatný e-mail</div>
                    </div>

                </md-input-container>

                <md-input-container>
                    <label>Typ konta:</label>
                    <md-select required  name="role" ng-model="ctrl.formData.role">
                        <md-option  value="admin">Admin</md-option>
                        <md-option  value="user">Užívateľ</md-option>
                    </md-select>
                    <div ng-messages="userAddForm.role.$error" ng-show="ctrl.submitted">
                        <div ng-message="required"> Vyberte typ kont</div>
                    </div>

                </md-input-container>

                <md-input-container ng-if="ctrl.formData.id">
                    <label>Heslo:</label>
                    <input type="text" minlength="8"   name="password" ng-model="ctrl.formData.password">
                    <div ng-messages="userAddForm.password.$error" ng-show="ctrl.submitted">
                        <div ng-message="minlength">Heslo musí mať minimálne 8 znakov</div>
                    </div>
                </md-input-container>

                <md-input-container ng-if="!ctrl.formData.id">
                    <label>Heslo:</label>
                    <input type="text" minlength="8" required name="password" ng-model="ctrl.formData.password">
                    <div ng-messages="userAddForm.password.$error" ng-show="ctrl.submitted">
                        <div ng-message="required">Vyplnte heslo</div>
                        <div ng-message="minlength">Heslo musí mať minimálne 8 znakov</div>
                    </div>
                </md-input-container>
            </form>
        </md-dialog-content>

        <div class="md-actions" layout="row">
        <span flex></span>
        <md-button class="md-raised md-warn"    ng-click="ctrl.close()">Zavri</md-button>
        <md-button class="md-raised md-primary" ng-click="ctrl.save()" ng-if="!ctrl.success" >
           Ulož
        </md-button>

    </div>
</md-dialog>

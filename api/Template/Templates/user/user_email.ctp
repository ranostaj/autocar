
<md-dialog flex="50">
    <md-toolbar class="md-primary">
        <h1 class="md-toolbar-tools">
            Poslať email zákazníkovi
        </h1>
    </md-toolbar>
    <md-dialog-content>

        <div class="alert alert-danger" ng-if="ctrl.errors">
            {{ctrl.errors}}
        </div>
        <div class="alert alert-success" ng-if="ctrl.success">
            <h3>E-mail bol odoslaný</h3>
        </div>

        <form name="userEmailForm" ng-show="!ctrl.success">
            <md-input-container>

               <div>
                   Odosielateľ:
                   {{ctrl.order.user.username}}
               </div>
            </md-input-container>

            <md-input-container>

                <div>
                     Adresát:
                    {{ctrl.order.email}}
                </div>
            </md-input-container>

            <md-input-container>
                <label>Predmet správy:</label>
                <input type="text" email required name="subject" ng-model="ctrl.formData.subject">
                <div ng-messages="userEmailForm.subject.$error" ng-show="ctrl.submitted">
                    <div ng-message="required">Vyplnte predmet správy</div>
                </div>
            </md-input-container>

            <md-input-container>
                <label>Správa</label>
                <textarea type="text"  rows="4" name="message" ng-model="ctrl.formData.message"></textarea>
                <div ng-messages="userEmailForm.message.$error" ng-show="ctrl.submitted">
                    <div ng-message="required">Vyplnte správu</div>
                </div>
            </md-input-container>
        </form>
    </md-dialog-content>

    <div class="md-actions" layout="row">
        <span flex></span>
        <md-button class="md-raised md-warn"    ng-click="ctrl.close()">Zavrieť</md-button>
        <md-button class="md-raised md-primary" ng-click="ctrl.save()" ng-if="!ctrl.success" >
            Odoslať
        </md-button>
    </div>
</md-dialog>

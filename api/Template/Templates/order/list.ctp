<div layout="column"  >
    <md-content layout-padding >



        <h2>Zoznam ponúk</h2>

        <div class="pull-right">
            Celkovo {{ctrl.total}} ponúk
        </div>
        <div style="clear:both"></div>

        <div class="order-filters md-whiteframe-2dp" >
            <div layout="row" class="order-filters-row">
            <div flex layout="column"  >
                <div flex>
                    <strong>Prevádzka</strong>
                </div>

                <div flex  layout="row" >
                    <md-checkbox flex ng-repeat="operation in ctrl.operations" ng-model="ctrl.filters.operation[operation.id]" aria-label=" {{operation.name}}">
                       {{operation.name}}
                    </md-checkbox>
                </div>
            </div>
            <div flex layout="column"  class="border-left" >
                <div flex>
                    <strong>Zobraziť stav</strong>
                </div>

                <div flex  layout="row" >
                    <md-checkbox flex ng-repeat="status in ctrl.statuses" ng-model="ctrl.filters.status[status.id]" aria-label=" {{status.name}}">
                        {{status.name}}
                    </md-checkbox>
                </div>
            </div>

            <div flex layout="column"  class="border-left" >

                <div flex >
                    <strong>Globálne vyhľadávanie</strong>
                    <input type="text"   placeholder="Zadajte kľúčové slovo..."   ng-model="ctrl.filters.global" class="search" name="search" type="search" />
                </div>
            </div>
            </div>
            <div layout="row" class="order-filters-row last-row">

                <div flex layout="column">
                    <div flex>
                        <strong>Dátum vytvorenia  </strong>
                    </div>
                    <div flex layout="row">
                    <div flex>
                        od:
                        <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.created.from" />
                    </div>
                        <div flex>
                           do: <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.created.to" />
                        </div>
                    </div>
                </div>

                <div flex layout="column">
                    <div flex>
                        <strong>Dátum dodania </strong>
                    </div>
                    <div flex layout="row">
                        <div flex>
                            od: <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.date_delivery.from" />
                        </div>
                        <div flex>
                           do: <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.date_delivery.to" />
                        </div>
                    </div>
                </div>

                <div flex layout="column">
                    <div flex>
                        <strong>Dátum vytvorenia objednávky </strong>
                    </div>
                    <div flex layout="row">
                        <div flex>
                            od: <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.date_order.from" />
                        </div>
                        <div flex>
                            do: <input type="date" md-placeholder="Dátum od" ng-model="ctrl.filters.date.date_order.do" />
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="alert alert-info" ng-if="ctrl.orders.length == 0 && ctrl.isLoading == false">
            <p >
               <ng-md-icon icon="warning"></ng-md-icon>
                <span ng-if="ctrl.filters">
                     K zvoleným filtrom neboli nájtené žiadne ponuky
                </span>
                 <span ng-if="!ctrl.filters">
                     Neboli nájtené žiadne ponuky
                </span>

            </p>
        </div>

        <table    st-table="ctrl.orders" st-pipe="ctrl.loadOrders" class="table table-hover">
            <thead ng-show="ctrl.orders.length"  search-watch-model="ctrl.filters">
            <tr  >
                <th>#</th>
                <th>Meno zákazníka</th>
                <th>Typ prívesu</th>
                <th>Dátum vyhotovenia</th>
                <th>Dátum zálohy</th>
                <th>Vyplatená záloh.</th>
                <th>Dátum dodania</th>
                <th>E-mail zákazníka</th>
                <th>Telefón</th>
                <th>Vystavil</th>
                <th>Číslo Faktúry</th>
                <th>Prevádzka</th>
                <th>Stav</th>

                <th>Kopíruj</th>
                <th>Vymazať</th>
            </tr>
            </thead>

            <tbody>
            <tr class="tr-hover"  ng-repeat="order in ctrl.orders" ng-class="{'tr-green' : order.status_id==2, 'tr-red': order.status_id==3,  'tr-yellow': order.status_id==1 }"  >
                <td ui-sref="orders.add({id:order.id})">{{order.id}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.customer}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.typ}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.created | date: 'd.MM yyyy'}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.date_deposit | date: 'd.MM yyyy'}}</td>
                <td ui-sref="orders.add({id:order.id})">
                    <ng-md-icon  ng-if="!order.deposit_pay" icon="radio_button_off"></ng-md-icon>
                    <ng-md-icon ng-if="order.deposit_pay" style="fill:green"   icon="radio_button_on"></ng-md-icon>

                </td>
                <td ui-sref="orders.add({id:order.id})">{{order.date_delivery | date: 'd.MM yyyy'}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.email}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.phone}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.user.name}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.invoice}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.operation.name}}</td>
                <td ui-sref="orders.add({id:order.id})">{{order.status.name}}</td>
                <td>
                        <ng-md-icon title="Kopíruj ponuku {{order.id}}" ng-click="ctrl.copy(order.id,$event)" icon="content_copy"></ng-md-icon>
                   </td>
                <td align="center">

                        <ng-md-icon style="fill:red" title="Vymaž ponuku {{order.id}}"  ng-click="ctrl.deleteItem(order.id,$index,$event)" icon="cancel"></ng-md-icon>

                </td>
            </tr>
            </tbody>
            <tbody ng-show="ctrl.isLoading">
            <tr>
               <td colspan="14" class="text-center">Loading ... </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td class="text-center" st-pagination="" st-items-by-page="ctrl.onPage" colspan="14">
                </td>
            </tr>
            </tfoot>
        </table>
    </md-content>
</div>
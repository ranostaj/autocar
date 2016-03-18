<div layout="column" >
   <md-content layout-padding >
   <h2>Vitaj <?php echo $auth['name'] ?></h2>




        <div  layout-md layout="row" layout-wrap >


            <md-card  flex  flex-md="100" flex-sm="100">

                <md-card-content>
                    <h2  class="md-title">Moje posledné ponuky ({{ctrl.orders.length}})</h2>
                    <table   class="table table-hover">
                        <thead  >
                        <tr  >
                            <th>#</th>
                            <th>Meno zákazníka</th>
                            <th>Typ prívesu</th>
                            <th>Dátum vyhotovenia</th>

                            <th>Dátum dodania</th>
                            <th>E-mail zákazníka</th>
                            <th>Telefón</th>


                            <th>Prevádzka</th>
                            <th>Stav</th>

                        </tr>
                        </thead>

                        <tbody>
                        <tr class="tr-hover"  ng-repeat="order in ctrl.orders" ng-class="{'tr-green' : order.status_id==2, 'tr-red': order.status_id==3,  'tr-yellow': order.status_id==1 }"  >
                            <td ui-sref="orders.add({id:order.id})">{{order.id}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.customer}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.typ}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.created | date: 'd.MM yyyy'}}</td>

                            <td ui-sref="orders.add({id:order.id})">{{order.date_delivery | date: 'd.MM yyyy'}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.email}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.phone}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.operation.name}}</td>
                            <td ui-sref="orders.add({id:order.id})">{{order.status.name}}</td>


                        </tr>
                        </tbody>

                    </table>

                </md-card-content>
            </md-card>
            <md-card flex="30" flex-md="100" flex-sm="100" >
                <md-card-content>
                    <h2  class="md-title">Chyby, návrhy, pripomienky</h2>
                     <p>
                         Všetky bugy, chyby, návrhy prosíme zadávať do <a href="https://www.producteev.com">https://www.producteev.com</a> kde je
                         nato vytvorený samostatný projekt <a href="https://www.producteev.com"><strong>Autocar Bug list</strong></a>

                     </p>
                </md-card-content>
            </md-card>
        </div>

  </md-content>
</div>
<form name="addOrderForm" ng-submit="ctrl.saveForm()">
<div class="order-add"   layout="column">

    <div  flex offset="5" >
        <h2 class="md-display-1 text-accent">
            <span ng-if="ctrl.formData.id">
                Ponuka číslo {{ctrl.formData.id}}
            </span>
             <span ng-if="!ctrl.formData.id">
                Nová ponuka
            </span>
        </h2>
    </div>


    <div layout="row" flex    offset="5">

        <div flex layout="column" >

            <h4>Údaje o zákazníkovi</h4>
            <div  layout="row" >
                <div flex>

                    <md-input-container class="md-input-white "  >
                        <label>Meno zákazníka *</label>
                        <input   name="customer"  ng-model="ctrl.formData.customer"  required type="text"   />
                        <div ng-messages="addOrderForm.customer.$error" ng-show="addOrderForm.customer.$dirty" >
                            <div ng-message="required">Vyplnte meno zákazníka!</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>Ulica</label>
                        <input   name="street"  ng-model="ctrl.formData.street"     type="text"   />

                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>E-mail</label>
                        <input   name="email"   ng-model="ctrl.formData.email"   type="email"   />
                        <div ng-messages="addOrderForm.email.$error"  ng-show="addOrderForm.email.$dirty"  >
                            <div ng-message="email">Neplatný email!</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>Telefón *</label>
                        <input   name="phone"   ng-model="ctrl.formData.phone"  required type="text"   />
                        <div ng-messages="addOrderForm.phone.$error"   ng-show="addOrderForm.phone.$dirty"  >
                            <div ng-message="required">Vyplnte Telefón!</div>
                        </div>
                    </md-input-container>


                </div>
                <div flex offset="5">

                    <md-input-container class="md-input-white">
                        <label>Názov firmy</label>
                        <input  name="companny"  ng-model="ctrl.formData.companny"     type="text"   />

                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>Mesto a PSČ</label>
                        <input   name="address"  ng-model="ctrl.formData.address"    type="text"   />
                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>ičo / číslo OP</label>
                        <input   name="ico"  ng-model="ctrl.formData.ico"   type="text"   />

                    </md-input-container>

                    <md-input-container class="md-input-white">
                        <label>IČ DPH</label>
                        <input    name="ic_dph"  ng-model="ctrl.formData.ic_dph"    type="text"   />

                    </md-input-container>

                </div>
            </div>
            <div layout="row"  >
                <hr flex />
            </div>
            <h4>Typ vozíka a cena</h4>
            <div layout="row" >
                <div flex>
                    <md-input-container class="md-input-white">
                        <label>Typ prívesného vozíka *</label>
                        <input   name="typ"   ng-model="ctrl.formData.typ"  required type="text"   />
                        <div ng-messages="addOrderForm.typ.$error" ng-show="addOrderForm.typ.$dirty"  >
                            <div ng-message="required">Vyplnte typ prívesného vozíka!</div>
                        </div>
                    </md-input-container>
                </div>

                <div flex offset="5">
                    <md-input-container class="md-input-white">
                        <label>Základná cena vozíka s DPH *</label>
                        <input   name="base_price"  ng-model="ctrl.formData.base_price"   ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/"   required type="number"   />
                        <div ng-messages="addOrderForm.base_price.$error" ng-show="addOrderForm.base_price.$dirty"  >
                            <div ng-message="required">Vyplnte cenu vozíka!</div>
                        </div>
                    </md-input-container>
                </div>


            </div>
            <div layout="row"  >
                <hr flex />
            </div>
            <h4>VIN vozíka a nákupná cena</h4>
            <div layout="row" >
                <div flex>
                    <md-input-container class="md-input-white">
                        <label>VIN kód </label>
                        <input   name="vin"   ng-model="ctrl.formData.vin"    type="text"   />
                    </md-input-container>
                </div>

                <div flex offset="5">
                    <md-input-container class="md-input-white">
                        <label>Nákupná  cena s DPH</label>
                        <input   name="purchase_price"  ng-model="ctrl.formData.purchase_price"   ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/"     type="number"   />
                        <div ng-messages="addOrderForm.purchase_price.$error" ng-show="addOrderForm.purchase_price.$dirty"  >
                            <div ng-message="required">Vyplnte cenu vozíka!</div>
                        </div>
                    </md-input-container>
                </div>


            </div>

            <div layout="row"  >
                <hr flex />
            </div>
            <h4>Popis</h4>
            <div layout="column" >
                <div flex>
                    <md-input-container class="md-input-white">
                        <label>Popis prívesného vozíka *</label>
                        <textarea rows="5"  name="description" required  ng-model="ctrl.formData.description"   ></textarea>
                    </md-input-container>
                </div>



            </div>
            <div layout="row"  >
                <hr flex />
            </div>

            <div layout="row">
                <div flex >
                    <h4>Záloha</h4>
                </div>
                <div flex layout="row">
                    <div flex style="text-align: right">
                        <strong style="line-height: 53px;">Vyplatená záloha:</strong>
                    </div>
                    <div flex  >
                    <md-radio-group class="md-input-white" ng-model="ctrl.formData.deposit_pay" layout="row">
                        <md-radio-button value="1"  >Áno</md-radio-button>
                        <md-radio-button value="0"  >Nie</md-radio-button>
                    </md-radio-group>
                    </div>
                </div>

            </div>
            <div layout="row">

                <div flex   >
                    <md-input-container class="md-input-white">
                        <label>Vyplatená záloha (Eur s DPH)</label>
                        <input   name="partial_price"  ng-model="ctrl.formData.partial_price" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01"    type="number"   />
                        <div ng-messages="addOrderForm.partial_price.$error" ng-show="addOrderForm.partial_price.$dirty"  >
                            <div ng-message="required">Vyplnte zálohu!</div>
                            <div ng-message="pattern">Neplatna cena!</div>
                        </div>
                    </md-input-container>
                </div>

                <div flex   offset="5" style="position: relative"  >
                    <span ng-if="ctrl.date_deposit_changed" style="position: absolute; font-size: 11px; color: #ff4081;; top:-20px;">
                       Dátum zálohy nastavený na dnešný
                    </span>
                    <label>Dátum zálohy</label>
                    <div class="input-date-wrap">
                        <ng-md-icon icon="today"></ng-md-icon>
                        <input type="date" class="input-date"  ng-model="ctrl.formData.date_deposit" />
                    </div>

                </div>

                <div flex  offset="5" >
                    <md-input-container class="md-input-white">
                        <label>Číslo faktúry </label>
                        <input  name="invoice"  ng-model="ctrl.formData.invoice"     type="text"   />

                    </md-input-container>
                </div>

            </div>



            <div layout="row"  >
            <hr flex />
            </div>

            <h4>Dátumy</h4>
            <div layout="row">
                <div flex>

                    <div class="input-fake input-fake-white">
                        <label>Dátum vytvorenia ponuky</label>
                        <p>
                            <ng-md-icon icon="today"></ng-md-icon>
                            {{::ctrl.formData.created | date:'dd. MMM. yyyy'}}
                        </p>
                    </div>


                </div>
                <div flex offset="5">

                    <div class="input-fake input-fake-white">
                        <label>Dátum vytvorenia objednávky</label>

                        <p  > <ng-md-icon icon="today"></ng-md-icon> {{::ctrl.formData.date_order | date:'dd. MMM. yyyy'}}</p>
                    </div>


                </div>
                <div flex offset="5">
                    <label>Dátum dodania</label>
                    <div class="input-date-wrap">
                        <ng-md-icon icon="today"></ng-md-icon>
                        <input type="date" class="input-date"  ng-model="ctrl.formData.date_delivery" />
                    </div>
                </div>
            </div>
            <div layout="row"  >
                <hr flex />
            </div>
            <div   layout="row" layout-align="end start"  >
            <h4 flex  >Doplnky ({{ctrl.formData.accessories.length}} ks)</h4>
            <md-button  flex="20"  style="margin:0" ng-if="!ctrl.formData.accessories.length" ng-click="ctrl.itemAdd($event)" class="md-raised md-primary md-button">
                <ng-md-icon icon="add"></ng-md-icon>  Pridaj doplnok
            </md-button>
            </div>
            <div   ng-if="ctrl.formData.accessories.length"  layout="row" layout-align="end start">
                <table cellpadding="0" cellspacing="0" class="table table-condensed table-bordered">
                    <thead>


                    <tr>
                        <th >#</th>
                        <th>Kód</th>
                        <th>Názov</th>
                        <th >Ks</th>
                        <th  >Cena</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="item in ctrl.formData.accessories">
                        <td>{{$index+1}}</td>
                        <td><input autofocus="true" required ng-model="item.code" type="text" ></td>
                        <td><input ng-model="item.name" required type="text" ></td>
                        <td><input ng-model="item.amount" min="1" required type="number" ></td>
                        <td>
                            <input ng-model="item.price"  ng-value="0.00"  required type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01"  >

                        </td>
                        <td><md-button ng-click="ctrl.itemDelete($index,item, $event)" class="md-raised  md-button md-hue-1">Vymaž</md-button></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" align="right">
                            <md-button ng-click="ctrl.itemAdd($event)" class="md-raised md-primary md-button">
                                <ng-md-icon icon="add"></ng-md-icon>   Pridaj doplnok
                            </md-button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>



            <div layout="row" layout-align="end start">
                <div flex  ></div>
                <div flex="60" layout="column"     >
                    <div flex><h2 style="text-align: right"> {{ctrl.formData.total_price}} Eur</h2></div>
                    <div flex style="text-align: right">Celková cena (Eur s DPH)</div>
                </div>
            </div>


        </div>
        <div flex="40" offset="5" class="order-sidebar" layout-padding >

            <md-card>
                <md-card-content>
                    <h4><ng-md-icon icon="swap_horiz"></ng-md-icon> Ponuka vybavená cez</h4>
            <md-radio-group ng-model="ctrl.formData.managed_through" layout="row">
                <md-radio-button value="phone" >Telefón</md-radio-button>
                <md-radio-button value="email">Email </md-radio-button>
                <md-radio-button value="print">Odovzdaná v tlač.</md-radio-button>
            </md-radio-group>
                </md-card-content>
            </md-card>

            <md-card>
                <md-card-content>
                    <h4> <ng-md-icon icon="local_offer"></ng-md-icon> Status ponuky</h4>
                    <md-radio-group ng-model="ctrl.formData.status_id" layout="row">
                        <md-radio-button value="{{status.id}}" ng-repeat="status in ctrl.statuses" >{{status.name}}</md-radio-button>
                    </md-radio-group>
                </md-card-content>
            </md-card>

            <md-card>
                <md-card-content>
                    <h4><ng-md-icon icon="public"></ng-md-icon> Prevádzka</h4>
                    <md-radio-group ng-model="ctrl.formData.operation_id" layout="row">
                        <md-radio-button value="{{operation.id}}" ng-repeat="operation in ctrl.operations" >{{operation.name}}</md-radio-button>
                    </md-radio-group>
                </md-card-content>
            </md-card>


            <md-card>
                <md-card-content>
                    <h4> <ng-md-icon icon="insert_drive_file"></ng-md-icon> Vyplatená záloha</h4>
                    <md-radio-group class="md-input-white" ng-model="ctrl.formData.deposit_pay" layout="row">
                        <md-radio-button value="1"  >Áno</md-radio-button>
                        <md-radio-button value="0"  >Nie</md-radio-button>
                    </md-radio-group>
                </md-card-content>
            </md-card>



            <md-card>
                <md-card-content>
                    <h4> <ng-md-icon icon="info"></ng-md-icon> Interná informácia</h4>
            <md-input-container class="md-input-white">
                <textarea rows="3"  ng-model="ctrl.formData.internal_info"  name="internal_info" ></textarea>
            </md-input-container>
                </md-card-content>
            </md-card>

            <md-card>
                <md-card-content>
                    <h4><ng-md-icon icon="photo"></ng-md-icon> Pridané fotografie </h4>
                    <div class="gallery" layout="row" layout-align="start start" layout-wrap="true">
                        <div flex="30"   ng-repeat="image in ctrl.formData.images">
                            <img    ng-src="/img/images/{{image.name}}" />
                            <md-button class="md-button md-warn" ng-click="ctrl.deleteImage(image, $event)" >
                                 Vymazať
                                <ng-md-icon class="md-secondary"  icon="highlight_remove" style="margin-top: 5px;fill:red" size="16">
                                </ng-md-icon>
                            </md-button>


                        </div>
                        <div flex="30" ng-repeat="image in ctrl.selected_images"  ng-if="ctrl.selected_images">
                            <img   ngf-src="image"  />
                            <md-button class="md-button md-warn" ng-click="ctrl.deleteImage($index, $event)" >
                                Vymazať
                                <ng-md-icon class="md-secondary"  icon="highlight_remove" style="margin-top: 5px;fill:red" size="16">
                                </ng-md-icon>
                            </md-button>
                        </div>
                    </div>
                    <md-button class="md-button md-primary md-raised" accept="image/*" ngf-select="ctrl.selectImages($files,$event)" ng-model="images" ngf-multiple="true" name="image">
                        <ng-md-icon icon="add_to_photos"></ng-md-icon> Pridaj fotografie
                    </md-button>
                </md-card-content>
            </md-card>

            <md-card>
                <md-card-content>
                    <h4><ng-md-icon icon="attachment"></ng-md-icon> Prílohy  </h4>
                    <div  layout="row" layout-align="start start" layout-wrap="true">
                        <div flex   >
                            <md-list>
                                <md-list-item style="min-height: 30px; border-bottom:1px dotted #ccc;" ng-repeat="file in ctrl.formData.files" >
                                    <a href="files/{{file.name}}" >{{file.name}}</a>   &nbsp;  ({{file.size}})
                                    <ng-md-icon class="md-secondary"  ng-click="ctrl.deleteFile(file)" icon="highlight_remove" style="margin-top: 5px;fill:red" size="16"></ng-md-icon>
                                </md-list-item>
                            </md-list>


                            {{ctrl.selected_file.name}}
                        </div>
                    </div>
                    <md-button class="md-button md-primary md-raised" accept=".xlsx,.doc,.docx,.pdf,.xls,.csv"
                               ngf-select="ctrl.selectFile($file,$event)" ng-model="file" ngf-multiple="false" name="file">
                        <ng-md-icon icon="add"></ng-md-icon> Pridaj prílohu
                    </md-button>
                    xlsx,.doc,.docx,.pdf,.xls,.csv
                </md-card-content>
            </md-card>

            <md-card>
                <md-card-content>
                    <h4>Možnosti ponuky</h4>
                    <md-list class="md-list-fit">
                        <md-list-item class="md-2-line margin-none" layout="column"   ng-if="ctrl.formData.id">
                            <md-button  ng-click="ctrl.createOrder($event)" class="margin-none">
                                <ng-md-icon icon="done"></ng-md-icon> Vytvor objednávku
                            </md-button>
                        </md-list-item>
                        <md-list-item class="md-2-line margin-none" layout="column" ng-if="ctrl.formData.id" >
                            <md-button  ng-click="ctrl.printOrder(ctrl.formData.id,$event)"  class="margin-none" >
                                <ng-md-icon icon="print"></ng-md-icon> Vytlač ponuku
                            </md-button>
                        </md-list-item>
                        <md-list-item class="md-2-line margin-none"  ng-show="ctrl.formData.id"  layout="column" >
                            <md-button  class="margin-none" target="_blank" href="/orders/pdf/{{ctrl.formData.id}}">
                                <ng-md-icon icon="insert_drive_file"></ng-md-icon> Vytvor PDF
                            </md-button>
                        </md-list-item>

                        <md-list-item class="md-2-line margin-none"  ng-show="ctrl.formData.id"   layout="column" >
                            <md-button  class="margin-none" ng-click="ctrl.sendClient($event)">
                                <ng-md-icon icon="email"></ng-md-icon> Odoslať e-mail zákazníkovi
                            </md-button>
                        </md-list-item>
                        <md-list-item class="md-2-line margin-none"  ng-show="ctrl.formData.id"  layout="column" >
                            <md-button  class="margin-none" ng-click="ctrl.copyOrder(ctrl.formData.id,$event)">
                                <ng-md-icon icon="content_copy"></ng-md-icon> Kopírovať ponuku
                            </md-button>
                        </md-list-item>

                        <md-list-item class="md-2-line margin-none"  ng-show="ctrl.formData.id"  layout="column" >
                            <md-button  class="margin-none" ng-click="ctrl.deleteItem($event)">
                                <ng-md-icon style="fill:red" icon="cancel"></ng-md-icon> Vymazať ponuku
                            </md-button>
                        </md-list-item>

                    </md-list>
                </md-card-content>

            </md-card>



        </div>

    </div>

</div>

<footer-toolbar  class="footer-toolbar">
    <div layout="row" layout-align="end start">
        <div flex  layout="row" layout-align="end start" >
            <div flex="30" class="footer-title" ng-if="ctrl.formData.id">
                Ponuka číslo {{ctrl.formData.id}}
            </div>
            <div flex class="footer-description" ng-if="ctrl.formData.id">
                 Vytvoril: {{ctrl.formData.user.name}}
            </div>
        </div>

        <div flex   layout="row" layout-align="end start"  >
            <div flex="40"   class="footer-price" style="text-align: right">
                {{ctrl.formData.total_price}}
                Eur
                <div class="footer-price-desc">Celková cena (Eur s DPH)</div>
            </div>

                <md-button flex   aria-label="ulozit"  class="md-accent md-raised" md-ripple-size="auto">
                    <ng-md-icon icon="save"></ng-md-icon> Uložiť ponuku
                </md-button>

            <div flex  >
                <div class="footer-note">
                   &copy;<?php echo date("Y")?> Autocar  <br>
                    Verzia 1.0.1 by Guliwer
                </div>


            </div>

        </div>

    </div>
</footer-toolbar>
</form>
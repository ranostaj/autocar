<?php $this->extend('/Layout/default'); ?>

<?php $this->start('header') ?>
<?php if(isset($auth)) : ?>
    <md-toolbar  header-fixed class="header  " ng-controller="appToolbarCtrl as ctrl">
        <div class="md-toolbar-tools ">
            <div class="logo">
                Voziky
                <span class="logo-subtitle">Autocar.sk</span>
            </div>
            <span flex></span>
            <md-menu  md-offset="0 60">
                <md-button ui-sref="home" >
                    <ng-md-icon icon="desktop_windows"></ng-md-icon>  Úvod
                </md-button>
                <md-menu-content><md-menu-item></md-menu-item></md-menu-content>
            </md-menu>

            <md-menu  md-offset="0 60">
                <md-button ui-sref="orders" >
                    <ng-md-icon icon="view_list"></ng-md-icon> Ponuky
                </md-button>
                <md-menu-content><md-menu-item></md-menu-item></md-menu-content>
            </md-menu>


            <md-menu  md-offset="0 60">
                <md-button ui-sref="orders.add({id:null})"  >
                    <ng-md-icon icon="insert_drive_file"></ng-md-icon> Vytvor ponuku
                </md-button>
                <md-menu-content><md-menu-item></md-menu-item></md-menu-content>
            </md-menu>

            <md-menu  md-offset="0 60">
                <md-button ui-sref="users" >
                   <ng-md-icon icon="people_outline"></ng-md-icon> Zoznam užívateľov
                </md-button>
                <md-menu-content><md-menu-item></md-menu-item></md-menu-content>
            </md-menu>


            <?php if($auth['role'] == 'admin') : ?>
                <md-menu  md-offset="0 60">
                    <md-button href=""  ng-click="ctrl.addUser($event)" >
                        <ng-md-icon icon="person_add"></ng-md-icon> Pridaj užívateľa
                    </md-button>
                    <md-menu-content><md-menu-item></md-menu-item></md-menu-content>
                </md-menu>
            <?php endif; ?>


            <md-menu md-offset="0 60">
                <md-button  href="#" aria-label="User menu" class="md-raised md-warn"  ng-click="$mdOpenMenu($event)">
                    <ng-md-icon icon="person_outline"></ng-md-icon>  <?php echo $auth['name'] ?>
                </md-button>
                <md-menu-content width="3">
                    <md-menu-item  >
                        <md-button href="/logout" type="button" >
                            <ng-md-icon icon="logout"></ng-md-icon> Odhlásiť
                        </md-button>
                    </md-menu-item>
                </md-menu-content>
            </md-menu>

        </div>
    </md-toolbar>
<?php endif; ?>
<?php $this->end()?>

<div ui-view></div>


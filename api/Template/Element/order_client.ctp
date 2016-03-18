

<h2 style="font-size: 24px; font-weight: lighter" >Objednávka číslo <?php echo $row['id'] ?></h2>

<div class="layout layout-row">
    <table style="width: 100%">
        <tr>
            <td style="width: 50%; vertical-align: top">

                <strong>Údaje o zákazníkovi</strong><br><br>

                <div class="section customer">

                    <?php if($row['companny']) { ?>
                        Firma:  <?php echo $row['companny'] ?> <br>
                    <?php } ?>

                    <?php if($row['customer']) { ?>
                        Meno: <?php echo $row['customer'] ?> <br>
                    <?php } ?>

                    <?php if($row['street']) { ?>
                        Ulica:   <?php echo $row['street'] ?> <br>
                    <?php } ?>

                    <?php if($row['address']) { ?>
                        Mesto: <?php echo $row['address'] ?> <br><br>
                    <?php } ?>

                    <?php if($row['ico']) { ?>
                        ičo / číslo OP: <?php echo $row['ico'] ?> <br>
                    <?php } ?>
                    <?php if($row['ic_dph']) { ?>
                        ič DPH: <?php echo $row['ic_dph'] ?> <br>
                    <?php } ?>
                    <?php if($row['phone']) { ?>
                        Tel.: <?php echo $row['phone'] ?> <br>
                    <?php } ?>
                    <?php if($row['email']) { ?>
                        e-mail: <?php echo $row['email'] ?> <br>
                    <?php } ?>

                </div>





            </td>
            <td>



                <strong>Typ prívesného vozíka</strong>
                <p><?php echo $row['typ'] ?></p>

                <?php if($row['vin']) { ?>
                    <strong>VIN</strong>
                    <p><?php echo $row['vin'] ?></p>
                <?php } ?>


                <strong>Popis prívesného vozíka</strong>
                <p><?php echo $row['description'] ?></p>

                <strong>Základná cena vozíka</strong>
                <div style="font-size: 18px;border:1px solid #000; margin:3px; padding: 5px; width: 50%"> <?php echo number_format($row['base_price'],2,"."," ") ?> &euro; s DPH</div>


            </td>

        </tr>

    </table>



    <?php if($row['accessories']){ ?>
        <h3>Doplnky</h3>
        <table style="width: 100%; border:1px solid #ccc; border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background: #333; color:#fff; ">
                <th  style="padding: 5px; background: #333; color:#fff;">Názov</th>
                <th  style="padding: 5px; background: #333; color:#fff;">Kód</th>
                <th  style="padding: 5px; background: #333; color:#fff;">Ks</th>
                <th  style="padding: 5px; background: #333; color:#fff;" width="20%">Cena  &euro; s DPH</th>
            </tr>
            <?php $c = 0 ;foreach($row['accessories'] as $accessory) { ?>
                <tr style="<?php echo $c % 2 ? 'background:#ccc;' : '' ?> padding:5px;">
                    <td style="padding: 5px;"><?php echo $accessory['name'] ?> </td>
                    <td align="center" style="padding: 5px;"><?php echo $accessory['code'] ?> </td>
                    <td align="center" style="padding: 5px;"><?php echo $accessory['amount'] ?> ks</td>
                    <td align="center" style="padding: 5px;"><?php echo number_format($accessory['price'],2,"."," ") ?></td>
                </tr>
                <?php $c++; } ?>

        </table>
    <?php } ?>


    <?php if($row['images']) { ?>
        <h3>Obrázky</h3>
        <table width="100%" >


            <tr >

                <?php $c= 0; foreach($row['images'] as $image) {

                    if($c < 3) {
                        ?>
                        <td style="text-align: center; vertical-align: top; padding:0px;">
                            <?php echo $this->Html->image($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/img/images/'.$image['name'], array('width'=>'150')) ?>
                        </td>

                    <?php  }  $c++; } ?>


            </tr>


            <tr>

                <?php $c= 0; foreach($row['images'] as $image) {

                    if($c >= 3) {
                        ?>
                        <td style="text-align: right; vertical-align: top; padding:0px;">
                            <?php echo $this->Html->image($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/img/images/'.$image['name'], array('width'=>150)) ?>
                        </td>

                    <?php  }  $c++; } ?>


            </tr>



        </table>
    <?php } ?>



</div>

<hr style="margin: 20px 0; background: #999; border:none;" />
<div class="layout layout-row">

    <table style="width: 100%">

        <tr>
            <td style="vertical-align: top;width: 30%;">Dátum dodania:
                <strong><?php echo $this->Time->format($row['date_delivery'], "d.M. YYYY") ?></strong>
            </td>
            <td style="width: 30%"></td>
            <td  style="width: 40%; text-align: right">

                Celková cena
                <div  style="font-size: 28px!important; border:1px solid #000; padding: 5px;">
                    <?php echo number_format($row['total_price'],2,"."," ") ?> &euro; s DPH
                </div>


                Objednávku vytvoril: <?php echo $row['user']['name'] ?> <br>
                e-mail: <?php echo $row['user']['username'] ?> <br>
                www.autocar.sk



            </td>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px;"></td>
        </tr>

        </table>

  </div>



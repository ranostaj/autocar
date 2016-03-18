Dobry den,
<br><br>

Bola zaznamenana poziadavka na zmenu vasho hesla k  uctu na: <strong>http://voziky.autocarcentrum.sk/</strong> <br>

<br>
Nove heslo: <?php echo $password ?>

<br><br>
Pre potvrdenie zmeny hesla kliknite na tento link:
<br><br><?php echo $this->Html->link('http://'.$_SERVER['HTTP_HOST'].'/users/password/'.$hash); ?>

<br><br>
Pokial ste zmenu hesla nevyziadali vy, tuto spravu ignorujte
<br><br>
--------------

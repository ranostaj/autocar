<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('popup.css') ?>

</head>
<body class="popup">
<div class="container">
    <?php echo $this->fetch('content') ?>
</div>


<script>
    window.print();
</script>
</body>
</html>

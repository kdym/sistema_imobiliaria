<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>

    <title>Sistema de Imobiliária - Boletos</title>

    <?= $this->Html->meta('icon') ?>

    <?php echo $this->Html->css('slips.min') ?>
</head>

<body>

<?php echo $this->fetch('content') ?>

<script>
    window.print();
</script>

</body>
</html>
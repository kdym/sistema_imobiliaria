<!DOCTYPE html>
<html>
<head>
    <?php
    echo $this->Html->charset();

    echo $this->Html->meta('icon', $this->Url->build("/img/flats.png"));
    echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1.0');
    echo $this->fetch('meta');

    echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min');
    echo $this->Html->css("login.min");
    echo $this->fetch('css');
    ?>

    <title><?php echo $this->CompanyData->getAppTitle() ?></title>
</head>

<body>

<div id="background"></div>

<div id="login-wrapper">
    <div id="login-container">
        <?php echo $this->Flash->render() ?>

        <?php echo $this->fetch('content') ?>

        <?php
        echo $this->Html->link(
            $this->Html->image('new_logo_kdym.png', ['class' => 'img-responsive']),
            'http://www.kdymsolucoes.com.br/',
            ['target' => '_blank', 'escape' => false, 'id'=>'kdym-ad']
        ) ?>
    </div>
</div>

<?php
echo $this->Html->script('AdminLTE./plugins/jQuery/jquery-2.2.3.min');
echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap.min');
echo $this->Html->script('https://use.fontawesome.com/cb14bfd7f6.js');
echo $this->fetch('script');
?>

</body>
</html>

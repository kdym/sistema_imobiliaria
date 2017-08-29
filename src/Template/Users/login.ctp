<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div id="logo">
    <?php echo $this->Html->image($this->CompanyData->getAppLogo(), ['class' => 'img-responsive']) ?>
</div>

<?php echo $this->Form->create($usuario) ?>

<?php echo $this->Form->control("username", ["label" => "Usuário"]) ?>
<?php echo $this->Form->control("password", ["label" => "Senha"]) ?>

<?php echo $this->Form->button("<i class='fa fa-sign-in'></i> Entrar", ["class" => "btn-block"]) ?>

<?php echo $this->Form->end() ?>


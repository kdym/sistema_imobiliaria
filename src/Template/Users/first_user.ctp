<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php echo $this->Form->create($user) ?>

<?php echo $this->Form->control('nome') ?>
<?php echo $this->Form->control('email', ['label' => 'E-mail']) ?>
<?php echo $this->Form->control('username', ['label' => 'Usuário']) ?>
<?php echo $this->Form->control('password', ['label' => 'Senha']) ?>

<?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar', ['class' => 'btn-block']) ?>

<?php echo $this->Form->end() ?>
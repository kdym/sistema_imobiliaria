<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\UsersTable;
use App\View\Helper\GlobalCombosHelper;

echo $this->Html->script('guarantors.min', ['block' => true]);

?>

<section class="content-header">
    <h1>
        <a href="<?php echo $referrer ?>"><i class="fa fa-arrow-left"></i></a>
        Fiadores
        <small><?php echo $contract['property']['full_address'] ?></small>
    </h1>
</section>

<section class="content">
    <?php echo $this->Form->create($guarantor, ['url' => ['action' => 'add_from_user']]) ?>

    <?php echo $this->Form->control('contract_id', ['type' => 'hidden', 'value' => $contract['id']]) ?>
    <?php echo $this->Form->control('user_id', ['type' => 'hidden']) ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Adicionar de Usuário existente</h3>
        </div>

        <div class="box-body">
            <?php echo $this->Form->control('user', ['label' => false, 'type' => 'text', 'placeholder' => 'Buscar Usuário...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>
        </div>

        <div class="col-md-6 to-ri">
            <a href=""></a>
        </div>
    </div>

    <?php echo $this->Form->end() ?>
</section>

<script type="text/html" id="users-search-template">
    <p>
        ${name}
        <small>${username}</small>
    </p>
</script>
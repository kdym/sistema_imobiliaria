<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 * @var \App\Model\Custom\GeneralFee $f
 */

use App\Model\Table\ContractsValuesTable;

?>

<section class="content-header">
    <h1>Configurações
        <small>Parâmetros Gerais</small>
    </h1>
</section>

<section class="content">
    <?php echo $this->Form->create() ?>

    <div class="box">
        <div class="box-body">
            <?php foreach (ContractsValuesTable::$generalFees as $f) { ?>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control($f->getKey(), ['label' => sprintf('%s (%s)', $f->getName(), $f->getTypeSymbol()), 'class' => 'mask-number', 'value' => $f->getFormattedValue()]) ?>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

    <?php echo $this->Form->end() ?>
</section>
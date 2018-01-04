<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Custom\Bills;

echo $this->Html->script('bills.min', ['block' => true]);
?>

<section class="content-header">
    <h1>Lançamento de Contas
        <small>Água</small>
    </h1>
</section>

<section class="content">
    <?php echo $this->Form->create() ?>

    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e) { ?>
                    <li><?php echo $e ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="box">
        <div class="box-body">
            <div class="col-md-4">
                <?php echo $this->Form->control('property', ['label' => 'Imóvel ou Código SAAE', 'autocomplete' => false]) ?>

                <?php echo $this->Form->control('property_id', ['type' => 'hidden']) ?>
            </div>

            <div class="col-md-4">
                <?php echo $this->Form->control('period', ['label' => 'Período', 'class' => 'month-year-mask']) ?>
            </div>

            <div class="col-md-4">
                <?php echo $this->Form->control('value', ['label' => 'Valor da Conta', 'class' => 'mask-money', 'type' => 'text']) ?>
            </div>
        </div>
    </div>

    <div class="to-right margin-bottom">
        <?php echo $this->Form->button('<i class="fa fa-calculator"></i> Lançar Valores') ?>
    </div>

    <?php echo $this->Form->end() ?>

    <?php echo $this->Form->create(null, ['id' => 'save-values-form', 'url' => ['action' => 'save_values']]) ?>

    <?php echo $this->Form->control('categoria', ['type' => 'hidden', 'value' => Bills::WATER]) ?>
    <?php echo $this->Form->control('period', ['type' => 'hidden', 'value' => $this->request->getData('period')]) ?>

    <div class="box">
        <div class="box-body">
            <?php if (!empty($values)) { ?>
                <div class="thumbs-list">
                    <div class="row">
                        <?php foreach ($values as $v) { ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="item">
                                    <div class="item-wrapper">
                                        <figure>
                                            <?php echo $this->Html->image($this->Properties->getMainPhoto($v['property'])) ?>
                                        </figure>

                                        <h1>
                                            <?php echo $this->Properties->getMainAddress($v['property']) ?>
                                            <small><?php echo $v['property']['formatted_code'] ?></small>
                                        </h1>

                                        <h2><?php echo $v['property']['locator']['user']['nome'] ?>
                                            <small><?php echo $v['property']['locator']['user']['formatted_username'] ?></small>
                                        </h2>

                                        <h3><?php echo $this->Properties->getStatus($v['property']) ?></h3>
                                    </div>

                                    <nav class="actions">
                                        <?php echo $this->Form->control('value[' . $v['property']['id'] . ']', ['label' => false, 'value' => $this->Properties->formatCurrency($v['value']), 'type' => 'text', 'class' => 'mask-money']) ?>
                                    </nav>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar', ['disabled' => empty($values)]) ?>

    <?php echo $this->Form->end() ?>
</section>


<script type="text/html" id="properties-search-template">
    <div class="row">
        <div class="col-md-2">
            <img src="${photo}" class="img-responsive img-rounded"/>
        </div>

        <div class="col-md-10">
            <h1 class="search-h1">
                ${address}
                <small>${code}</small>
            </h1>

            <h2 class="search-h2">${locator}
                <small>${locator_username}</small>
            </h2>
        </div>
    </div>
</script>
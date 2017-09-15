<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */


echo $this->Html->css('AdminLTE./plugins/bootstrap-slider/slider', ['block' => true]);
echo $this->Html->script('AdminLTE./plugins/bootstrap-slider/bootstrap-slider', ['block' => true]);

echo $this->Html->script('locators-associations.min', ['block' => true]);

?>

<section class="content-header">
    <h1>Locadores Associados
        <small><?php echo $locator['nome'] ?></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <div class="percentage-sliders">
                        <div class="row vertical-center-row" id="main-locator"
                             data-locator-id="<?php echo $locator['locator']['id'] ?>">
                            <div class="col-md-2 col-sm-12">
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>

                            <div class="col-md-10 col-sm-12">
                                <h1>
                                    <?php echo $locator['nome'] ?>

                                    <small><?php echo $locator['formatted_username'] ?></small>
                                </h1>

                                <div class="row vertical-center-row">
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <input type="text" value="" id="main-slider" class="form-control"
                                               data-slider-enabled="<?php echo !empty($locator['locator']['locators_associations']) ?>"
                                               data-slider-value="<?php echo $locator['owner_percentage'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php foreach ($locator['locator']['locators_associations'] as $a) { ?>
                            <div class="row vertical-center-row associated-locator-row"
                                 data-locator-id="<?php echo $a['locator_2'] ?>">
                                <div class="col-md-2 col-sm-12">
                                    <div class="icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>

                                <div class="col-md-10 col-sm-12">
                                    <h1>
                                        <?php echo $a['associated']['user']['nome'] ?>

                                        <small><?php echo $a['associated']['user']['formatted_username'] ?></small>
                                    </h1>

                                    <div class="row vertical-center-row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <input type="text" value="" class="slider form-control"
                                                   data-slider-value="<?php echo $a['porcentagem'] ?>">
                                        </div>

                                        <div class="col-md-2 col-sm-2 col-xs-2 to-center">
                                            <button class="btn btn-danger btn-sm delete-button"><i
                                                        class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <?php echo $this->Form->control('search_locator', ['label' => 'Adicionar Locador']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Porcentagem Total</h3>
                </div>

                <div class="box-body">
                    <div class="big-info" id="total-percentage">
                        100%
                    </div>

                    <?php echo $this->Form->create() ?>

                    <div id="associate-locators-form"></div>

                    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar', ['class' => 'btn btn-success btn-block', 'id' => 'save-button']) ?>

                    <?php echo $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/html" id="locators-search-template">
    <p>
        ${name}
        <small>${username}</small>
    </p>
</script>

<script type="text/html" id="locators-sliders-template">
    <div class="row vertical-center-row associated-locator-row" data-locator-id="${id}">
        <div class="col-md-2 col-sm-12">
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
        </div>

        <div class="col-md-10 col-sm-12">
            <h1>${name}
                <small>${username}</small>
            </h1>

            <div class="row vertical-center-row">
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <input type="text" value="" class="slider form-control"
                           data-slider-value="${percentage}">
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2 to-center">
                    <button class="btn btn-danger btn-sm delete-button"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="associate-locators-form-template">
    <?php echo $this->Form->control('slider[${id}]', ['type' => 'hidden', 'value' => '${percentage}']) ?>
</script>
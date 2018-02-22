<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Controller\BillsController;
use App\Model\Table\PropertiesTable;

echo $this->Html->script('bills.min', ['block' => true]);

?>

<section class="content-header">
    <h1>Contas a Pagar</h1>
</section>

<section class="content">
    <ul class="circles-legend">
        <li><i class="fa fa-circle-o text-danger"></i> Atrasado</li>
        <li><i class="fa fa-circle-o text-muted"></i> Próximo do Vencimento</li>
        <li><i class="fa fa-circle-o"></i> Hoje</li>
    </ul>

    <div class="box">
        <div class="box-body">
            <table id="bills-to-pay-list" class="table table-hover">
                <thead>
                <tr>
                    <th>Vencimento</th>
                    <th>Imóvel</th>
                    <th>Locatário</th>
                    <th>Conta</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bills as $b) { ?>
                    <?php
                    $class = '';
                    $link = '';

                    switch ($b['status']) {
                        case BillsController::LATE:
                            $class = 'danger';

                            break;

                        case BillsController::TO_BE_LATE:
                            $class = 'active';

                            break;
                    }

                    if (!empty($b['contract'])) {
                        $link = [
                            'controller' => 'slips',
                            'action' => 'index',
                            $b['contract']['id'],
                            '?' => [
                                'start_date' => $b['salary']->format('d-m-Y'),
                                'end_date' => $b['salary']->format('d-m-Y'),
                            ]
                        ];
                    } else {
                        $link = ['controller' => 'properties', 'action' => 'pay_bills', $b['property']['id']];
                    }
                    ?>

                    <tr class="<?php echo $class ?>">
                        <td><?php echo $b['salary']->format('d/m/Y') ?></td>
                        <td><?php echo sprintf('%s - %s', $b['property']['formatted_code'], $b['property']['full_address']) ?></td>
                        <td>
                            <?php
                            if (!empty($b['contract'])) {
                                echo sprintf('%s - %s', $this->Users->getUsername($b['contract']['tenant']['user']), $b['contract']['tenant']['user']['nome']);
                            } else {
                                echo 'Imóvel Vazio';
                            }
                            ?>
                        </td>
                        <td><?php echo PropertiesTable::$propertiesBills[$b['type']] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
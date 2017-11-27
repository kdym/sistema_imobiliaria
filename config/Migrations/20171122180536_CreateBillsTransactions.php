<?php
use Migrations\AbstractMigration;

class CreateBillsTransactions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('bills_transactions');
        $table->addColumn('categoria', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('data_pago', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('data_vencimento', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('reference_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('valor', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->addColumn('ausente', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('debitada', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('diferenca', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->create();
    }
}

<?php
use Migrations\AbstractMigration;

class CreateCustomBills extends AbstractMigration
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
        $table = $this->table('custom_bills');
        $table->addColumn('categoria', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('descricao', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('pagante', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('recebedor', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('repeat_year', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('repeat_month', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('repeat_day', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('data_inicio', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('data_fim', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('valor', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->addColumn('reference_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->create();
    }
}

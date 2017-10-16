<?php
use Migrations\AbstractMigration;

class ChangeRecursiveLogic extends AbstractMigration
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
        $table = $this->table('slips_customs_values');
        $table->drop();

        $table = $this->table('recursive');
        $table->drop();

        $table = $this->table('slips_custom_values');
        $table->addColumn('descricao', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('valor', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->addColumn('contract_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('contract_id', 'contracts', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();

        $table = $this->table('slips_recursive');
        $table->addColumn('start_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('end_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('deleted', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('slip_custom_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('slip_custom_id', 'slips_custom_values', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addColumn('tipo', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('contract_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('contract_id', 'contracts', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}

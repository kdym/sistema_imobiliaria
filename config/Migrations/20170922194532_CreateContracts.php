<?php
use Migrations\AbstractMigration;

class CreateContracts extends AbstractMigration
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
        $table = $this->table('contracts');
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('tipo_garantia', 'integer', [
            'default' => null,
            'limit' => 11,
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
        $table->addColumn('tenant_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('tenant_id', 'tenants', 'id', ['delete' => 'SET NULL', 'update' => 'SET NULL']);
        $table->addColumn('property_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('property_id', 'properties', 'id', ['delete' => 'SET NULL', 'update' => 'SET NULL']);
        $table->create();
    }
}

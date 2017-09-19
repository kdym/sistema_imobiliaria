<?php
use Migrations\AbstractMigration;

class CreatePropretiesCompositions extends AbstractMigration
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
        $table = $this->table('properties_compositions');
        $table->addColumn('quartos', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('suites', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('garagens', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('condominio_fechado', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('piscina', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('salao_festas', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('area_churrasqueira', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('start_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('property_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('property_id', 'properties', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}

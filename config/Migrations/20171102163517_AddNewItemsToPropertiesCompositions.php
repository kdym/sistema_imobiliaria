<?php
use Migrations\AbstractMigration;

class AddNewItemsToPropertiesCompositions extends AbstractMigration
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
        $table->addColumn('area_servico', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('dependencias_empregada', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('varanda', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('quintal', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('terraco', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sauna', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}

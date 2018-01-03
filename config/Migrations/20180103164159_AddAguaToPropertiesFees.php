<?php
use Migrations\AbstractMigration;

class AddAguaToPropertiesFees extends AbstractMigration
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
        $table = $this->table('properties_fees');
        $table->addColumn('agua', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}

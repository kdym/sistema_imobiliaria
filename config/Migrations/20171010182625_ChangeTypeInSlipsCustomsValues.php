<?php

use Migrations\AbstractMigration;

class ChangeTypeInSlipsCustomsValues extends AbstractMigration
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

        $table->changeColumn('tipo', 'string', [
            'null' => false
        ]);

        $table->update();
    }
}

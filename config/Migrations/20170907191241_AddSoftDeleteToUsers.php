<?php

use Migrations\AbstractMigration;

class AddSoftDeleteToUsers extends AbstractMigration
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
        $table = $this->table('users');

        $table->removeColumn('deleted');

        $table->addColumn('deleted', 'datetime', [
            'default' => null
        ]);

        $table->update();
    }
}

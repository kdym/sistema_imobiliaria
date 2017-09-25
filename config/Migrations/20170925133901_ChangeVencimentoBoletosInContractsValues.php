<?php

use Migrations\AbstractMigration;

class ChangeVencimentoBoletosInContractsValues extends AbstractMigration
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
        $table = $this->table('contracts_values');

        $table->removeColumn('vencimento_boletos');

        $table->addColumn('vencimento_primeiro_boleto', 'date', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}

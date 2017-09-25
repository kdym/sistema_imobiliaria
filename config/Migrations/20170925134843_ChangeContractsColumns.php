<?php

use Migrations\AbstractMigration;

class ChangeContractsColumns extends AbstractMigration
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

        $table->addColumn('finalidade', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
        ]);
        $table->addColumn('finalidade_nao_residencial', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->update();

        $table = $this->table('contracts_values');

        $table->removeColumn('finalidade');
        $table->removeColumn('finalidade_nao_residencial');
        $table->removeColumn('vencimento_primeiro_boleto');

        $table->addColumn('vencimento_boleto', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
        ]);

        $table->update();
    }
}

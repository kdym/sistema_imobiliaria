<?php

namespace App\View\Helper;

use App\Model\Table\ContractsTable;
use Cake\View\Helper;
use Cake\View\View;
use DateTime;

/**
 * Contracts helper
 */
class ContractsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getMonthsInPeriod($contract)
    {
        $startDate = new DateTime($contract['data_inicio']->format('Y-m-d'));
        $endDate = new DateTime($contract['data_fim']->format('Y-m-d'));

        $diff = $startDate->diff($endDate);
        $months = floor($diff->days / ContractsTable::DEFAULT_MONTH_DAYS);

        if ($months == 0) {
            return 'Menos de 1 mês';
        } elseif ($months == 1) {
            return '1 mês';
        } else {
            return sprintf('%s meses', $months);
        }
    }

    public function getFinality($contract)
    {
        return ContractsTable::$finalities[$contract['finalidade']];
    }

    public function getContractValue($contract)
    {
        return 'R$ ' . number_format($contract['property']['properties_prices'][0]['valor'], 2, ',', '.');
    }

    public function getContractualFee($contract)
    {
        return 'R$ ' . number_format($contract['contracts_values'][0]['taxa_contratual'], 2, ',', '.');
    }

    public function getDiscountOrFineTitle($contract)
    {
        if (!empty($contract['contracts_values'][0]['desconto'])) {
            return ContractsTable::$discountOrFine[ContractsTable::DISCOUNT];
        } else {
            return ContractsTable::$discountOrFine[ContractsTable::FINE];
        }
    }

    public function getDiscountOrFine($contract)
    {
        $value = (!empty($contract['contracts_values'][0]['desconto'])) ? $contract['contracts_values'][0]['desconto'] : $contract['contracts_values'][0]['multa'];

        return number_format($value, 2, ',', '.') . '%';
    }

    public function getExtraFees($contract, $fee)
    {
        return 'R$ 0,00';
    }

}

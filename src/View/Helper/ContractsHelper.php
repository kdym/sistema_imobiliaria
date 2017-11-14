<?php

namespace App\View\Helper;

use App\Model\Table\ContractsTable;
use Cake\I18n\Date;
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

    public function getExtraFees($fee)
    {
        return 'R$ 0,00';
    }

    public function getExemptionRemaining($contract)
    {
        $startDate = new DateTime($contract['data_inicio']->format('Y-m-d'));
        $endDate = new DateTime($contract['data_inicio']->format('Y-m-d'));
        $today = new DateTime('now');

        $endDate->modify(sprintf('+%d months', $contract['isencao']));

        $diffTotal = $endDate->diff($startDate);
        $diff = $endDate->diff($today);

        $percent = 0;
        $text = '';

        if ($diff->invert == 0) {
            $percent = 100;
            $text = 'Isento';
        } else {
            $buffer = [];

            if ($diff->y != 0) {
                $buffer[] = __('{0, plural, =1{1 ano} other{# anos}}', $diff->y);
            }

            if ($diff->m != 0) {
                $buffer[] = __('{0, plural, =1{1 mês} other{# meses}}', $diff->m);
            }

            if ($diff->d != 0) {
                $buffer[] = __('{0, plural, =1{1 dia} other{# dias}}', $diff->d);
            }

            $text = 'Faltando ' . implode(' e ', $buffer);

            $percent = floor(100 - (($diff->days / $diffTotal->days) * 100));
        }

        return [
            'percent' => $percent,
            'text' => $text
        ];
    }
}
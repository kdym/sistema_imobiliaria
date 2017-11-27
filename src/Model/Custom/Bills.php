<?php
/**
 * Created by PhpStorm.
 * User: sKnMetal
 * Date: 22/11/2017
 * Time: 16:09
 */

namespace App\Model\Custom;


class Bills
{
    const RENT = 'rent';
    const DISCOUNT_CONTRACT = 'discount_contract';
    const FINE_CONTRACT = 'fine_contract';
    const PAINT_FEE = 'paint_fee';
    const CUSTOM = 'custom';
    const DISCOUNT = 'discount';
    const EXTRA = 'extra';

    public static $bills = [
        self::RENT => 'Aluguel',
        self::DISCOUNT_CONTRACT => 'Desconto Pagamento em Dia',
        self::FINE_CONTRACT => 'Multa por Atraso',
        self::PAINT_FEE => 'Taxa de Pintura',
        self::CUSTOM => 'Personalizada',
        self::DISCOUNT => 'Desconto',
        self::EXTRA => 'Adicional',
    ];

    const PAID = 'paid';
    const OPEN = 'open';
    const LATE = 'late';

    const PAYER_RECEIVER_LOCATOR = 'locator';
    const PAYER_RECEIVER_TENANT = 'tenant';
    const PAYER_RECEIVER_REAL_ESTATE = 'real_estate';

    public static $payersReceivers = [
        self::PAYER_RECEIVER_LOCATOR => 'Locador',
        self::PAYER_RECEIVER_TENANT => 'Locatário',
        self::PAYER_RECEIVER_REAL_ESTATE => 'Imobiliária',
    ];

    public static function getValidContractBills()
    {
        $validBillsContract = [
            self::PAINT_FEE,
            self::CUSTOM,
            self::DISCOUNT,
            self::EXTRA,
        ];

        return array_filter(self::$bills, function ($k) use ($validBillsContract) {
            return in_array($k, $validBillsContract);
        }, ARRAY_FILTER_USE_KEY);
    }
}
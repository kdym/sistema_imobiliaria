<?php

namespace App\View\Helper;

use App\Model\Custom\Slip;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\View;
use DateTime;
use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * Slips helper
 */
class SlipsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function formatCurrency($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    public function formatNumber($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getSlipClass($slip)
    {
        switch ($slip->getStatus()) {
            case Slip::PAID:
                return 'bg-success';
            case Slip::LATE:
                return 'bg-danger';
            case Slip::NORMAL:
                return 'bg-primary';
        }
    }

    public function getReportButton($date, $companyData, $contract)
    {
        $htmlHelper = new HtmlHelper(new View());

        $date = new DateTime($this->invertDate($date));

        if ($companyData) {
            $disabled = false;
            $tooltipTitle = 'Visualizar Boleto';
        } else {
            $disabled = true;
            $tooltipTitle = 'É necessário informar os dados da Imobiliária antes';
        }

        return $htmlHelper->link('<i class="fa fa-barcode fa-fw"></i>',
            ['action' => 'report', $contract['id'], '?' => [
                'start_date' => $date->modify('first day of this month')->format('Y-m-d'),
                'end_date' => $date->modify('last day of this month')->format('Y-m-d'),
            ]],
            [
                'escape' => false,
                'class' => 'btn btn-default',
                'target' => '_blank',
                'readonly' => $disabled,
                'data-toggle' => 'tooltip',
                'title' => $tooltipTitle,
            ]);
    }

    public function getAllReportButton($startDate, $endDate, $companyData, $contract)
    {
        $htmlHelper = new HtmlHelper(new View());

        $startDate = new DateTime($this->invertDate($startDate));
        $endDate = new DateTime($this->invertDate($endDate));

        if ($companyData) {
            $disabled = false;
            $tooltip = '';
            $tooltipTitle = '';
        } else {
            $disabled = true;
            $tooltip = 'tooltip';
            $tooltipTitle = 'É necessário informar os dados da Imobiliária antes';
        }

        return $htmlHelper->link('<i class="fa fa-barcode"></i> Ver Todos',
            ['action' => 'report', $contract['id'], '?' => [
                'start_date' => $startDate->modify('first day of this month')->format('Y-m-d'),
                'end_date' => $endDate->modify('last day of this month')->format('Y-m-d'),
            ]],
            [
                'escape' => false,
                'class' => 'btn btn-app',
                'target' => '_blank',
                'readonly' => $disabled,
                'data-toggle' => $tooltip,
                'title' => $tooltipTitle,
            ]);
    }

    function Modulo10($num)
    {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0 += $v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // v�rias linhas removidas, vide fun��o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    function Modulo11($num, $base = 9, $r = 0)
    {
        /**
         *   Autor:
         *           Pablo Costa <pablo@users.sourceforge.net>
         *
         *   Fun��o:
         *    Calculo do Modulo 11 para geracao do digito verificador
         *    de boletos bancarios conforme documentos obtidos
         *    da Febraban - www.febraban.org.br
         *
         *   Entrada:
         *     $num: string num�rica para a qual se deseja calcularo digito verificador;
         *     $base: valor maximo de multiplicacao [2-$base]
         *     $r: quando especificado um devolve somente o resto
         *
         *   Sa�da:
         *     Retorna o Digito verificador.
         *
         *   Observa��es:
         *     - Script desenvolvido sem nenhum reaproveitamento de c�digo pr� existente.
         *     - Assume-se que a verifica��o do formato das vari�veis de entrada � feita antes da execu��o deste script.
         */
        $soma = 0;
        $fator = 2;

        /* Separacao dos numeros */
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo falor
            $parcial[$i] = $numeros[$i] * $fator;
            // Soma dos digitos
            $soma += $parcial[$i];
            if ($fator == $base) {
                // restaura fator de multiplicacao para 2
                $fator = 1;
            }
            $fator++;
        }

        /* Calculo do modulo 11 */
        if ($r == 0) {
            $soma *= 10;
            $digito = $soma % 11;
            if ($digito == 10) {
                $digito = 0;
            }
            return $digito;
        } elseif ($r == 1) {
            $resto = $soma % 11;
            return $resto;
        }
    }

    public function invertDate($value)
    {
        return implode('-', array_reverse(explode('/', $value)));
    }

    public function zeroFill($value, $limit)
    {
        return str_pad($value, $limit, '0', STR_PAD_LEFT);
    }

    public function monthInWords($month)
    {
        $month = (int)$month;

        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $months[$month];
    }

    public function getBarCode($value)
    {
        $barCode = new BarcodeGeneratorPNG();

        return sprintf('<img src="data:image/png;base64,%s"/>', base64_encode($barCode->getBarcode($value, $barCode::TYPE_INTERLEAVED_2_5, 1.7, 50)));
    }

    public function setMask($text, $mask)
    {
        $result = NULL;
        $separators = array('-', '_', '.', ',', '/', '\\', ':', '|', '(', ')', '[', ']', '{', '}', ' ');

        $z = 0;
        for ($n = 0; $n < strlen($mask); $n++) {
            $mask_char = substr($mask, $n, 1);
            $text_char = substr($text, $z, 1);

            if (in_array($mask_char, $separators)) {
                if ($z < strlen($text)) {
                    $result .= $mask_char;
                }
            } else {
                $result .= $text_char;
                $z++;
            }
        }

        return $result;
    }

    public function getDigitableLine($value)
    {
        return $this->setMask($value, '99999.99999 99999.999999 99999.999999 9 99999999999999');
    }
}

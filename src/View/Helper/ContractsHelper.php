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

    function ordinalInWords($numero, $genero, $maiusculas = false)
    {
        $numero = str_pad($numero, 20, '0', STR_PAD_LEFT);

        $elementos[1] = Array("", "primeir", "segund", "terceir", "quart", "quint", "sext", "sétim", "oitav", "non");
        $elementos[2] = Array("", "décim", "vigésim", "trigésim", "quadragésim", "quinquagésim", "sexagésim", "septuagésim", "octogésim", "nonagésim");
        $elementos[3] = Array("", "centésim", "ducentésim", "trecentésim", "quadringentésim", "quingentésim", "seiscentésim", "septingentésim", "octingentésim", "nongentésim");
        $elementos[4] = "milésim";
        $elementos[7] = "milhonésim";
        $elementos[10] = "bilhonésim";
        $elementos[13] = "trilhonésim";

        $controle = 3;
        $ordinal = "";
        $soma = 0;

        for ($c = 5; $c <= 19; $c++) {
            $num = substr($numero, $c, 1);
            settype($num, "integer");

            if ($num <> 0 && ($num > 1 || $c > 16)) {
                $temp_ord = $elementos[$controle][$num];

                if ($maiusculas)
                    $temp_ord = strtoupper(substr($temp_ord, 0, 1)) . substr($temp_ord, 1, strlen($temp_ord) - 1);

                $ordinal = $ordinal . " " . $temp_ord . $genero;

                $soma += $num * 10 ^ $controle;
            } else if ($num <> 0) {
                $soma += $num * 10 ^ $controle;
            }

            $controle--;

            if ($controle == 0 && $c < 19) {
                if ($soma > 1 && isset($elementos[20 - $c])) {
                    $temp_ord = $elementos[20 - $c];

                    if ($maiusculas)
                        $temp_ord = strtoupper(substr($temp_ord, 0, 1)) . substr($temp_ord, 1, strlen($temp_ord) - 1);

                    $ordinal = $ordinal . " " . $temp_ord . $genero;
                }

                $controle = 3;
                $soma = 0;
            }
        }

        return trim($ordinal);
    }

    public function toUpper($str)
    {
        return strtoupper(strtr($str, "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
    }

    public function clause($clause)
    {
        return $this->toUpper($this->ordinalInWords($clause, 'a'));
    }

    public function paragraph($clause)
    {
        return $this->toUpper('Parágrafo ' . $this->ordinalInWords($clause, 'o'));
    }

    public function dateInWords($date)
    {
        $months = array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

        $date = new DateTime($date);

        return sprintf('%s de %s de %s', $date->format('d'), $months[$date->format('m') - 1], $date->format('Y'));
    }

    public static function numberInWords($valor = 0, $bolExibirMoeda = false, $bolPalavraFeminina = false)
    {
        $singular = null;
        $plural = null;

        if ($bolExibirMoeda) {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        } else {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");


        if ($bolPalavraFeminina) {

            if ($valor == 1) {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            } else {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            }


            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }


        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];

            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        $rt = mb_substr($rt, 1);

        return ($rt ? trim($rt) : "zero");
    }

    public function formatCurrencyInWords($value)
    {
        return sprintf(
            'R$ %s (%s)',
            @number_format($value, 2, ",", "."),
            $this->numberInWords($value, true)
        );
    }

    public function formatNumberInWords($value)
    {
        return sprintf(
            '%s (%s)',
            $value,
            $this->numberInWords($value, false)
        );
    }

    public function formatPercentInWords($value)
    {
        return sprintf(
            '%s%% (%s por cento)',
            @number_format($value, 2, ",", "."),
            $this->numberInWords($value, false)
        );
    }
}
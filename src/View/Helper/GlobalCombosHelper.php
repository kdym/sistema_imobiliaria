<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * GlobalCombos helper
 */
class GlobalCombosHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public static $brazilianStates = array(
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'
    );

    public static $brazilianBanks = array(
        '001' => '001 - Banco do Brasil',
        '003' => '003 - Banco da Amazônia',
        '004' => '004 - Banco do Nordeste',
        '021' => '021 - Banestes',
        '025' => '025 - Banco Alfa',
        '027' => '027 - Besc',
        '029' => '029 - Banerj',
        '031' => '031 - Banco Beg',
        '033' => '033 - Banco Santander Banespa',
        '036' => '036 - Banco Bem',
        '037' => '037 - Banpará',
        '038' => '038 - Banestado',
        '039' => '039 - BEP',
        '040' => '040 - Banco Cargill',
        '041' => '041 - Banrisul',
        '044' => '044 - BVA',
        '045' => '045 - Banco Opportunity',
        '047' => '047 - Banese',
        '062' => '062 - Hipercard',
        '063' => '063 - Ibibank',
        '065' => '065 - Lemon Bank',
        '066' => '066 - Banco Morgan Stanley Dean Witter',
        '069' => '069 - BPN Brasil',
        '070' => '070 - Banco de Brasília – BRB',
        '072' => '072 - Banco Rural',
        '073' => '073 - Banco Popular',
        '074' => '074 - Banco J. Safra',
        '075' => '075 - Banco CR2',
        '076' => '076 - Banco KDB',
        '096' => '096 - Banco BMF',
        '104' => '104 - Caixa Econômica Federal',
        '107' => '107 - Banco BBM',
        '116' => '116 - Banco Único',
        '151' => '151 - Nossa Caixa',
        '175' => '175 - Banco Finasa',
        '184' => '184 - Banco Itaú BBA',
        '204' => '204 - American Express Bank',
        '208' => '208 - Banco Pactual',
        '212' => '212 - Banco Matone',
        '213' => '213 - Banco Arbi',
        '214' => '214 - Banco Dibens',
        '217' => '217 - Banco Joh Deere',
        '218' => '218 - Banco Bonsucesso',
        '222' => '222 - Banco Calyon Brasil',
        '224' => '224 - Banco Fibra',
        '225' => '225 - Banco Brascan',
        '229' => '229 - Banco Cruzeiro',
        '230' => '230 - Unicard',
        '233' => '233 - Banco GE Capital',
        '237' => '237 - Bradesco',
        '241' => '241 - Banco Clássico',
        '243' => '243 - Banco Stock Máxima',
        '246' => '246 - Banco ABC Brasil',
        '248' => '248 - Banco Boavista Interatlântico',
        '249' => '249 - Investcred Unibanco',
        '250' => '250 - Banco Schahin',
        '252' => '252 - Fininvest',
        '254' => '254 - Paraná Banco',
        '263' => '263 - Banco Cacique',
        '265' => '265 - Banco Fator',
        '266' => '266 - Banco Cédula',
        '300' => '300 - Banco de la Nación Argentina',
        '318' => '318 - Banco BMG',
        '320' => '320 - Banco Industrial e Comercial',
        '356' => '356 - ABN Amro Real',
        '341' => '341 - Itau',
        '347' => '347 - Sudameris',
        '351' => '351 - Banco Santander',
        '353' => '353 - Banco Santander Brasil',
        '366' => '366 - Banco Societe Generale Brasil',
        '370' => '370 - Banco WestLB',
        '376' => '376 - JP Morgan',
        '389' => '389 - Banco Mercantil do Brasil',
        '394' => '394 - Banco Mercantil de Crédito',
        '399' => '399 - HSBC',
        '409' => '409 - Unibanco',
        '412' => '412 - Banco Capital',
        '422' => '422 - Banco Safra',
        '453' => '453 - Banco Rural',
        '456' => '456 - Banco Tokyo Mitsubishi UFJ',
        '464' => '464 - Banco Sumitomo Mitsui Brasileiro',
        '477' => '477 - Citibank',
        '479' => '479 - Itaubank (antigo Bank Boston)',
        '487' => '487 - Deutsche Bank',
        '488' => '488 - Banco Morgan Guaranty',
        '492' => '492 - Banco NMB Postbank',
        '494' => '494 - Banco la República Oriental del Uruguay',
        '495' => '495 - Banco La Provincia de Buenos Aires',
        '505' => '505 - Banco Credit Suisse',
        '600' => '600 - Banco Luso Brasileiro',
        '604' => '604 - Banco Industrial',
        '610' => '610 - Banco VR',
        '611' => '611 - Banco Paulista',
        '612' => '612 - Banco Guanabara',
        '613' => '613 - Banco Pecunia',
        '623' => '623 - Banco Panamericano',
        '626' => '626 - Banco Ficsa',
        '630' => '630 - Banco Intercap',
        '633' => '633 - Banco Rendimento',
        '634' => '634 - Banco Triângulo',
        '637' => '637 - Banco Sofisa',
        '638' => '638 - Banco Prosper',
        '643' => '643 - Banco Pine',
        '652' => '652 - Itaú Holding Financeira',
        '653' => '653 - Banco Indusval',
        '654' => '654 - Banco A.J. Renner',
        '655' => '655 - Banco Votorantim',
        '707' => '707 - Banco Daycoval',
        '719' => '719 - Banif',
        '721' => '721 - Banco Credibel',
        '734' => '734 - Banco Gerdau',
        '735' => '735 - Banco Pottencial',
        '738' => '738 - Banco Morada',
        '739' => '739 - Banco Galvão de Negócios',
        '740' => '740 - Banco Barclays',
        '741' => '741 - BRP',
        '743' => '743 - Banco Semear',
        '745' => '745 - Banco Citibank',
        '746' => '746 - Banco Modal',
        '747' => '747 - Banco Rabobank International',
        '748' => '748 - Banco Cooperativo Sicredi',
        '749' => '749 - Banco Simples',
        '751' => '751 - Dresdner Bank',
        '752' => '752 - BNP Paribas',
        '753' => '753 - Banco Comercial Uruguai',
        '755' => '755 - Banco Merrill Lynch',
        '756' => '756 - Banco Cooperativo do Brasil',
        '757' => '757 - KEB',
    );

    const COMISSION_TYPE_PERCENTAGE = 0;
    const COMISSION_TYPE_FIXED = 1;

    public static $comissionTypes = [
        self::COMISSION_TYPE_PERCENTAGE => 'Porcentagem',
        self::COMISSION_TYPE_FIXED => 'Valor Fixo',
    ];

    const CIVIL_STATE_SINGLE = 0;
    const CIVIL_STATE_MARRIED = 1;
    const CIVIL_STATE_DIVORCED = 2;

    public static $civilStates = [
        self::CIVIL_STATE_SINGLE => 'Solteiro(a)',
        self::CIVIL_STATE_MARRIED => 'Casado(a)',
        self::CIVIL_STATE_DIVORCED => 'Divorciado(a)',
    ];
}

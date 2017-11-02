<?php

use App\Model\Custom\Slip;
use App\Model\Table\ContractsValuesTable;

$agencia = $companyData['agencia'];
$codigoCedente = $companyData['codigo_cedente'];
$codigoCedenteDv = $companyData['codigo_cedente_dv'];

$carteira = '9';
$codigoBanco = '237';
$moeda = '9';

$first = true;

/* @var $s \App\Model\Custom\Slip */
?>

<?php foreach ($slips as $s) { ?>
    <?php
    if ($s->getStatus() == Slip::PAID) {
        continue;
    }

    $vencimentoDateTime = $s->getSalary();

    $mes = $vencimentoDateTime->format('m');
    $ano = $vencimentoDateTime->format('Y');

    $codImovel = $contract['property']['formatted_code'];

    /* @var $v \App\Model\Custom\SlipValue */

    $hasMailFee = false;

    $totalBoleto = 0;
    foreach ($s->getValues() as $v) {
        $totalBoleto += $v->getValue();

        if ($v->getType() == ContractsValuesTable::MAIL_FEE) {
            $hasMailFee = true;
        }
    }

    $vencimento = $vencimentoDateTime->format('d/m/Y');

    $carteira = $this->Slips->zeroFill($carteira, 2);

    $nossoNumero = $vencimentoDateTime->format('ym') . $this->Slips->zeroFill($contract['property']['locator']['user']['username'], 4);
    $nossoNumeroCod = $this->Slips->zeroFill($nossoNumero, 11);
    $nossoNumeroDv = $this->Slips->Modulo11($carteira . $nossoNumeroCod, 7);

    $nossoNumeroP = $carteira . '/' . $nossoNumeroCod . '-' . $nossoNumeroDv;

    $numeroDocumento = $vencimentoDateTime->format('Ym') . $this->Slips->zeroFill($contract['property']['locator']['user']['username'], 4);

    $agencia = $this->Slips->zeroFill($agencia, 4);
    $codigoCedente = $this->Slips->zeroFill($codigoCedente, 7);
    $codigoCedenteDv = $this->Slips->zeroFill($codigoCedenteDv, 1);

    $campoLivre = $agencia . $carteira . $nossoNumeroCod . $codigoCedente . '0';

    $dataVencimento = new DateTime($vencimentoDateTime->format('Y-m-d'));
    $dataBase = new DateTime('1997-10-07');
    $diff = $dataVencimento->diff($dataBase);

    $fatorVencimento = $this->Slips->zeroFill($diff->days, 4);

    $valorCod = number_format($totalBoleto, 2, ',', '.');
    $valorCod = str_replace(['.', ','], '', $valorCod);
    $valorCod = $this->Slips->zeroFill($valorCod, 10);

    $codigoBanco = $this->Slips->zeroFill($codigoBanco, 3);
    $moeda = $this->Slips->zeroFill($moeda, 1);

    $ldCampo1 = $codigoBanco . $moeda . substr($campoLivre, 0, 5);
    $ldCampo1Dv = $this->Slips->Modulo10($ldCampo1);

    $ldCampo2 = substr($campoLivre, 5, 10);
    $ldCampo2Dv = $this->Slips->Modulo10($ldCampo2);

    $ldCampo3 = substr($campoLivre, 15, 10);
    $ldCampo3Dv = $this->Slips->Modulo10($ldCampo3);

    $dvCodigoBarras = $this->Slips->Modulo11($codigoBanco . $moeda . $fatorVencimento . $valorCod . $campoLivre);

    $codigoBarras = $codigoBanco . $moeda . $dvCodigoBarras . $fatorVencimento . $valorCod . $campoLivre;
    $linhaDigitavel = $ldCampo1 . $ldCampo1Dv . $ldCampo2 . $ldCampo2Dv . $ldCampo3 . $ldCampo3Dv . $dvCodigoBarras . $fatorVencimento . $valorCod;

    $codigoBancoDv = $this->Slips->Modulo11($codigoBanco);

    if ($first) {
        $first = false;
    } else {
        echo '<div class="page-break"></div>';
    }
    ?>

    <div id="boleto-header">
        <table>
            <tr>
                <td width="20%" align="center">
                    <?php echo $this->Html->image($this->CompanyData->getAppLogo(), ['width' => 78, 'height' => 36]) ?>
                </td>
                <td>
                    <h1 class="truncate-text"><?php echo $companyData['razao_social'] ?></h1>

                    <h2>Recibo de Cobrança de Aluguel</h2>
                </td>
            </tr>
        </table>
    </div>

    <div id="user-header">
        <table>
            <tr>
                <td width="25%">
                    <div class="squared">
                        <p>Cód. Imóvel: <b><?php echo $codImovel ?></b></p>

                        <p>Senha: <b><?php echo $contract['property']['locator']['password'] ?></b></p>
                    </div>
                </td>
                <td align="center">
                    Ao decidir desocupar o imóvel, entre em contato conosco pelo menos 30 dias antes para se
                    informar
                    dos
                    procedimentos necessários e agendar uma vistoria.
                </td>
            </tr>
        </table>
    </div>

    <div id="boleto-details">
        <table width="100%">
            <tr>
                <td width="76%" rowspan="8" id="boleto-items">
                    <h2>Recibo de Aluguel do Mês de <?php echo $this->Slips->monthInWords($mes) ?>
                        de <?php echo $ano ?></h2>

                    <div id="user-info">
                        <p class="truncate-text">
                            <b>Locador:</b> <?php echo sprintf('%s - %s', $this->Slips->zeroFill($contract['property']['locator']['user']['username'], 5), $contract['property']['locator']['user']['nome']) ?>
                        </p>

                        <p class="truncate-text">
                            <b>Locatário:</b> <?php echo sprintf('%s - %s', $this->Slips->zeroFill($contract['tenant']['user']['username'], 5), $contract['tenant']['user']['nome']) ?>
                        </p>

                        <p class="truncate-text">
                            <b>Imóvel:</b> <?php echo sprintf('%s - %s', $this->Slips->zeroFill($codImovel, 5), $contract['property']['full_address']) ?>
                        </p>
                    </div>

                    <h2>Dados do Recibo de Aluguel</h2>

                    <div id="boleto-values">
                        <table>
                            <tbody>
                            <?php $count = $others = 0; ?>
                            <?php foreach ($s->getValues() as $v) { ?>
                                <?php if ($count > 7) { ?>
                                    <?php $others += $v->getValue(); ?>
                                <?php } else { ?>
                                    <tr>
                                        <td><span class="truncate-text"><?php echo $v->getName() ?></span></td>
                                        <td align="right"
                                            width="15%"><?php echo $this->Slips->formatNumber($v->getValue()) ?></td>
                                    </tr>

                                    <?php $count++; ?>
                                <?php } ?>
                            <?php } ?>

                            <?php if ($others <> 0) { ?>
                                <tr>
                                    <td>Outros</td>
                                    <td align="right"
                                        width="15%"><?php echo $this->Slips->formatNumber($others) ?></td>
                                </tr>
                            <?php } ?>

                            <?php $restantRows = 9 - count($s->getValues()); ?>
                            <?php for ($i = 0; $i < $restantRows; $i++) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="right" width="10%">&nbsp;
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                            <tfoot>
                            <tr class="total">
                                <td>Total do Recibo</td>
                                <td align="right"><?php echo $this->Slips->formatNumber($totalBoleto) ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </td>
                <td width="24%" align="center">
                    <?php echo $this->Html->image('bradesco.jpg', ['width' => 55, 'height' => 38]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">Vencimento</p>

                    <p class="item-value"><?php echo $vencimento ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">Agência/Código Cedente</p>

                    <p class="item-value"><?php echo $agencia . '/' . $codigoCedente . '-' . $codigoCedenteDv ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">Nosso Número</p>

                    <p class="item-value"><?php echo $nossoNumeroP ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">(=) Valor do Documento</p>

                    <p class="item-value"><?php echo $this->Slips->formatNumber($totalBoleto) ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">(-) Desconto Abatimento</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">(+) Mora/Multa</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="item-title">(=) Valor Cobrado</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="barcode">
        <table width="100%">
            <tr>
                <td>
                    <?php echo $this->Slips->getBarCode($codigoBarras) ?>
                </td>
                <td class="barcode-authentication" width="25%">Autenticação Mecânica - Recibo do Sacado</td>
            </tr>
        </table>
    </div>

    <hr/>

    <table width="100%" id="cedente-header">
        <tr>
            <td width="10%"><?php echo $this->Html->image('bradesco.jpg', ['width' => 43, 'height' => 29]) ?></td>
            <td width="20%"><?php echo $codigoBanco . '-' . $codigoBancoDv ?></td>
            <td width="70%"><?php echo $this->Slips->getDigitableLine($linhaDigitavel) ?></td>
        </tr>
    </table>
    <table width="100%" id="cedente-data">
        <tr>
            <td width="80%" colspan="7">
                <p class="item-title">Local de Pagamento</p>

                <p class="item-value item-center">Pagável preferencialmente em qualquer Agência Bradesco até o
                    vencimento</p>
            </td>
            <td width="20%">
                <p class="item-title">Vencimento</p>

                <p class="item-value"><?php echo $vencimento ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="7">
                <p class="item-title">Beneficiário</p>

                <p class="item-value item-center">Prestadora de Serviços Santo Expedito Ltda. ME</p>
            </td>
            <td>
                <p class="item-title">Agência/Código Cedente</p>

                <p class="item-value"><?php echo $agencia . '/' . $codigoCedente . '-' . $codigoCedenteDv ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="item-title">Data Doc</p>

                <p class="item-value"><?php echo date('d/m/Y') ?></p>
            </td>
            <td colspan="2">
                <p class="item-title">Nº do Documento</p>

                <p class="item-value"><?php echo $numeroDocumento ?></p>
            </td>
            <td>
                <p class="item-title">Espécie Doc</p>

                <p class="item-value">Rec</p>
            </td>
            <td>
                <p class="item-title">Aceite</p>

                <p class="item-value">N</p>
            </td>
            <td>
                <p class="item-title">Data Proc</p>

                <p class="item-value"><?php echo date('d/m/Y') ?></p>
            </td>
            <td>
                <p class="item-title">Nosso Número</p>

                <p class="item-value"><?php echo $nossoNumeroP ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="item-title">Uso do Banco</p>

                <p class="item-value">8650</p>
            </td>
            <td>
                <p class="item-title">Cip</p>

                <p class="item-value">000</p>
            </td>
            <td>
                <p class="item-title">Carteira</p>

                <p class="item-value"><?php echo $carteira ?></p>
            </td>
            <td>
                <p class="item-title">Espécie</p>

                <p class="item-value">R$</p>
            </td>
            <td colspan="2">
                <p class="item-title">Quantidade</p>
            </td>
            <td>
                <p class="item-title">Valor</p>
            </td>
            <td>
                <p class="item-title">(=) Valor do Documento</p>

                <p class="item-value"><?php echo $this->Slips->formatNumber($totalBoleto) ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="7" rowspan="5">
                <div id="cedente-info">
                    <h2>Recibo de Aluguel do Mês de <?php echo $this->Slips->monthInWords($mes) ?>
                        de <?php echo $ano ?></h2>

                    <div id="cedente-user-info">
                        <p class="truncate-text">
                            <b>Locador:</b> <?php echo $this->Slips->zeroFill($contract['property']['locator']['user']['username'], 5) . ' - ' . $contract['property']['locator']['user']['nome'] ?>
                        </p>

                        <p class="truncate-text">
                            <b>Imóvel:</b> <?php echo $this->Slips->zeroFill($codImovel, 5) . ' - ' . $contract['property']['full_address'] ?>
                        </p>
                    </div>
                </div>
            </td>
            <td>
                <p class="item-title">(=) Outros Acréscimos</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="item-title">(-) Desconto Abatimento</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="item-title">(-) Outras Deduções</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="item-title">(+) Mora/Multa</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="item-title">(=) Valor Cobrado</p>
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <p class="item-title">Pagador</p>

                <p class="item-value item-left truncate-text"><?php echo $contract['tenant']['user']['nome'] . ' - ' . $contract['tenant']['user']['cpf_cnpj'] ?></p>

                <p class="item-value item-left truncate-text">
                    <?php
                    echo implode(', ', array_filter([
                        $contract['property']['logradouro'],
                        $contract['property']['numero'],
                        $contract['property']['complemento'],
                        $contract['property']['bairro'],
                    ]));
                    ?>
                </p>

                <p class="item-value item-left truncate-text">
                    <?php
                    echo implode(', ', array_filter([
                        $contract['property']['cidade'],
                        $contract['property']['uf'],
                        $contract['property']['cep'],
                    ]));
                    ?>
                </p>
            </td>
        </tr>
    </table>

    <div class="barcode">
        <table width="100%">
            <tr>
                <td>
                    <?php echo $this->Slips->getBarCode($codigoBarras) ?>
                </td>
                <td class="barcode-authentication" width="25%">Autenticação Mecânica - Recibo do Sacado</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <?php if ($hasMailFee) { ?>
        <div class="boxed to-center">
            Para Uso dos Correios
        </div>

        <div class="boxed mail-deliver-info">
            <table width="100%">
                <tr>
                    <td>
                        <p><span class='square'></span> Mudou-se</p>

                        <p><span class='square'></span> Endereço insuficiente</p>

                        <p><span class='square'></span> Não existe o nº indicado</p>

                        <p><span class='square'></span> Desconhecido</p>

                        <p><span class='square'></span> Recusado</p>
                    </td>
                    <td>
                        <p><span class='square'></span> Não procurado</p>

                        <p><span class='square'></span> Ausente</p>

                        <p><span class='square'></span> Falecido</p>

                        <p><span class='square'></span> Inf. escrita por terceiros</p>

                        <p><span class='square'></span></p>
                    </td>
                    <td width="30%" class="to-center">
                        <p>Reintegrado ao Serviço Postal em:</p>

                        <p>________/________/________</p>

                        <p>Assinatura e número do Entregador</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="boxed mail-deliver-extra"></div>

        <hr>

        <div class="mail-deliver-header">
            <table width="100%">
                <tr>
                    <td width="20%" class="to-center">
                        <?php echo $this->Html->image('/files/company/logo' . $companyData['logo'], ['width' => 78, 'height' => 36]) ?>
                    </td>
                    <td class="to-center">
                        <h1><?php echo $companyData['razao_social'] ?></h1>

                        <h2>Recibo de Cobrança de Aluguel</h2>
                    </td>
                    <td width="25%">
                        <p>Uso dos Correios</p>

                        <p><b>Postado em:</b></p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="mail-receiver-div">
            <div class="mail-receiver-background">
                <?php echo $this->Html->image('city.jpg') ?>
            </div>

            <div class="mail-receiver">
                <p><?php echo $contract['tenant']['user']['nome'] . ' - ' . $contract['tenant']['user']['cpf_cnpj'] ?></p>

                <p>
                    <?php
                    echo implode(', ', array_filter([
                        $contract['property']['endereco'],
                        $contract['property']['numero'],
                        $contract['property']['complemento'],
                    ]));
                    ?>
                </p>

                <p>
                    <?php
                    echo implode(', ', array_filter([
                        $contract['property']['cidade'],
                        $contract['property']['uf'],
                        $contract['property']['bairro'],
                    ]));
                    ?>
                </p>

                <p>
                    <?php echo $contract['property']['cep'] ?>
                </p>
            </div>
        </div>

        <div class="to-center">
            <?php
            echo implode(', ', array_filter([
                $companyData['endereco'],
                $companyData['numero'],
                $companyData['complemento'],
                $companyData['bairro'],
                $companyData['cidade'],
                $companyData['uf'],
                $companyData['cep'],
            ]));
            ?>
        </div>
    <?php } else { ?>
        <div>&nbsp;</div>
    <?php } ?>
<?php } ?>
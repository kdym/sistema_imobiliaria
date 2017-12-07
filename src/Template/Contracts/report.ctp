<?php

use App\Model\Table\ContractsTable;
use App\View\Helper\GlobalCombosHelper;

echo $this->Html->css(WWW_ROOT . '/css/contract-report.min.css');

?>

<div id="header">
    <table>
        <tr>
            <td id="logo">
                <img src="<?php echo $this->CompanyData->getAppAbsoluteLogo() ?>"/>
            </td>
            <td>
                <p><b><?php echo $companyData['razao_social'] ?></b></p>

                <p>
                    <?php echo implode(', ', array_filter([
                        $companyData['endereco'],
                        $companyData['numero'],
                        $companyData['complemento'],
                        $companyData['bairro'],
                        $companyData['cidade'],
                        $companyData['uf'],
                        $companyData['cep'],
                    ])) ?>
                </p>

                <p>
                    <?php echo implode(' - ', array_filter([
                        'CNPJ ' . $companyData['cnpj'],
                        'ABADI ' . $companyData['abadi'],
                        'CRECI ' . $companyData['creci'],
                    ])) ?>
                </p>

                <p>
                    <?php echo implode(' / ', array_filter([
                        $companyData['telefone_1'],
                        $companyData['telefone_2'],
                        $companyData['telefone_3'],
                    ])) ?>
                </p>

                <p><?php echo $companyData['email'] ?></p>
            </td>
        </tr>
    </table>
</div>

<div id="footer">
    Página <span class="page-number"></span>
</div>

<div id="main">
    <h1>CONTRATO PARTICULAR DE LOCAÇÃO</h1>

    <p>
        <?php
        if (strlen($contract['property']['locator']['user']['cpf_cnpj']) > 14) {
            $cpfCnpjLocator = 'CNPJ ' . $contract['property']['locator']['user']['cpf_cnpj'];
        } else {
            $cpfCnpjLocator = 'CPF ' . $contract['property']['locator']['user']['cpf_cnpj'];
        }

        $locatorAddress = implode(', ', array_filter([
            $contract['property']['locator']['user']['endereco'],
            $contract['property']['locator']['user']['numero'],
            $contract['property']['locator']['user']['complemento'],
            $contract['property']['locator']['user']['bairro'],
            $contract['property']['locator']['user']['cidade'],
            $contract['property']['locator']['user']['uf'],
            $contract['property']['locator']['user']['cep'],
        ]));

        if (strlen($contract['tenant']['user']['cpf_cnpj']) > 14) {
            $cpfCnpjTenant = 'CNPJ ' . $contract['tenant']['user']['cpf_cnpj'];
        } else {
            $cpfCnpjTenant = 'CPF ' . $contract['tenant']['user']['cpf_cnpj'];
        }

        $propertyAddress = implode(', ', array_filter([
            $contract['property']['endereco'],
            $contract['property']['numero'],
            $contract['property']['complemento'],
            $contract['property']['bairro'],
            $contract['property']['cidade'],
            $contract['property']['uf'],
            $contract['property']['cep'],
        ]));

        $spouse = '';

        if ($contract['tenant']['user']['estado_civil'] == GlobalCombosHelper::CIVIL_STATE_MARRIED) {
            if (!empty($contract['tenant']['user']['spouse']['nome'])) {
                $spouse = ' com <b>' . $contract['tenant']['user']['spouse']['nome'] . '</b>';

                if (!empty($contract['tenant']['user']['spouse']['cpf'])) {
                    $spouse .= ', CPF <b>' . $contract['tenant']['user']['spouse']['cpf'] . '</b>';
                }
            }
        }
        ?>

        Por este instrumento particular e na melhor forma de direito,
        <b><?php echo $contract['property']['locator']['user']['nome'] ?></b>, <b><?php echo $cpfCnpjLocator ?></b>,
        localizado em <b><?php echo $locatorAddress ?></b>, adiante designado abreviadamente <b>LOCADOR</b>, neste ato
        representado por seu bastante procurador <b><?php echo $companyData['razao_social'] ?></b>, dá em locação
        <b><?php echo $contract['tenant']['user']['nome'] ?></b>, <b><?php echo $cpfCnpjTenant ?></b>,
        <b><?php echo GlobalCombosHelper::$civilStates[$contract['tenant']['user']['estado_civil']] ?></b><?php echo $spouse ?>
        , a seguir
        denominado simplesmente <b>LOCATÁRIO</b>, o imóvel de posse do <b>LOCADOR</b>, sito
        <b><?php echo $propertyAddress ?></b>, mediante cláusulas e condições:
    </p>

    <?php $clause = 0; ?>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - A locação é pelo prazo de
        <b><?php echo $this->Contracts->formatNumberInWords($contract['isencao']) ?>
            <?php echo __('{0, plural, =1{mês} other{meses}}', [$contract['isencao']]) ?>, com reajuste anual ou o menor
            prazo permitido por lei</b>, a contar de
        <b><?php echo $this->Contracts->dateInWords($contract['data_inicio']->format('Y-m-d')) ?></b>, independente de
        qualquer aviso, notificação ou interpelação judicial ou extra-judicial. Com a antecedência
        de <b>60 (sessenta) dias</b> antes do término do prazo acima especificado, deverá o <b>LOCATÁRIO</b>
        procurar o
        setor de renovação da imobiliária, para estudar a possibilidade da renovação ou não do prazo ora contratado.
        Não
        sendo celebrado novo contrato, o <b>LOCATÁRIO</b> está obrigado a restituir o imóvel neste último dia, nas
        condições adiante previstas, ou será considerada a locação prorrogada por tempo indeterminado,
        continuando em vigor todas as obrigações legais e contratuais, ressalvando ao <b>LOCADOR</b> a retomada.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O aluguel mensal é fixado em
        <b><?php echo $this->Contracts->formatCurrencyInWords($propertyPrice['valor']) ?>,
            TENDO
            REAJUSTE
            PELO IPC/DI DO RIO DE JANEIRO da FGV, OU NA FALTA DESTE, DE ACORDO COM A LEI</b>, devendo ser pago
        juntamente com os demais encargos, em moeda corrente nacional ou cheque do locatário, através de boleta
        bancária, que será enviada pelo correio até o dia
        <b><?php echo $this->Contracts->formatNumberInWords($contractValues['vencimento_boleto']) ?></b>
        de
        cada
        mês, ficando, em caso
        contrário,
        acrescido de juros de mora e correção após <b>30 (trinta) dias</b>.
    </p>

    <?php $paragraph = 0; ?>

    <?php if (!empty($contractValues['desconto'])) { ?>
        <p>
            <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - O pagamento dentro do
            prazo acima dará direito a um desconto de
            <b><?php echo $this->Contracts->formatPercentInWords($contractValues['desconto']) ?></b> a título de
            bonificação.
        </p>
    <?php } ?>

    <?php if (!empty($contractValues['multa'])) { ?>
        <p>
            <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - O pagamento após o
            prazo
            acima acarretará em multa de
            <b><?php echo $this->Contracts->formatPercentInWords($contractValues['multa']) ?></b>.
        </p>
    <?php } ?>

    <p>
        <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - Terminado o prazo do
        presente
        contrato, sem a desocupação do imóvel, os aumentos, enquanto convier ao <b>LOCADOR</b> a locação,
        serão de acordo com a lei, sempre sobre o valor do aluguel que vigorou no último mês do período anterior de
        locação.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Serão às expensas do
        <b>LOCATÁRIO</b>
        as taxas de água, luz, manutenção, condomínio ou rateio dessas despesas em prédio com mais de uma unidade,
        taxa
        de incêndio do corpo de bombeiros do governo do Estado Do Rio De Janeiro, imposto predial territorial urbano
        e
        frações ideais de áreas comuns, tarifa bancária e despesas de postagem das boletas, prêmio de seguro contra
        fogo
        sobre o imóvel, cuja apólice deverá ser em nome do proprietário, tendo como base de cálculo <b>100 (cem)
            vezes</b> o valor do aluguel em vigência, renovado a cada ano, ficando estabelecido que o locatário
        terá <b>30 (trinta) dias</b>, a partir do início da locação ou vencimento da última apólice, para a
        contratação ou renovação do seguro e apresentação da apólice; após esse prazo o <b>LOCADOR</b> ou seu
        procurador poderá fazer o seguro e lançar na boleta do <b>LOCATÁRIO</b> para o pagamento junto com o
        aluguel, bem como quaisquer outras taxas que incidem ou vierem a incidir sobre o referido imóvel. Onde
        houver
        mais de um imóvel no lote, e o medidor de água ou luz elétrica for dividido por mais de um usuário, será a
        despesa dividida para estes, em partes iguais.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> – A impontualidade no pagamento dos encargos, despesas ordinárias de
        condomínio, tributos e demais despesas especificadas nesta cláusula importará em infração grave, bem como
        sujeitará o locatário ao pagamento de multa de <b>2% (dois por cento)</b>. Após <b>30 (trinta)
            dias</b> será cobrada correção monetária determinada por lei e juros moratórios de <b>1% (um por
            cento) ao mês</b> a partir do vencimento.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Correrão por conta do
        <b>LOCATÁRIO</b>
        todas as despesas judiciais ou extrajudiciais do presente contrato, as da retomada do imóvel, as referentes
        à
        regularização e formalização deste, os honorários e aquelas que venham a ser divididas pela sua prorrogação
        legal ou convencional.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O pagamento de todas as
        despesas a
        que estiver obrigado o <b>LOCATÁRIO</b>, por força de lei ou do presente contrato, deverá ser feito
        independente de qualquer notificação judicial ou extrajudicial, nos prazos convencionados ou tão logo forem
        exigidos.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> – O não pagamento constituirá o <b>LOCATÁRIO</b> em mora, podendo a
        cobrança ser efetuada através do Departamento Jurídico da
        <b><?php echo $companyData['razao_social'] ?></b>; onde, além das
        multas
        contratuais, serão cobrados honorários advocatícios, ou simplesmente será movida a competente ação de
        despejo,
        independente de qualquer aviso.
    </p>

    <p>
        <?php $finality = (!empty($contract['finalidade_nao_residencial'])) ? ' de ' . $contract['finalidade_nao_residencial'] : ''; ?>

        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O imóvel locado se destina à
        locação
        <b><?php echo ContractsTable::$finalities[$contract['finalidade']] . $finality ?></b>,
        não podendo ser utilizado para outros fins sem o prévio e expresso consentimento do <b>LOCADOR</b>.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> - No caso de locação com fins não residenciais, cabe ao
        <b>LOCATÁRIO</b> consultar os órgãos competentes sobre autorização para funcionamento no local de
        firma com o ramo que pretende iniciar, não cabendo ao <b>LOCADOR</b> qualquer responsabilidade ou
        indenização, no caso de ser negada alguma autorização de qualquer órgão ou multas destes órgãos.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b>
        declara haver recebido o imóvel objeto da presente locação, de acordo com o Termo de Vistoria anexo, que passa a
        fazer parte integrante deste Contrato, com o qual concorda e aceita. Qualquer reclamação que venha a divergir do
        Termo de Vistoria, no que diz respeito ao funcionamento das instalações elétricas e hidráulicas, vidros, fechos,
        fechaduras, chaves, deverá ser feita por escrito, no prazo de <b>05 (cinco) dias</b>, a contar do
        início desta locação.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b>
        obriga-se a manter o imóvel sempre limpo, durante a locação, fazendo à sua custa, sem direito a qualquer
        indenização, todos os reparos e consertos de que necessite e a restituí-lo quando finda ou rescindida a locação,
        nas mesmas condições de habitabilidade em que o recebeu, com as paredes, tetos, portas, portais e janelas nas
        cores e tintas de idênticas qualidades e tonalidades daquelas de quando recebeu as chaves do imóvel, tudo de
        acordo com o Termo de Vistoria.
    </p>

    <?php if (!empty($contract['guarantors'])) { ?>
        <?php $paragraph = 0; ?>

        <p>
            <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - Caso o
            <b>LOCATÁRIO</b> não entregue o imóvel nas condições em que o recebeu, ficará o
            <b>LOCADOR</b> autorizado a reparar os danos encontrados, para posterior cobrança e recebimento do
            <b>LOCATÁRIO e/ou FIADORES</b>.
        </p>

        <p>
            <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - Na restituição do imóvel,
            o aluguel e demais encargos continuarão a correr por conta do <b>LOCATÁRIO</b> até que este o
            entregue nas mesmas e perfeitas condições em que o recebeu.
        </p>
    <?php } else { ?>
        <p>
            <b>PARÁGRAFO ÚNICO</b> – Na restituição do imóvel, o aluguel e demais encargos continuarão a
            correr por conta do <b>LOCATÁRIO</b> até que este o entregue nas mesmas e perfeitas condições em
            que o recebeu.
        </p>
    <?php } ?>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b> fica
        responsável pelo cumprimento das exigências resultantes das leis sanitárias, bem como pelas multas que
        porventura sejam impostas, desde que tais multas sejam conseqüências do uso do imóvel pelo
        <b>LOCATÁRIO</b>.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - É vedado ao
        <b>LOCATÁRIO</b> fazer quaisquer obras ou benfeitorias no prédio locado ou em suas dependências, sem o
        prévio e expresso consentimento do <b>LOCADOR</b>, bem como colocar placas ou letreiros na fachada
        onde for impróprio o seu uso.
    </p>

    <?php $paragraph = 0; ?>

    <p>
        <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - O <b>LOCATÁRIO</b> não terá
        direito à retenção ou indenização
        por quaisquer obras ou benfeitorias, mesmo necessárias que, embora com o consentimento escrito do <b>LOCADOR</b>,
        venha a fazer no imóvel ou em suas instalações e utensílios.
    </p>

    <p>
        <b><?php echo $this->Contracts->paragraph(++$paragraph) ?></b> - Caso não convier ao <b>LOCADOR</b>
        a permanência de qualquer benfeitorias ou modificações feitas pelo <b>LOCATÁRIO</b> no aludido imóvel
        ou em suas dependências e instalações, deverá este removê-las à sua custa, deixando o imóvel no estado em que se
        achava antes da locação.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b> é
        obrigado a respeitar os direitos de vizinhança, evitando a prática de quaisquer atos que venham perturbar a
        tranquilidade e as condições de saúde pública, bem como a observar o regulamento de edifício e respectiva
        convenção de condomínio, onde houver.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Fica reservado ao
        <b>LOCADOR</b>, seu procurador ou representante, o direito de vistoriar o imóvel ora locado, sempre
        que julgarem conveniente.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Caso o imóvel seja posto à venda, o
        <b>LOCATÁRIO</b> permitirá as visitas dos pretendentes ao mesmo.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - No caso de venda do imóvel, a
        preferência será do <b>LOCATÁRIO</b>, que, após o recebimento do comunicado de venda, terá <b>30 (trinta)
            dias</b> para se manifestar; não o fazendo, o imóvel fica liberado para venda a qualquer outra pessoa.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b> não
        poderá, sem o consentimento prévio e escrito do <b>LOCADOR</b>, ceder, emprestar, transferir ou
        sublocar, a título oneroso ou gratuito, em todo ou em parte, o imóvel locado.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> – Autorizada a cessão ou a sublocação, continuará o <b>LOCATÁRIO</b>
        sempre responsável por todas as obrigações deste contrato.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Qualquer tolerância do
        <b>LOCADOR</b>,
        quanto ao disposto nas cláusulas contratuais, não constituirá precedente a ser invocado e não terá a virtude de
        alterar as obrigações estipuladas neste instrumento.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - O <b>LOCATÁRIO</b> não
        terá direito a reter o pagamento do aluguel ou de qualquer outra quantia devida nos termos do presente contrato,
        sob a alegação de não terem sido atendidas exigências porventura solicitadas.
    </p>

    <!-- Garantias do Contrato -->

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Em hipótese alguma poderá o
        <b>LOCATÁRIO</b> pretender a devolução das chaves dentro dos seis primeiros meses do período inicial
        de locação. Entretanto, se o <b>LOCADOR</b> consentir, poderá devolver no período restante do prazo
        inicial, ficando obrigado a pagar, a título de indenização, o valor correspondente a três alugueres vigentes na
        ocasião, observadas todas as demais obrigações legais e contratuais.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> – O <b>LOCATÁRIO</b> deverá comunicar por escrito, o
        <b>LOCADOR</b> ou seu procurador, com a antecedência de <b>30 (trinta) dias</b>, a data de
        devolução do imóvel.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - A falta de cumprimento de qualquer
        uma das cláusulas deste contrato sujeitará o infrator ao pagamento da multa equivalente a <b>3 (três)
            aluguéis mensais vigentes na data da infração</b>, em benefício da parte prejudicada, e dos honorários
        advocatícios, estes na base de <b>20% (vinte por cento) sobre o valor da causa</b>, sem prejuízo da
        exigibilidade das obrigações assumidas por este instrumento, podendo o inocente, se assim lhe aprouver,
        considerar ao mesmo tempo rescindido o presente, independente de qualquer formalidade.
    </p>

    <p>
        <b>PARÁGRAFO ÚNICO</b> – Também poderão motivar a rescisão os seguintes fatos:
    </p>

    <ol type="a">
        <li>concordata ou falência do <b>LOCATÁRIO</b>;</li>
        <li>se o imóvel for destruído parcial ou totalmente por incêndio ou qualquer outro fator;</li>
        <li>se o imóvel for desapropriado;</li>
        <li>se o <b>LOCATÁRIO</b> não pagar pontualmente qualquer das prestações mensais do aluguel e encargos
            ou faltar ao exato cumprimento de qualquer das obrigações ora assumidas;
        </li>
        <li>se o <b>LOCATÁRIO</b> usar o imóvel objeto deste contrato para fim diverso daquele para que foi
            locado;
        </li>
        <li>se o <b>LOCATÁRIO</b> não respeitar os direitos da vizinhança e/ou atentar contra a moral e os
            bons costumes.
        </li>
    </ol>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Fica terminantemente proibido ao
        <b>LOCATÁRIO</b> de fazer qualquer benfeitoria no imóvel.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - As partes convencionam desde já que
        qualquer controvérsia que surja ou esteja relacionada a este contrato será resolvida no Foro de Volta
        Redonda/RJ, renunciando as partes contratantes a qualquer outro, seja qual for o seu futuro domicílio.
    </p>

    <p>
        <b><?php echo $this->Contracts->clause(++$clause) ?></b> - Na devolução das chaves, deverá o
        <b>LOCATÁRIO</b> apresentar os recibos de quitação com o SAAE, LIGHT, condomínio e IPTU.
    </p>

    <!-- Cláusulas Extras -->

    <div class="page-break"></div>

    <p>
        E, por estarem justos e contratados, aceitam, assinam e ratificam o presente, lavrado em 02 (duas) vias de igual
        teor e forma, diante das testemunhas presentes que declaram que os dados pessoais acima (locatário e fiadores)
        são verdadeiros e que foi lido e entendido todas as cláusulas por todo pólo passivo.
    </p>

    <p class="to-right">
        Volta Redonda, <?php echo $this->Contracts->dateInWords($contract['created']->format('Y-m-d')) ?>
    </p>

    <?php
    $signatures = [];

    $signatures[] = [
        'key' => 'Proprietário',
        'name' => $contract['property']['locator']['user']['nome']
    ];

    $signatures[] = [
        'key' => 'Locatário',
        'name' => $contract['tenant']['user']['nome']
    ];

    if ($contract['tenant']['user']['estado_civil'] == GlobalCombosHelper::CIVIL_STATE_MARRIED) {
        if (!empty($contract['tenant']['user']['spouse']['nome'])) {
            $signatures[] = [
                'key' => 'Cônjuge',
                'name' => $contract['tenant']['user']['spouse']['nome']
            ];
        }
    }

    //Fiadores
    ?>

    <table class="signatures">
        <?php
        $first = true;

        foreach ($signatures as $key => $s) {
            if ($first) {
                $first = false;

                echo '<tr>';
                echo '<td width="50%">';
                echo '<div class="signature">';
            } else {
                if ($key % 2 == 0) {
                    echo '</tr><tr>';
                    echo '<td width="50%">';
                    echo '<div class="signature">';
                } else {
                    echo '<td width="50%">';
                    echo '<div class="signature">';
                }
            }

            echo '<p>' . $s['name'] . '</p>';
            echo '<p>' . $s['key'] . '</p>';

            echo '</div>';
            echo '</td>';
        }

        echo '</tr>';
        ?>

        <tr>
            <td width="50%">
                <div class="signature">
                    <p>Testemunha</p>

                    <p>Nome</p>

                    <p>CPF</p>
                </div>
            </td>
            <td width="50%">
                <div class="signature">
                    <p>Testemunha</p>

                    <p>Nome</p>

                    <p>CPF</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>

    <title>Sistema de Imobiliária</title>

    <?= $this->Html->meta('icon') ?>

    <?php echo $this->Html->css('contract-report.min') ?>
</head>

<body>

<div id="header">
    <div id="header-container">
        <div id="logo">
            <img src="<?php echo $this->CompanyData->getAppLogo() ?>"/>
        </div>

        <div id="titles">
            <h1><?php echo $companyData['razao_social'] ?></h1>

            <h2>
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
            </h2>

            <h3>
                <p>
                    <?php echo implode(' / ', array_filter([
                        $companyData['telefone_1'],
                        $companyData['telefone_2'],
                        $companyData['telefone_3'],
                    ])) ?>
                </p>

                <p><?php echo $companyData['email'] ?></p>
            </h3>
        </div>
    </div>
</div>

<main>
    <?php echo $this->fetch('content') ?>
</main>

<script>
    window.print();
</script>

</body>
</html>
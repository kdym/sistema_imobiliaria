$('#locators-list').DataTable({
    order: [[0, 'asc']],
    columnDefs: [
        {orderable: false, targets: [3]}
    ],
    responsive: true
});

$('#cep').blur(function () {
    getCep($(this), function (data) {
        $('#endereco').val(data.logradouro);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.localidade);
        $('#uf').val(data.uf);
    });
});

if ($('#married-box').length) {
    getCivilState();
}

$('#estado-civil').change(function () {
    getCivilState();
});

if ($('#locator-em-maos').length) {
    getInHandsCondition();
}

$('#locator-em-maos').click(function () {
    getInHandsCondition();
});

$.validator.addMethod('isMarried', function (value, element) {
    if ($('#estado-civil').val() == $('#married-box').data('accepted-choice')) {
        return value != '';
    }

    return true;
}, 'Campo Obrigatório');

$('#locators-form').validate({
    rules: {
        'locator[nome_conjuge]': 'isMarried',
        'locator[cpf_conjuge]': 'isMarried',
        'locator[data_nascimento_conjuge]': 'isMarried',
        'locator[banco]': {
            required: '#locator-em-maos:not(:checked)'
        },
        'locator[agencia]': {
            required: '#locator-em-maos:not(:checked)'
        },
        'locator[conta]': {
            required: '#locator-em-maos:not(:checked)'
        }
    }
});

function getCivilState() {
    $('#married-box').hide();

    if ($('#estado-civil').val() == $('#married-box').data('accepted-choice')) {
        $('#married-box').fadeIn();
    }
}

function getInHandsCondition() {
    if ($('#locator-em-maos').prop('checked')) {
        $('#locator-banco').attr('readonly', true);
        $('#locator-agencia').attr('readonly', true);
        $('#locator-conta').attr('readonly', true);
        $('#locator-beneficiario').attr('readonly', true);
    } else {
        $('#locator-banco').attr('readonly', false);
        $('#locator-agencia').attr('readonly', false);
        $('#locator-conta').attr('readonly', false);
        $('#locator-beneficiario').attr('readonly', false);
    }
}
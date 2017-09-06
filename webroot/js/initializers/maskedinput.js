var CEP_MASK = '99999-999';
var CNPJ_MASK = '99.999.999/9999-99';
var CPF_MASK = '999.999.999-99';
var CPF_OPTIONAL_MASK = '999.999.999-99[9]';
var PHONE_DDD_8_DIGITS_MASK = '(99) 9999[9]-9999';
var PHONE_DDD_9_DIGITS_MASK = '(99) 9999-9999[9]';
var DATE_MASK = '99/99/9999';

var CPF_LENGTH = 11;
var CEP_LENGTH = 8;
var PHONE_DDD_8_DIGITS_LENGTH = 10;

var VIACEP_URL = '//viacep.com.br/ws/';

// var datepicker = $.fn.datepicker.noConflict();
// $.fn.bootstrapDatePicker = datepicker;

$('.cep-mask').inputmask(CEP_MASK);
$('.cpf-mask').inputmask(CPF_MASK);

$('.cpf-cnpj-mask').keyup(function () {
    if ($(this).inputmask('unmaskedvalue').length > CPF_LENGTH) {
        $(this).inputmask('remove');
        return $(this).inputmask(CNPJ_MASK);
    } else {
        $(this).inputmask('remove');
        return $(this).inputmask({
            mask: CPF_OPTIONAL_MASK,
            greedy: false
        });
    }
});

$('.phone-ddd-mask').keyup(function () {
    if ($(this).inputmask('unmaskedvalue').length > PHONE_DDD_8_DIGITS_LENGTH) {
        $(this).inputmask('remove');
        return $(this).inputmask(PHONE_DDD_8_DIGITS_MASK);
    } else {
        $(this).inputmask('remove');
        return $(this).inputmask({
            mask: PHONE_DDD_9_DIGITS_MASK,
            greedy: false
        });
    }
});

$('.date-mask').inputmask(DATE_MASK);

function getCep(cep, callback) {
    var cep = $(cep).inputmask('unmaskedvalue');

    if (cep.length == CEP_LENGTH) {
        $.getJSON(VIACEP_URL + cep + '/json/', function (data) {
            callback(data);
        });
    }
}

// $('.mask-money').maskMoney({
//     prefix: 'R$ ',
//     affixesStay: false,
//     thousands: '.',
//     decimal: ',',
//     allowEmpty: true
// });
//
// $('.mask-number').maskMoney({
//     thousands: '.',
//     decimal: ',',
//     allowEmpty: true
// });
//
// $('.datepicker').bootstrapDatePicker({
//     language: 'pt-BR'
// });
// $('.datepicker').inputmask(DATE_MASK);
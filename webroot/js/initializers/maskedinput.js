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
$('.cnpj-mask').inputmask(CNPJ_MASK);

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

$('.mask-money').maskMoney({
    prefix: 'R$ ',
    affixesStay: false,
    thousands: '.',
    decimal: ',',
    allowEmpty: true
});

$('.mask-money-negative').maskMoney({
    prefix: 'R$ ',
    affixesStay: false,
    thousands: '.',
    decimal: ',',
    allowEmpty: true,
    allowNegative: true
});

$('.mask-number').maskMoney({
    thousands: '.',
    decimal: ',',
    allowEmpty: true
});

$(".number-only").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$('.date-picker').datepicker({
    language: 'pt-BR',
    todayHighlight: true
});
$('.date-picker').inputmask(DATE_MASK);

$('.date-range-picker').daterangepicker({
    locale: datePickerRangeLocale['pt-BR']
});
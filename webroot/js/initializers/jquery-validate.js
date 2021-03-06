jQuery.extend(jQuery.validator.messages, {
    required: "Campo Obrigatório.",
    remote: "Por favor, corrija este campo.",
    email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
    url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
    date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
    dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
    number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
    digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
    creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
    equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
    accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
    maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
    range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
    max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
    min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}."),
    validDate: "Data inválida.",
    validPeriod: "Período inválido.",
    dateFormat: 'DD/MM/YYYY'
});

$.validator.addMethod('validDate', function (value, element) {
    return this.optional(element) || moment(value, $.validator.messages.dateFormat).isValid();
}, $.validator.messages.validDate);

$.validator.addMethod('validPeriod', function (value, element, params) {
    var startDate = moment($('input[name="' + params[0] + '"]').val(), $.validator.messages.dateFormat);
    var endDate = moment($('input[name="' + params[1] + '"]').val(), $.validator.messages.dateFormat);

    if (startDate > endDate) {
        return false;
    }

    return true;
}, $.validator.messages.validPeriod);
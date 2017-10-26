$('#add-fee-form').validate();

setMoneyMasks();

$('#new-fee-button').click(function () {
    addFee();
});

$('#recursive-all-option').click(function () {
    $('.recursive-inputs').val('');
    $('.recursive-inputs').attr('readonly', 'readonly');
});

$('#recursive-start-at-option').click(function () {
    $('.recursive-inputs').val('');
    $('.recursive-inputs').attr('readonly', 'readonly');

    $('#start-at-input').removeAttr('readonly');
});

$('#recursive-period-option').click(function () {
    $('.recursive-inputs').val('');
    $('.recursive-inputs').attr('readonly', 'readonly');

    $('#period-input').removeAttr('readonly');
});

$('#recursive-fee-form').validate({
    rules: {
        'name': 'required',
        'value': 'required',
        'start_at_input': {
            required: function () {
                return $('#recursive-start-at-option').prop('checked');
            }
        },
        'period_input': {
            required: function () {
                return $('#recursive-period-option').prop('checked');
            }
        }
    }
});

$('.delete-custom-button').click(function () {
    deleteCustom(this);

    return false;
});

$('[data-pay-slip]').click(function () {
    paySlip(this);

    return false;
});

$('#pay-multiple-button').click(function () {
    payMultipleSlips();

    return false;
});

if ($('#pay-multiple-modal').length) {
    checkPayMultipleSlipsInputs();

    $.validator.addMethod('validPeriodPayMultiple', function (value, element) {
        if ($('#pay-multiple-choice-period').prop('checked')) {
            var startDate = moment($('#multiple-start-date').val(), $.validator.messages.dateFormat);
            var endDate = moment($('#multiple-end-date').val(), $.validator.messages.dateFormat);

            if (startDate > endDate) {
                return false;
            }
        }

        return true;
    }, $.validator.messages.validPeriod);

    $('#pay-multiple-form').validate({
        rules: {
            'multiple_until_date': {
                required: function () {
                    return $('#pay-multiple-choice-until').prop('checked');
                },
                validDate: function () {
                    return $('#pay-multiple-choice-until').prop('checked');
                }
            },
            'multiple_start_date': {
                required: function () {
                    return $('#pay-multiple-choice-period').prop('checked');
                },
                validDate: function () {
                    return $('#pay-multiple-choice-period').prop('checked');
                }
            },
            'multiple_end_date': {
                required: function () {
                    return $('#pay-multiple-choice-period').prop('checked');
                },
                validDate: function () {
                    return $('#pay-multiple-choice-period').prop('checked');
                },
                'validPeriodPayMultiple': true
            }
        }
    });
}

$('input[name="pay_multiple_choice"]').click(function () {
    checkPayMultipleSlipsInputs();
});

function addFee() {
    $('#new-fee-template').tmpl().appendTo('#fees-container');

    setMoneyMasks();
}

function setMoneyMasks() {
    // $('#add-fee-form').validate({
    //     rules: {
    //         'name[]': 'required'
    //     }
    // });
    //
    // $('input[name="name[]"]').each(function () {
    //     $(this).rules('add', {
    //         required: true
    //     });
    // });

    $('input[name="value[]"]').each(function () {
        // $(this).rules('add', 'required');

        $(this).maskMoney({
            prefix: 'R$ ',
            affixesStay: false,
            thousands: '.',
            decimal: ',',
            allowEmpty: true,
            allowNegative: true
        });
    });
}

function deleteCustom(element) {
    $('#delete-custom-hidden-id').val($(element).data('custom-id'));

    $('#delete-custom-modal').modal('show');
}

function paySlip(element) {
    var salary = $(element).data('pay-slip');

    $('#pay-slip-salary').html(salary);

    $('#pay-slip-salary-hidden').val(salary);

    $('#pay-slip-calendar').datepicker({
        language: 'pt-BR',
        todayHighlight: true,
        endDate: '0d'
    }).on('changeDate', function (e) {
        $('#pay-slip-selected-date').val(e.date.getDate() + '/' + (e.date.getMonth() + 1) + '/' + e.date.getFullYear());
    });

    $('#pay-slip-modal').modal('show');
}

function payMultipleSlips() {
    $('#pay-multiple-modal').modal('show');
}

function checkPayMultipleSlipsInputs() {
    $('#multiple-until-date').attr('readonly', true);
    $('#multiple-start-date').attr('readonly', true);
    $('#multiple-end-date').attr('readonly', true);

    $('#multiple-until-date').val('');
    $('#multiple-start-date').val('');
    $('#multiple-end-date').val('');

    if ($('#pay-multiple-choice-until').prop('checked')) {
        $('#multiple-until-date').removeAttr('readonly');
    }

    if ($('#pay-multiple-choice-period').prop('checked')) {
        $('#multiple-start-date').removeAttr('readonly');
        $('#multiple-end-date').removeAttr('readonly');
    }
}
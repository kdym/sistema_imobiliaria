$('#add-fee-form').validate();

setMoneyMasks();

$('#new-fee-button').click(function () {
    addFee();
});

$('#recursive-none-option').click(function () {
    $('.recursive-inputs').val('');
    $('.recursive-inputs').attr('readonly', 'readonly');

    $('#specific-date').removeAttr('readonly');
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

    $('#period-start-date').removeAttr('readonly');
    $('#period-end-date').removeAttr('readonly');
});

$('#recursive-fee-form').validate({
    ignore: [],
    rules: {
        'category_hidden': 'required',
        'name': 'required',
        'value': 'required',
        'specific_date': {
            required: function () {
                return $('#recursive-none-option').prop('checked');
            }
        },
        'start_at_input': {
            required: function () {
                return $('#recursive-start-at-option').prop('checked');
            }
        },
        'period_start_date': {
            required: function () {
                return $('#recursive-period-option').prop('checked');
            }
        },
        'period_end_date': {
            required: function () {
                return $('#recursive-period-option').prop('checked');
            },
            validPeriod: ['period_start_date', 'period_end_date']
        }
    },
    'messages': {
        'category_hidden': 'Tipo Inválido'
    },
    'errorPlacement': function (error, element) {
        switch (element.attr('name')) {
            case 'category_hidden':
                error.insertAfter('#category');

                break;
            default:
                error.insertAfter(element);
        }
    }
});

if ($('#category').length) {
    $('#category').autocomplete({
        source: $('#category').data('valids'),
        select: function (event, ui) {
            $('#category').val(ui.item.label);
            $('#category-hidden').val(ui.item.value);

            return false;
        }
    });
}

$('.delete-custom-button').click(function () {
    deleteCustom(this);

    return false;
});

$('.slip-pay-button').click(function () {
    paySlip(this);

    return false;
});

$('.slip-unpay-button').click(function () {
    unpaySlip(this);

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

$('#contract-bills-list').DataTable({
    order: [[0, 'asc']],
    columnDefs: [
        {orderable: false, targets: [3]}
    ],
    responsive: true
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
    var slip = $(element).data('slip');
    var salary = moment(slip.salary);

    $('#pay-slip-salary').html(salary.format('DD/MM/YYYY'));
    $('#pay-slip-hidden').val(JSON.stringify(slip));

    // $('#pay-slip-salary-hidden').val(salary);

    $('#pay-slip-calendar').datepicker({
        language: 'pt-BR',
        todayHighlight: true,
        endDate: '0d'
    }).on('changeDate', function (e) {
        $('#pay-slip-selected-date').val(e.date.getFullYear() + '-' + (e.date.getMonth() + 1) + '-' + e.date.getDate());
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

function unpaySlip(element) {
    if (confirm('Tem certeza que deseja desfazer este pagamento?')) {
        $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
        $(element).prop('disabled', true);
        $(element).unbind('click');
        $(element).click(function () {
            return false;
        });

        $.ajax({
            url: '/slips/un-pay-slip',
            data: $(element).data('slip'),
            type: 'post',
            success: function () {
                location.reload();
            }
        });
    }
}
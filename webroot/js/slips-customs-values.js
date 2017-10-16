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
$('#parameters-form').validate({
    rules: {
        'slip_lock': {
            range: [1, 30]
        }
    },
    'messages': {
        'slip_lock': {
            range: 'Dia inválido'
        }
    }
});
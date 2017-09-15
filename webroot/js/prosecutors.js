$('#cep').blur(function () {
    getCep($(this), function (data) {
        $('#endereco').val(data.logradouro);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.localidade);
        $('#uf').val(data.uf);
    });
});

if ($('#search-prosecutor').length) {
    $('#search-prosecutor').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/users/fetch.json",
                data: {
                    name: request.term
                },
                dataType: 'json',
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            setProsecutor(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        var data = {
            name: item.nome,
            username: item.formatted_username
        };

        return $('<li>')
            .append($('#prosecutors-search-template').tmpl(data))
            .appendTo(ul);
    };
}

function setProsecutor(userId) {
    if (confirm('Tem certeza que deseja selecionar esse Procurador?')) {
        startLoading('#search-prosecutors-box');

        $.ajax({
            url: "/prosecutors/add-existing.json",
            data: {
                user_id: userId,
                locator_id: $('#locator-id').val()
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                switch (data) {
                    case 'ok':
                        location.href = '/users/view/' + $('#user-id').val();

                        break;

                    case 'exists':
                        alert('Procurador já cadastrado');

                        stopLoading('#search-prosecutors-box');

                        break;
                }
            }
        });
    }
}
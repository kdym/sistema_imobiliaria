$('#cep').blur(function () {
    getCep($(this), function (data) {
        $('#endereco').val(data.logradouro);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.localidade);
        $('#uf').val(data.uf);
    });
});

if ($('#search-user').length) {
    $('#search-user').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/guarantors/fetch-users.json",
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
            setGuarantor(ui.item.id);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        var data = {
            name: item.nome,
            username: item.formatted_username
        };

        return $('<li>')
            .append($('#users-search-template').tmpl(data))
            .appendTo(ul);
    };
}

if ($('#married-box').length) {
    getCivilState();

    $('#estado-civil').change(function () {
        getCivilState();
    });
}

function setGuarantor(userId) {
    if (confirm('Tem certeza que deseja selecionar esse Fiador?')) {
        startLoading('#search-users-box');

        $.ajax({
            url: "/guarantors/add-existing.json",
            data: {
                user_id: userId,
                contract_id: $('#contract-id').val()
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                switch (data) {
                    case 'ok':
                        location.href = '/contracts/view/' + $('#contract-id').val();

                        break;

                    case 'exists':
                        alert('Fiador já cadastrado');

                        stopLoading('#search-users-box');

                        break;
                }
            }
        });
    }
}

function getCivilState() {
    $('#married-box').hide();

    if ($('#estado-civil').val() == $('#married-box').data('accepted-choice')) {
        $('#married-box').fadeIn();
    }
}
$('#cep').blur(function () {
    getCep($(this), function (data) {
        $('#endereco').val(data.logradouro);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.localidade);
        $('#uf').val(data.uf);
    });
});

$('#locator-search').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "/locators/fetch.json",
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
        $('#locator-search').val(ui.item.nome + ' - ' + ui.item.formatted_username);
        $('#locator-id').val(ui.item.locator.id);

        return false;
    }
}).autocomplete("instance")._renderItem = function (ul, item) {
    var data = {
        name: item.nome,
        username: item.formatted_username,
    };

    return $('<li>')
        .append($('#locators-search-template').tmpl(data))
        .appendTo(ul);
};

if ($('#descricao')) {
    CKEDITOR.replace('descricao');
}
$('#property').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "/bills/fetch-properties-water.json",
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
        $('#property').val(ui.item.full_address);
        $('#property-id').val(ui.item.id);

        return false;
    }
}).autocomplete("instance")._renderItem = function (ul, item) {
    var data = {
        photo: item.main_photo,
        address: item.full_address,
        code: item.formatted_code,
        locator: item.locator.user.nome,
        locator_username: item.locator.user.formatted_username
    };

    return $('<li>')
        .append($('#properties-search-template').tmpl(data))
        .appendTo(ul);
};
$('#tenant').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "/tenants/fetch.json",
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
        $('#tenant').val(ui.item.nome + ' - ' + ui.item.formatted_username);
        $('#tenant-id').val(ui.item.tenant.id);

        return false;
    }
}).autocomplete("instance")._renderItem = function (ul, item) {
    var data = {
        name: item.nome,
        username: item.formatted_username,
    };

    return $('<li>')
        .append($('#tenants-search-template').tmpl(data))
        .appendTo(ul);
};

$('#property').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "/properties/fetch.json",
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

if ($('#finalidade').length) {
    checkFinality();
}

$('#finalidade').change(function () {
    checkFinality();
});

if ($('#tipo-garantia').length) {
    checkWarranty();
}

$('#tipo-garantia').change(function () {
    checkWarranty();
});

function checkFinality() {
    $('#non-residential-div').hide();

    if ($('#finalidade').val() == $('#non-residential-div').data('accept')) {
        $('#non-residential-div').fadeIn();
    }
}

function checkWarranty() {
    $('[data-accept-warranty]').hide();

    if ($('#tipo-garantia').val() != '') {
        $('[data-accept-warranty=' + $('#tipo-garantia').val() + ']').fadeIn();
    }
}
var mainSlider;
var locatorsSliders = {};

if ($('#main-slider').length) {
    mainSlider = setSlider('#main-slider');

    $('.associated-locator-row').each(function () {
        locatorsSliders[$(this).data('locator-id')] = setSlider($(this).find('.slider'));

        $(this).find('.delete-button').click(function () {
            deleteSlider(this);
        });
    });

    updateTotalPercentage();
}

if ($('#search-locator').length) {
    $('#search-locator').autocomplete({
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
            associateLocator(ui.item);

            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        var data = {
            name: item.nome,
            cpf_cnpj: item.cpf_cnpj,
        };

        return $('<li>')
            .append($('#locators-search-template').tmpl(data))
            .appendTo(ul);
    };
}

function setSlider(component) {
    return $(component).bootstrapSlider({
        min: 0,
        max: 100,
        step: 1,
        orientation: 'horizontal',
        tooltip: 'show',
        id: 'blue',
        formatter: function (value) {
            return value + '%';
        }
    }).on('slide', function (value) {
        updateTotalPercentage();
    });
}

function associateLocator(locator) {
    if (confirm('Tem certeza que deseja associar esse Locador?')) {
        var error = false;

        if ($('#main-locator').data('locator-id') == locator.id) {
            alert('Não é possível associar um Locador a ele mesmo');
            error = true;
        }

        for (var index in locatorsSliders) {
            if (index == locator.id) {
                alert('Locador já associado');
                error = true;
            }
        }

        if (!error) {
            mainSlider.bootstrapSlider('enable');

            var data = {
                id: locator.id,
                name: locator.nome,
                percentage: 0
            };

            var sliderRow = $('#locators-sliders-template').tmpl(data).appendTo('.percentage-sliders');

            locatorsSliders[locator.id] = setSlider(sliderRow.find('.slider'));

            sliderRow.find('.delete-button').click(function () {
                deleteSlider(this);
            });
        }

        $('#search-locator').val('');
    }
}

function updateTotalPercentage() {
    var mainPercentage = mainSlider.bootstrapSlider('getValue');

    var sum = mainPercentage;
    if (!isLocatorsSlidersEmpty()) {
        for (var index in locatorsSliders) {
            sum += locatorsSliders[index].bootstrapSlider('getValue');
        }
    }

    var totalPercentage = $('#total-percentage');
    var saveButton = $('#save-button');

    totalPercentage.html(sum + '%');

    totalPercentage.removeClass('text-danger');
    totalPercentage.removeClass('text-success');

    if (sum != 100) {
        totalPercentage.addClass('text-danger');
        saveButton.attr('disabled', true);
    } else {
        totalPercentage.addClass('text-success');
        saveButton.attr('disabled', false);
    }

    updateAssociatedLocatorsForm();
}

function deleteSlider(element) {
    if (confirm('Tem certeza que deseja excluir?')) {
        var row = $(element).closest('.associated-locator-row');

        delete locatorsSliders[row.data('locator-id')];

        row.fadeOut('fast', function () {
            row.remove();

            if (isLocatorsSlidersEmpty()) {
                mainSlider.bootstrapSlider('setValue', 100);
                mainSlider.bootstrapSlider('disable');
            }

            updateTotalPercentage();
        });
    }
}

function isLocatorsSlidersEmpty() {
    var count = 0;
    for (var index in locatorsSliders) {
        count++;
    }

    return count == 0;
}

function updateAssociatedLocatorsForm() {
    $('#associate-locators-form').html('');

    $('.associated-locator-row').each(function () {
        var data = {
            id: $(this).data('locator-id'),
            percentage: locatorsSliders[$(this).data('locator-id')].bootstrapSlider('getValue')
        };

        $('#associate-locators-form-template').tmpl(data).appendTo('#associate-locators-form');
    });
}
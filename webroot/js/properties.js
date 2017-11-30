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

if ($('#locators-associations-chart').length) {
    new Chart($('#locators-associations-chart')[0].getContext('2d'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: $('#locators-associations-chart').data('dataset'),
                backgroundColor: $('#locators-associations-chart').data('colors')
            }],
            labels: $('#locators-associations-chart').data('labels')
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItems, data) {
                        var allData = data.datasets[tooltipItems.datasetIndex].data;
                        var tooltipData = allData[tooltipItems.index];

                        return tooltipData + '%';
                    }
                }
            }
        }
    });
}

if ($('#descricao').length) {
    CKEDITOR.replace('descricao');
}

if ($('#list-properties-map').length) {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        loadListMap();
    });
}

if ($('#property-map').length) {
    loadPropertyMap();
}

function loadListMap() {
    var markers = $('#list-properties-map').data('properties');

    var map = new google.maps.Map(document.getElementById('list-properties-map'));
    var bounds = new google.maps.LatLngBounds();

    $.each(markers, function () {
        var m = this;

        var latLng = new google.maps.LatLng(Number(m.latitude), Number(m.longitude));

        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });

        marker.addListener('click', function () {
            var data = {
                photo: m.photo,
                address: m.address,
                property_id: m.property_id,
                property_code: m.property_code
            };

            new google.maps.InfoWindow({
                content: $('#property-info-window-template').tmpl(data).html()
            }).open(map, this);
        });

        bounds.extend(latLng);
    });

    map.fitBounds(bounds);
}

function loadPropertyMap() {
    var position = new google.maps.LatLng(Number($('#property-map').data('latitude')), Number($('#property-map').data('longitude')));

    var map = new google.maps.Map(document.getElementById('property-map'), {
        center: position,
        zoom: 17,
        mapTypeControl: false,
        fullscreenControl: false
    });

    var marker = new google.maps.Marker({
        position: position,
        map: map
    });

    var editButton = document.createElement('div');
    editButton.innerHTML = '<i class="fa fa-pencil"></i>';
    editButton.className = 'custom-maps-button';

    var saveButton = document.createElement('div');
    saveButton.innerHTML = '<i class="fa fa-floppy-o"></i>';
    saveButton.className = 'custom-maps-button';

    var toast = document.createElement('div');
    toast.innerHTML = 'Arraste o marcador para alterar a posição';
    toast.className = 'maps-toast';

    editButton.addEventListener('click', function () {
        map.controls[google.maps.ControlPosition.TOP_RIGHT].clear();

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(saveButton);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(toast);

        marker.setDraggable(true);
    });

    saveButton.addEventListener('click', function () {
        marker.setDraggable(false);

        var button = this;

        button.innerHTML = '<i class="fa fa-circle-o-notch fa-spin"></i>';

        $.ajax({
            type: 'post',
            url: '/properties/update-latitude-longitude',
            data: {
                id: $('#property-hidden-id').val(),
                latitude: marker.position.lat(),
                longitude: marker.position.lng()
            },
            success: function () {
                button.innerHTML = '<i class="fa fa-floppy-o"></i>';

                map.controls[google.maps.ControlPosition.TOP_RIGHT].clear();

                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(editButton);

                map.panTo(marker.getPosition());
            }
        });
    });

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(editButton);
}

function updateLatitudeLongidute(marker) {
    $.ajax({
        type: 'post',
        url: '/properties/update-latitude-longitude',
        data: {
            id: $('#property-hidden-id').val(),
            latitude: marker.position.lat(),
            longitude: marker.position.lng()
        },
        success: function () {

        }
    });
}
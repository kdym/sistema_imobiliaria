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

$('#broker-search').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "/properties/fetch-broker.json",
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
        $('#broker-search').val(ui.item.nome + ' - ' + ui.item.formatted_username);
        $('#broker').val(ui.item.id);

        return false;
    }
}).autocomplete("instance")._renderItem = function (ul, item) {
    var data = {
        name: item.nome,
        username: item.formatted_username,
    };

    return $('<li>')
        .append($('#brokers-search-template').tmpl(data))
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
            cutoutPercentage: 70,
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

if ($('[data-check-bill]').length) {
    checkBills();
}

$('[data-check-bill]').click(function () {
    checkBills();
});

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

if ($('.upload-form').length) {
    Dropzone.autoDiscover = false;

    var propertiesUploader = new Dropzone(document.body, {
        url: '/properties-photos/add',
        maxFilesize: 2,
        dictFileTooBig: 'Tamanho máximo 2MB',
        acceptedFiles: 'image/jpeg,image/png',
        dictInvalidFileType: 'Somente arquivos de imagem (JPG ou PNG)',
        autoQueue: false,
        addRemoveLinks: true,
        dictRemoveFile: "Remover",
        previewsContainer: "#images-preview",
        clickable: ".add-photos-buttton"
    });

    propertiesUploader.on('addedfile', function (file) {
        $('.images-preview-instructions').hide();

        $('.cancel-upload-button, .upload-photos-button').attr('disabled', false);

        $('.masonry-list-50').masonry();
    });

    propertiesUploader.on('removedfile', function (file) {
        if (this.files.length == 0) {
            $('.images-preview-instructions').show();

            $('.cancel-upload-button, .upload-photos-button').attr('disabled', true);
            $('.add-photos-buttton').attr('disabled', false);
        }

        $('.masonry-list-50').masonry();
    });

    $('.cancel-upload-button').click(function () {
        // $('.images-preview-instructions').show();

        propertiesUploader.removeAllFiles(true);

        // $('.cancel-upload-button, .upload-photos-button').attr('disabled', true);
    });

    $('.upload-photos-button').click(function () {
        propertiesUploader.enqueueFiles(propertiesUploader.getFilesWithStatus(Dropzone.ADDED));

        $('.add-photos-buttton, .cancel-upload-button, .upload-photos-button').attr('disabled', true);
    });

    propertiesUploader.on("sending", function (file, xhr, formData) {
        formData.append("property_id", $('.image-gallery').data('property'));
    });

    propertiesUploader.on("queuecomplete", function (file) {
        // $('#properties-uploader .dz-message').fadeIn();
        //
        // propertiesUploader.removeAllFiles(true);
        //
        // $('#properties-add-photos, #properties-cancel-upload, #properties-upload').attr('disabled', false);

        propertiesUploader.removeAllFiles(true);

        loadPhotos();
    });

    loadPhotos();
}

$('#delete-photos').click(function () {
    if (confirm('Tem certeza que deseja excluir estas fotos?')) {
        var selected = [];
        $('.gallery-checkbox').each(function () {
            if ($(this).prop('checked') == true) {
                selected.push($(this).val());
            }
        });

        if (selected.length != 0) {
            startLoading($('#photo-gallery-box'));
            $('#delete-photos').prop('disabled', true);

            $.ajax({
                url: '/properties-photos/delete',
                type: 'delete',
                data: {
                    ids: selected.toString()
                },
                success: function () {
                    loadPhotos();
                }
            });
        }
    }
});

if ($('.common-bills-graph').length) {
    loadCommonBillsGraphs();
}

if ($('[data-common-bill-type]').length) {
    $('[data-common-bill-type]').each(function () {
        var type = $(this).data('common-bill-type');

        $('#search-property-' + type).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/common-bills/search-property.json",
                    data: {
                        name: request.term,
                        property_id: $('#property-hidden-id').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                if (confirm('Tem certeza que deseja adicionar esse Imóvel a essa conta?')) {
                    startLoading($('#common-bills-box'));

                    $.ajax({
                        url: "/common-bills/add.json",
                        data: {
                            property_id1: ui.item.id,
                            property_id2: $('#property-hidden-id').val(),
                            type: type
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function (data) {
                            if (!$.isEmptyObject(data)) {
                                var text = 'As seguintes modificações foram realizadas:\n';

                                $.each(data, function () {
                                    text += this + '\n';
                                });

                                alert(text);
                            }

                            location.reload();
                        }
                    });
                }

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
    });
}

function loadPhotos() {
    startLoading($('#photo-gallery-box'));

    $('#photo-gallery-view').html('');

    $.ajax({
        url: '/properties-photos/fetch/' + $('.image-gallery').data('property'),
        dataType: 'json',
        success: function (data) {
            var count = 0;
            $.each(data, function () {
                var photoPath = '/file/properties/' + $('.image-gallery').data('property') + '/' + this.url;

                var jsonData = {
                    id: this.id,
                    photo: photoPath
                };

                $('#photo-gallery-template').tmpl(jsonData).appendTo('#photo-gallery-view');

                count++;
            });

            $('#photo-gallery-view').sortable({
                placeholder: "photo-gallery-state-highlight",
                revert: true,
                update: sortPhotos
            });

            $('.masonry-list-50').masonry();

            if (count != 0) {
                $('#delete-photos').prop('disabled', false);
            }

            stopLoading($('#photo-gallery-box'));
        }
    });
}

function sortPhotos() {
    $.ajax({
        url: '/properties-photos/update-order',
        type: 'post',
        data: {
            images: $(this).sortable("serialize")
        }
    });
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

function checkBills() {
    $('[data-accept-bill]').prop('readonly', true);

    $('[data-check-bill]').each(function () {
        if ($(this).prop('checked')) {
            $('[data-accept-bill=' + $(this).data('check-bill') + ']').prop('readonly', false);
        }
    });
}

function loadCommonBillsGraphs() {
    $('.common-bills-graph').each(function () {
        new Chart($(this)[0].getContext('2d'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: $(this).data('dataset'),
                    backgroundColor: $(this).data('colors')
                }],
                labels: $(this).data('labels')
            },
            options: {
                responsive: true,
                cutoutPercentage: 70,
                maintainAspectRatio: false,
                legend: false,
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
    });
}
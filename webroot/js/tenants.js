$('#tenants-list').DataTable({
    order: [[0, 'asc']],
    columnDefs: [
        {orderable: false, targets: [3]}
    ],
    responsive: true
});

$('#tenant-cep').blur(function () {
    getCep($(this), function (data) {
        $('#tenant-endereco').val(data.logradouro);
        $('#tenant-bairro').val(data.bairro);
        $('#tenant-cidade').val(data.localidade);
        $('#tenant-uf').val(data.uf);
    });
});

if ($('#married-box').length) {
    getCivilState();
}

$('#estado-civil').change(function () {
    getCivilState();
});

function getCivilState() {
    $('#married-box').hide();

    if ($('#estado-civil').val() == $('#married-box').data('accepted-choice')) {
        $('#married-box').fadeIn();
    }
}
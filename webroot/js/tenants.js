$('#tenants-list').DataTable({
    order: [[0, 'asc']],
    columnDefs: [
        {orderable: false, targets: [3]}
    ],
    responsive: true
});

$('#cep').blur(function () {
    getCep($(this), function (data) {
        $('#endereco').val(data.logradouro);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.localidade);
        $('#uf').val(data.uf);
    });
});
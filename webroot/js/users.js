$('#users-list').DataTable({
    order: [[0, 'asc']],
    columnDefs: [
        {orderable: false, targets: [4]}
    ],
    responsive: true
});

$('#change-password').click(function () {
    $('#new-password').attr('readonly', !$(this).prop('checked'));
});
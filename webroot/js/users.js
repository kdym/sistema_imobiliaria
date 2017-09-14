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
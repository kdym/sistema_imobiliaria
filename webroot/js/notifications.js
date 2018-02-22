$('#total-bills-notification').html('');
$('#absent-bills-notification').html('');

$.ajax({
    url: '/notifications/bills',
    dataType: 'json',
    success: function (data) {
        if (data.total != 0) {
            $('#total-bills-notification').html(data.total);
        }

        if (data.absent != 0) {
            $('#absent-bills-notification').html(data.absent);
        }
    }
});
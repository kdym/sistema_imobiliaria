function startLoading(element) {
    var html = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

    $(element).append(html);
}

function stopLoading(element) {
    $(element).find('.overlay').remove();
}

$('[readonly="readonly"]').click(function () {
    return false;
});

$.fn.bstooltip = $.fn.tooltip.noConflict();
$("body").bstooltip({selector: '[data-toggle=tooltip]'});

$('form').submit(function () {
    var submitButton = $(this).find('button[type="submit"]');

    submitButton.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
    submitButton.attr('disabled', true);
});
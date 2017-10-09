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
function startLoading(element) {
    var html = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

    $(element).append(html);
}

function stopLoading(element) {
    $(element).find('.overlay').remove();
}
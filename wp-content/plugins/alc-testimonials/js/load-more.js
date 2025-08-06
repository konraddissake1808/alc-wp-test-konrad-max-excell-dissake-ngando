jQuery(document).ready(function ($) {
    let page = 1;
    $('#load-more').on('click', function () {
        page++;
        $.post(alc_ajax.ajax_url, {
            action: 'alc_load_testimonials',
            page: page
        }, function (data) {
            $('#alc-testimonials').append(data);
        });
    });
});
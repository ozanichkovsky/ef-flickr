function postForm($form, page, callback) {

    /*
     * Get all form values
     */
    var values = {};
    $.each( $form.serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });

    values[$form.attr('name') + '[page]'] = page;

    /*
     * Throw the form values to the server!
     */
    $.ajax({
        type        : $form.attr('method'),
        url         : $form.attr('action'),
        data        : values,
        success     : function(data) {
            callback(data);
        }
    });
}

function link(e) {
    e.preventDefault();
    postForm($('[name="SearchType"]'), $(this).html(), responseHandler);
    return false;
}

function responseHandler(response) {
    $('.content').html(response);
    $('.pagination a').click(link);
    $("a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").attr('rel', 'gallery').fancybox();
}

$(document).ready(function(){

    $('[name="SearchType"]').submit(function(e) {
        e.preventDefault();

        postForm($(this), 1, responseHandler);

        return false;
    });

    $('.pagination a').click(link);
    $("a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").attr('rel', 'gallery').fancybox(
        {"loop": false}
    );
});
$(".readmore").on('click', function() {
    $(this).toggleClass('btn-secondary btn-danger');
    $(this).parent().toggleClass('showContent');
    var replaceText = $(this).parent().hasClass('showContent') ? "Read less" : "Read more";
    $(this).text(replaceText);
});

$('select').select2({ width: '100%' });
if ($('select').parent().hasClass('form-inline')) {
    $('div.form-inline').children('select').select2();
}

var start = 13;
var limit = 17;
var reachedMax = false;

$(window).scroll(function() {
    if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        getData();
    }
});

function getData() {
    if (reachedMax)
        return;

    $.ajax({
        url: '/admin/weapon',
        method: 'POST',
        dataType: 'text',
        data: {
            getData: 1,
            start: start,
            limit: limit
        },
        success: function(response) {
            if (response == "reachedMax")
                reachedMax = true;
            else {
                start += limit;
                $(".results").append(response);
            }
        }
    });
}
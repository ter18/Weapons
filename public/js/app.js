$(".readmore").on('click', function() {
    $(this).toggleClass('btn-secondary btn-danger');
    $(this).parent().toggleClass('showContent');
    var replaceText = $(this).parent().hasClass('showContent') ? "Read less" : "Read more";
    $(this).text(replaceText);
});
$('.price-offer').each(function() {
    var toreplace = $(this).html();
    toreplace = toreplace.replace("грн.","<p>&nbsp;грн</p>");
    $(this).html(toreplace);
});

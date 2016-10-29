/*------------------------------
Script to handle the search events
--------------------------------*/


// first part handle focus and blur events
// for what reason????
// you can simply do this via css
$(".search__q-input, .search__submit")
.focus(function() {
$('#search').addClass('search_focused');
        $(".search_focused").css("border","4px solid #B4C4D5");
})
.blur(function() {
$('#search').removeClass('search_focused');
        $("#search").css("border","1px solid #4B80BB");
});


// second part. don't know exactly what it does
// maybe it autocompletes the users input on base of databases requests...
var searchObj = {
    init: function() {
        var self = this;

        self.responseEnhance();
        self.enableAutocomplete();
    },
    enableAutocomplete: function() {
        $('#input-search-key').autocomplete({
            serviceUrl:'/bitrix/tools/ajax.php?ajax_call=f54564fad6f68c8c49d2ae98a02ee4fb&mode=autocomplete',
            minChars:2,
            onSelect: function(value,data) {
                $('#search-form').find('#search-submit-button').trigger("click");
            }
        });
    },
    responseEnhance: function() {
        var searchBlock = $('.search-block');
        var pullSearch = $('#pull-search');
        var inputSearch = $('#input-search-key');
        var cssActive = 'active';
        var cssFixed = 'search-block--fixed';

        pullSearch.on('click', function() {
            if ($(this).hasClass(cssActive)) {
                $(this).removeClass(cssActive);
                searchBlock.removeClass(cssFixed);
            } else {
                $(this).addClass(cssActive);
                searchBlock.addClass(cssFixed);
                inputSearch.focus();
            }
        });

    }
};
$(function(){
    searchObj.init();
});

var sidebar = $('.sidebar-filter');
var filterLink = $('.filter-link');
var filterHeader = $('.filter-header');
var sortLink = $('.sort-link');
var productSort = $('#sort-form');
var offset = filterLink.position();
var sidebarOffset = sidebar.offset();
var top = offset.top;

$(document).mouseup(function (e)
{ if ($(document).width() <= 800){
        var container = $(".product-sort-simple");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0 // ... nor a descendant of the container
            && !sortLink.is(e.target))
        {
            container.hide();
        }

        if (!sidebar.is(e.target) // if the target of the click isn't the container...
            && sidebar.has(e.target).length === 0 // ... nor a descendant of the container
            && !filterLink.is(e.target)) 
        {
            sidebar.hide();
        }
    }

});

filterLink.click(function() {
    console.log('clicked');
    sidebar.parent().css({position: 'relative'});
    sidebar.css('top', (offset.top) + filterLink.outerHeight() + 5 + 'px' );
    sidebar.toggle();


});

sortLink.click(function() {
    productSort.parent().css({position: 'relative'});
    $('.product-sort-simple').css('top', (offset.top) + filterLink.outerHeight() + 5 + 'px' );
    $('.product-sort-simple').toggle();
});

if ($('.filter-values-block').css('display') === 'block') {
        $('.filterToggler').addClass('icon-down').removeClass('icon-up');
};
filterHeader.click(function() {
    // $(this).next().toggle();
    if ($(this).children('span').hasClass('icon-down')) {
        $(this).children('span').removeClass('icon-down').addClass('icon-up');
        $(this).next().toggle();
    } else {
        $(this).children('span').removeClass('icon-up').addClass('icon-down');
        $(this).next().toggle();
    };
});

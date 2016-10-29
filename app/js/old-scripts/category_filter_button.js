// this script
//

var sidebar = $('.sidebar-filter'); // sidebar block
var filterLink = $('.filter-link'); // button Подбор
var filterHeader = $('.filter-header'); // header of filter blocks
var sortLink = $('.sort-link'); //button Сортировать
var productSort = $('#sort-form'); // sort block
var offset = $('.filter-link').position();
var sidebarOffset = sidebar.offset();
var wWidth = $(window).width();

var debounce = function(func, wait, immediate) {
    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};
var updateLayout = debounce(function(e) {
    wWidth = $(window).width();
    offset = $('.filter-link').position();
    if (wWidth > 992) {
        sidebar.show();
        $('.product-sort-simple').show();
    } else {
        sidebar.hide();
        $('.product-sort-simple').hide();
    }
    console.log(offset.top + "   width:" + wWidth);
    }, 500); // Maximum run of once per 500 milliseconds
window.addEventListener("resize", updateLayout, false);

filterLink.click(function() {
    sidebar.parent().css({position: 'relative'});
    sidebar.css('top', offset.top + filterLink.outerHeight() + 5 + 'px' );
    sidebar.toggle();
});

sortLink.click(function() {
    productSort.parent().css({position: 'relative'});
    $('.product-sort-simple').css('top', offset.top + filterLink.outerHeight() + 5 + 'px' );
    $('.product-sort-simple').toggle();
});

if ($('.filter-values-block').css('display') === 'block') {
        $('.filterToggler').addClass('icon-down').removeClass('icon-up');
}

// hide blocks if clicked not on them and if windowWidth is less than 800px
$(document).mouseup(function (e)
{
    if (wWidth <= 800){
        var container = $('.product-sort-simple');
        if (!container.is(e.target) && container.has(e.target).length === 0 && !sortLink.is(e.target))
        {
            container.hide();
        }
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && !filterLink.is(e.target))
        {
            sidebar.hide();
        }
    }
});

filterHeader.click(function() {
    // $(this).next().toggle();
    if ($(this).children('span').hasClass('icon-down')) {
        $(this).children('span').removeClass('icon-down').addClass('icon-up');
        $(this).next().toggle();
    } else {
        $(this).children('span').removeClass('icon-up').addClass('icon-down');
        $(this).next().toggle();
    }
});

$(function(){
  var brandsOpener = $('.brands-page__filter-link');
  var brands = $('.brands-page__filter-options');
  var wWidth = $(window).width();

  brandsOpener.click(function() {
    var offset = $(this).position();

		var brandsOffset = brands.offset();
		if(offset !== undefined) {
			var top = offset.top;
    }

    brands.css('width', $(this).outerWidth() + 'px');
    brands.css('top', (offset.top) + $(this).outerHeight()  + 'px');
    brands.toggle();
	    $(this).toggleClass('active');
  });
  
  if (wWidth < 768) {
    hideElementOnEmptyClick(brands, brandsOpener);
  }
  
});
(function ($) {
    $(function() {
        var owl = $('#owl-carousel-slider');

        owl.owlCarousel({
            // Most important owl features
            items : "1",
            itemsCustom : false,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsTabletSmall: false,
            itemsMobile : [479,1],

                                singleItem: true,

            itemsScaleUp : false,

            //Basic Speeds
            slideSpeed : 200,
            paginationSpeed : 800,
            rewindSpeed : 1000,

            //Autoplay
                                autoPlay: 20000,

            stopOnHover : true,

            // Navigation
            navigation : false,
            navigationText : ["назад","вперед"],
            rewindNav : true,
            scrollPerPage : false,

            //Pagination
            pagination : true,
            paginationNumbers: false,

            // Responsive
            responsive: true,
            responsiveRefreshRate : 200,
            responsiveBaseWidth: window,

            // CSS Styles
            baseClass : "owl-carousel",
            theme : "owl-theme",

            //Lazy load
            lazyLoad : false,
            lazyFollow : true,
            lazyEffect : "fade",

            //Auto height
                                autoHeight : true,

            //JSON
            jsonPath : false,
            jsonSuccess : false,

            //Mouse Events
            dragBeforeAnimFinish : true,
            mouseDrag :  true,
            touchDrag :  true,

                                transitionStyle: false,

            // Other
            addClassActive : false,

            //Callbacks
            beforeUpdate : false,
            afterUpdate : false,
            beforeInit: function(elem) {
                                        elem.children().sort(function(){
                    return Math.round(Math.random()) - 0.5;
                }).each(function(){
                    $(this).appendTo(elem);
                });
                                    },
            afterInit: enableCustomPagination,
            beforeMove: false,
            afterMove: function() {
                                    },
            afterAction: false,
            startDragging : false,
            afterLazyLoad : false
        });

        function enableCustomPagination() {
            $.each(this.owl.userItems, function (i) {
                //var titleData = $(this).find('img').attr('title');
                var titleData = $(this).find('#text_on_button').find('img').attr('title');
                var paginationLinks = $('.owl-controls .owl-pagination .owl-page span');

                $(paginationLinks[i]).append(titleData);

            });
        }


        //responsive for flash
        var flashWrapItems = $('.owl-carousel__object-item');
        var flashItems = flashWrapItems.find("object, embed");
        var flashFluidItems = flashWrapItems.find('figure');

        if (flashWrapItems.length) {
            flashItems.each(function() {
                $(this)
                    // jQuery .data does not work on object/embed elements
                    .attr('data-aspectRatio', this.height / this.width)
                    .removeAttr('height')
                    .removeAttr('width');
            });

            $(window).resize(function() {
                var newWidth = flashFluidItems.width();
                flashItems.each(function() {
                    var $el = $(this);
                    $el
                        .width(newWidth)
                        .height(newWidth * $el.attr('data-aspectRatio'));
                });
            }).resize();
        }
    });
}(jQuery));

<script type="text/javascript">
    BIS.tabs = {
        init: function(container, tabs) {
            var container = container || $('.header__phones');
            var tabs = tabs || container.find('.contacts__tabs');
            var tabsLink = tabs.find('>div');
            var boxes = container.find('.contacts__tabs__box');
            var current;
            var currentDataLink;
            var cssHidden = 'hidden';
            var cssActive = 'active';

            tabsLink.on('click', function() {
                current = $(this);
                currentDataLink = current.data('link');
                if (currentDataLink) {
                    boxes.addClass(cssHidden);
                    tabsLink.removeClass(cssActive);
                    current.addClass(cssActive);
                    boxes.each(function() {
                        if ($(this).data('box') == currentDataLink) {
                            $(this).removeClass(cssHidden);
                        }
                    })
                }
            })
        }
    }

    // invokes
    $(function() {
        BIS.tabs.init();
        BIS.tabs.init($('.block-delivery-payment'), $('.block-delivery__tabs'));
    })
</script>
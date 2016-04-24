<?//d($arParams);?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$frame = $this->createFrame()->begin("<a class=cart-link-wrap".$cssFullCart." href='/personal/cart/'><em>Корзина</em> (..)</a>");
//PST-9
?>


<script>
    if (!BIS.updatePopupTopCart) {
        BIS.updatePopupTopCart = {
            init: function() {
                var container = $('#popup-cart-wrapper');

                var defUpdatedTopCart = new $.Deferred();
                ajax_block('.top-cart');
                var ajaxEnded = ajax_load('.top-cart', '<?=$arResult['AJAX_CALL_ID']?>', $('.top-cart-form').serializeArray());
                $("form")[0].reset();
                console.log("work");
                $.when(ajaxEnded).done(function() {
                    defUpdatedTopCart.resolve();

                    $.fancybox({
                        content: container,
                        afterLoad: function() {
                            ajax_load('#popup-cart-wrapper', '<?=$arResult['AJAX_CALL_ID']?>', 'do=add2Cart');
                            container.show();
                        }
                    });

                });
                return defUpdatedTopCart;
            }
        }
    }



    /*if (!BIS.updateTopCart) {
        BIS.updateTopCart = {
            init: function() {
                var container = $('#popup-cart-wrapper');

                ajax_block('.top-cart');
                ajax_load('.top-cart', '<?=$arResult['AJAX_CALL_ID']?>', $('.top-cart-form').serializeArray());

                $.fancybox({
                    content: container,
                    afterLoad: function() {
                        ajax_load('#popup-cart-wrapper"', '<?=$arResult['AJAX_CALL_ID']?>', 'do=refresh');
                        container.show();
                    }
                });
            }

        }
    }*/

</script>
<?

/* Данные для arResult корзины в шапке (ajax) */
$arResult['TOP_TMPL'] = array();
if (is_array($arResult['ITEMS']) && count($arResult['ITEMS'])>0) {
    $cssFullCart = 'cart-link--full';
    $emptyCart = false;
    $arResult['TOP_TMPL']['COUNT'] = count($arResult['ITEMS']);
    $arResult['TOP_TMPL']['CSS_ACTIVE'] = 'cart-link--active';
    $arResult['TOP_TMPL']['CART_NAME'] = 'В корзине:';
    $totalQuantity = 0;
    foreach($arResult['CART_ITEMS'] as $item) {
        $totalQuantity = $totalQuantity + format_qty($item['QUANTITY']);
    }
} else {
    $emptyCart = true;
    $arResult['TOP_TMPL']['COUNT'] = 0;
    $arResult['TOP_TMPL']['CART_NAME'] = 'Корзина:';
    $totalQuantity = 0;
}
?>

<a class="cart-link-wrap <?=$cssFullCart;?>" href="/personal/cart/">
    <form class="top-cart-form">
        <?if ($emptyCart):?>
            <div class="top-cart__content-empty">
                <em>Корзина</em> (0)
            </div>
        <?else:?>
            <div class="top-cart__content-full">
                <div><em>Корзина</em> (<span id="cart_items_count"><?=$arResult['TOP_TMPL']['COUNT'];?></span>)</div>
            </div>
        <?endif;?>
    </form>
</a>



    <? // try to show?>
    <script>
        BIS.cartPopup = {
                init: function(container) {
                    var cartPopupLink = $('.buttCart');
                    var self = this;

                    container.hide();
                    /*cartPopupLink.on('click', function(e) {
                        e.preventDefault();
                        $.fancybox({
                            content: container,
                            afterLoad: function() {
                                container.show();
                            }
                        });
                    })*/
                }
        }
            $(function() {
                BIS.cartPopup.init($('#popup-cart-wrapper'));
           })
    </script>
<div class="popup__overlay" id="popup-cart-wrapper">
    <div class="popup">

    </div>
</div>

<script type="text/javascript">
/* Flying Basket */
    var flyBasket = {
        init: function() {
            var bsBox = $('.top-cart'),
                w = $(window),
                wWidth = w.width(),
                wScrollTop = w.scrollTop(),
                isFixedCart = false,
                smallerDisplay = false,
                self = this;

            var cssScrollBasket = 'bs-scrollBasket';

            smallerDisplay = self._isSmallerDisplay(wWidth);

            w.scroll(function () {
                wScrollTop = w.scrollTop();

                if (wScrollTop >= 200 && !isFixedCart && !smallerDisplay) {
                    //console.log('Корзина летает');
                    isFixedCart = true;
                    bsBox.addClass(cssScrollBasket);
                    bsBox.css('right', '0');
                }
                else if (wScrollTop < 200 && isFixedCart) {
                   //console.log('Корзина на месте');
                    isFixedCart = false;
                    bsBox.removeClass(cssScrollBasket);
                    bsBox.css('right', 'auto');
                }
            });

            w.resize(function() {
                wWidth = w.width();
                smallerDisplay = self._isSmallerDisplay(wWidth);
                if (wWidth < 1300 && isFixedCart) {
                    self._removeFixedCart( bsBox, cssScrollBasket );
                }
            });

        },
        _removeFixedCart: function( bsBox, cssScrollBasket ) {
            bsBox.removeClass(cssScrollBasket);
            bsBox.css('right', 'auto');
        },
        _isSmallerDisplay: function(wWidth) {
            if (wWidth < 1300) {
                return true;
            } else {
                return false;
            }
        }
    };
    $(function() {
        //flyBasket.init();
    })
/* Flying Basket */
</script>

<?
//PST-9
$frame->end();
//PST-9
?>


<?//d($arParams);?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$frame = $this->createFrame()->begin("<a class=cart-link-wrap".$cssFullCart." href='/personal/cart/'><em>Корзина</em> (..)</a>");
//PST-9
?>


<script>
    if (!BIS.updateTopCartFromCart) {
        BIS.updateTopCartFromCart = {
            init: function() {
                ajax_block('.top-cart');
                ajax_load('.top-cart', '<?=$arResult['AJAX_CALL_ID']?>', $('.top-cart-form').serializeArray());
            }
        }
    }
    if (!BIS.updatePopupTopCart) {
        BIS.updatePopupTopCart = {
            init: function() {
                var container = $('#popup-cart-wrapper');
                var defUpdatedTopCart = new $.Deferred();

                ajax_block('.top-cart');
                var ajaxEnded = ajax_load('.top-cart', '<?=$arResult['AJAX_CALL_ID']?>', $('.top-cart-form').serializeArray());
                $.when(ajaxEnded).done(function() {
                    defUpdatedTopCart.resolve();
                    $.fancybox({
                        content: container,
                        afterLoad: function() {
                            container.html($('.popup')).fadeIn('fast');
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
                    //container.hide();
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
            //$(function() {
              //  BIS.cartPopup.init($('#popup-cart-wrapper'));
           //})
     </script>
<?if ($arParams['AJAX_ENABLED']=="Y"):?>
    <script type="text/javascript">
        $(function(){
            cartObj.init();

            <?if ($arResult['UPDATE_PRICE']):?>
            cartObj.calculateTotal();
            <?endif;?>
        });
    </script>
<?endif;?>
<?//if ($arParams['AJAX_ENABLED']!="Y"):?>
<script type="text/javascript">
    var cartObj = {
        init: function() {
            var updateLink = $('.basket-btns--update');
            var deleteLink = $('.page-cart__delete_checkbox');
            var self = this;

            var addItem = $('.page-cart-item-quantity__add');
            var deleteItem = $('.page-cart-item-quantity__del');
            var updateItem = $('.page-cart-item-quantity__update');
            var quantityInput = $('.page-cart-item-quantity__input');

            if (updateLink.length) {
                updateLink.on('click', function(e) {
                    e.preventDefault();
                    self.updateCart();
                })
            }

            if (deleteLink.length) {
                deleteLink.on('click', function(e) {
                    e.preventDefault();
                    $(this).siblings('.delete_checkbox').trigger('click');
                    self.updateCart();
                })
            }

            if (quantityInput.length) {
                quantityInput.on('change', function(){
                    self.updateCart();
                })
            }

            if (addItem.length) {
                addItem.on('click', function(e) {
                    e.preventDefault();
                    var inputQuantity = $(this).siblings('.page-cart-item-quantity__input');
                    var inputQuantityValue = inputQuantity.val();

                    if (inputQuantityValue > 0) {
                        inputQuantityValue++;
                        inputQuantity.val(inputQuantityValue);
                    }
                    self.updateCart();
                })
            }

            if (deleteItem.length) {
                deleteItem.on('click', function(e) {
                    e.preventDefault();
                    var inputQuantity = $(this).siblings('.page-cart-item-quantity__input');
                    var inputQuantityValue = inputQuantity.val();

                    if (inputQuantityValue > 1) {
                        inputQuantityValue--;
                        inputQuantity.val(inputQuantityValue);
                    }
                    self.updateCart();
                })
            }

            updateItem.on('click', function(e) {
                e.preventDefault();
                self.updateCart();
            })
        },
        updateCart: function() {
            ajax_block('#basket-form');
            var ajaxEnded = ajax_load('#basket-form', '<?=$arResult['AJAX_CALL_ID']?>', $('#basket-form').serializeArray());
            $.when(ajaxEnded).done(function() {
                BIS.cartPopup.init('#popup-cart-wrapper');
                BIS.updateTopCartFromCart.init();
                BIS.updatePopupTopCart.init();
            })
        },
        calculateTotal: function() {
            var not_complete = true;

            setTimeout(function(){
                if (not_complete) {
                    $('#ajax_loader_bg').remove();
                    $('#delivery_price').text('уточните у менеджеров');
                }
            }, 10000); // 10 секунд
        }
    }
    //$(function() {
     //cartObj.init();
    //})
</script>
<?//endif;?>
<div class="popup__overlay" id="popup-cart-wrapper">
    <div class="popup">
        <?if (is_array($arResult['CART_ITEMS'])):?>

            <?//if ($arParams['AJAX_ENABLED']!="Y"):?>
                <div class="basket-container">
                <form id="basket-form" method="post" action="">
            <?//endif;?>
            <input type="hidden" name="do" value="send" id="hidden_do" />


            <div id="product-list" class="product-list">
                <table class="table-order-product">
                    <tr>
                        <th class="table-order__delete-cell"><!----></th>
                        <th align="center">Товар</th>
                        <th>Кол-во</th>
                        <th>Сумма</th>
                    </tr>

                    <?$counter = 0;?>
                    <?foreach ($arResult['CART_ITEMS'] as $item):?>
                        <?$counter++;?>
                        <tr>
                            <td>
                                <div class="page-cart-item-delete">
                                    <a href="#" class="page-cart__delete_checkbox"></a>
                                    <input type="checkbox" class="delete_checkbox" name="del[<?=$item['ID']?>]" value="1" />
                                </div>
                            </td>
                            <td>
                                <div class="page-cart-container-block">
                                    <div class="page-cart-item-image">
                                        <?if ($arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE']>0):?>
                                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                                <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=MakeImage($arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE'], array('wl'=>100, 'hl'=>67, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                            </a>
                                        <?else:?>
                                            <img title="<?=$item['NAME']?>" class="adaptive-img" alt="<?=$item['NAME']?>" width="100" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                                        <?endif;?>
                                    </div>

                                    <div class="page-cart-item-name">
                                        <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                                    </div>

                                    <div class="page-cart-item-price">
                                        <?=price($item['PRICE'], $item['CURRENCY'])?>
                                    </div>

                                </div>
                            </td>

                            <td>
                                <div class="page-cart-item-quantity">
                                    <a href="#" class="butt2 page-cart-item-quantity__del">-</a>
                                    <input class="page-cart-item-quantity__input" name="qty[<?=$item['ID']?>]" type="text" id="qty_<?=$item['ID']?>" size="2" maxlength="7" value="<?=format_qty($item['QUANTITY'])?>" />
                                    <a href="#" class="butt2 page-cart-item-quantity__add">+</a>
                                </div>
                            </td>

                            <td>
                                <div class="page-cart-item-total">
                                    <?=price($item['PRICE']*$item['QUANTITY'], $item['CURRENCY'])?>
                                </div>
                            </td>
                        </tr>
                    <?endforeach;?>
                </table>
                <div class="basket-total-price">
                    Итого: <span><?=price($arResult['TOTAL_PRICE'], $arResult['CURRENCY'])?></span>
                </div>

                <?if (count($arResult['CART_ITEMS']) >= 4):?>
                    <a href="#" class="cart-delete-all" onclick="if (confirm('Вы действительно хотите удалить все товары из корзины?')) {$('#hidden_do').val('deleteAll'); $('#basket-form').submit(); return false;} else { return false; }">Удалить все</a>
                <?endif;?>
            </div>


            <div class="button-make-order">
                <input class="butt3 butt3--big" type="submit" title="Заказать" onclick="$('#basket-form').submit();" value="Оформить заказ" id="send_order" />
            </div>

            <!-- block -->
            <?if ($arParams['AJAX_ENABLED']!="Y"):?>
            </form>
        <?endif;?>
            <?if ($arParams['AJAX_ENABLED']!="Y"):?>
                <?if (is_array($arResult['ACCESSORIES']) AND !empty($arResult['ACCESSORIES'])):?>
                    <div id="basket-accessories">
                        <br class="clear" />
                        <!--
                        <div class="black">
                            <p class="strong" style="margin: 0; font-size: 12px;">Акция: при одновременной покупке товара мы даем скидки на аксессуары</p>
                            <p style="font-size: 12px;">на 1 аксессуар скидка 10%, на 2 аксессуара скидка 12%, на 3 аксессуара и более скидка 15%</p>
                        </div>-->
                        <?foreach ($arResult['ACCESSORIES'] as $item_id=>$fields):?>
                            <?if ($fields['PROPERTY_ACCESSORIES_VALUE']):?>
                                <div style="padding: 5px 10px; border: 1px solid #c3c3c3;">
                                    <p style="padding: 0; margin: 0;"><strong>Рекомендуем купить для <?=$fields['NAME']?></strong></p>
                                </div>
                                <?$APPLICATION->IncludeComponent("bexx:catalog.items", "cart_accessories", array(
                                        "IBLOCK_TYPE" => $fields['IBLOCK_TYPE'],
                                        "IBLOCK_ID" => $fields['IBLOCK_ID'],
                                        "ADDITIONAL_FILTER" => array(
                                            'ID' => $fields['PROPERTY_ACCESSORIES_VALUE'],
                                            '!ID' => $arResult['ACCESSORIES_EXCLUDE'],
                                            'ACTIVE' => "Y"
                                        ),
                                        "SECTION_ID" => "",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SORT_FIELD_1" => "SORT",
                                        "SORT_DIR_1" => "ASC",
                                        "CATALOG_PATH" => $fields['LIST_PAGE_URL'],
                                        "SHOW_OLD_PRICE" => "N",
                                        "DESCRIPTION_FROM_PROPS" => "N",
                                        "SHOW_NAVIGATION" => "N",
                                        "COUNT" => "3",
                                        "ALLOW_PAGENAV" => "N",
                                        "CACHE_TYPE" => "N",
                                        "CACHE_TIME" => "86400",
                                        "SET_TITLE" => "N",
                                    ),
                                    $component
                                );?>
                            <?endif;?>
                        <?endforeach;?>
                        <!--<div class="float-right" style="margin-bottom: 10px; padding-right: 10px;"><a class="arr-2-right-orange text-small" href="#">смотреть еще предложения</a></div>-->
                        <br class="clear" />
                    </div>
                <?endif;?>
                </div>

            <?endif;?>

        <?else:?>
            <p class="text-large">У вас нет товаров для заказа</p>
        <?endif;?>
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
    });
/* Flying Basket */
</script>

<?
//PST-9
$frame->end();
//PST-9
?>


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
                $.when(ajaxEnded).done(function() {
                    defUpdatedTopCart.resolve();
                    $.fancybox({
                        content: container,
                        afterLoad: function(){
                            container.html($('.popup')).fadeIn('fast');
                            container.show();
                        }
                    });

                });
                return defUpdatedTopCart;
            }
        }
    }
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
<a class="cart-link-wrap cart-link--full" href="/personal/cart">
    <form class="top-cart-form">
        <div class="top-cart__content-full">
		<?if ($emptyCart):?>
            <div class="top-cart__content-empty">
                <em>Здесь пока ничего нет</em>
            </div>
        <?else:?>
            <div class="top-cart__content__block top-cart__content__block--products"><span id="cart_items_count"><?=$arResult['TOP_TMPL']['COUNT'];?></span></div>
                <div class="top-cart__content__block top-cart-price"><span id="cart_items_sum" class="cart-items_sum"><? echo eregi_replace("([^0-9])", "", price($arResult['TOTAL_PRICE'], $arResult['CURRENCY']));?> </span>грн</div>
            <div>
                    <div class="cart-hover">
                        <div class="arrow-block">
                            <div class="arrow-hover"></div>
                        </div>
                        <div class="cart_block_text"><p class="to-cart top-cart__content__block">В корзину</p></div>
                    </div>
            </div>
		   <?endif;?>	
        </div>
            </form>
</a>


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
        elems: {},

        init: function() {
            var self = this;

            self.elems = {
                updateLink: $('.basket-btns--update'),
                deleteLink: $('.page-cart__delete_checkbox'),
                addItem: $('.page-cart-item-quantity__add'),
                deleteItem: $('.page-cart-item-quantity__del'),
                updateItem: $('.page-cart-item-quantity__update'),
                quantityInput: $('.page-cart-item-quantity__input')
            };

            if (self.elems.updateLink.length) {
                self.elems.updateLink.on('click', function(e) {
                    e.preventDefault();
                    self.updateCart();
                })
            }

            if (self.elems.deleteLink.length) {
                self.elems.deleteLink.on('click', function(e) {
                    e.preventDefault();
                    $(this).siblings('.delete_checkbox').trigger('click');
                    self.updateCart();
                })
            }

            if (self.elems.quantityInput.length) {
                self.elems.quantityInput.on('change', function(){
                    self.updateCart();
                })
            }

            if (self.elems.addItem.length) {
                self.elems.addItem.on('click', function(e) {
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

            if (self.elems.deleteItem.length) {
                self.elems.deleteItem.on('click', function(e) {
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

            self.elems.updateItem.on('click', function(e) {
                e.preventDefault();
                self.updateCart();
            })
        },
        updateCart: function() {
            var self = this;

            ajax_block('#basket-form');

            // Disable button while ajax...
            self._disableButtons();

            var ajaxEnded = ajax_load('#basket-form', '<?=$arResult['AJAX_CALL_ID']?>', $('#basket-form').serializeArray());
            $.when(ajaxEnded).done(function() {
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
        },
        _disableButtons: function() {
            var self = this;

            for (var key in self.elems) {
                self.elems[key].off();
            }
        }
    };
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
    <?/*
			<tr>
                <th align="center">Фото</th>
				<th align="center">Описание</th>
                <th align="center">Размер</th>
                <th align="center">Цвет</th>
				<th>Кол-во</th>
				<th>Сумма</th>
                <th class="table-order__delete-cell"><!----></th>
			</tr>
            */?>

    <?$counter = 0;?>
    <?foreach ($arResult['CART_ITEMS'] as $item):?>

        <?
        //VTL-5
        $image = $arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE'];

        // Проверка на SKU
        if ($arResult['ITEMS'][$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']) {
            $parent_id = $arResult['ITEMS'][$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE'];
            $image = $arResult['ITEMS'][$parent_id]['DETAIL_PICTURE'];
        }
        //VTL-5
        ?>

        <?$counter++;?>
        <tr>
            <td class="table-order__cell-image">
                <div class="page-cart-container-block">
                    <div class="page-cart-item-image">
                        <?//VTL-5?>
                        <?if ($image>0):?>
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=MakeImage($image, array('wl'=>180, 'hl'=>140, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                            </a>
                        <?else:?>
                            <img title="<?=$item['NAME']?>" class="adaptive-img" alt="<?=$item['NAME']?>" width="95" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                        <?endif;?>
                        <?//VTL-5?>
                    </div>
                    <div class="page-cart-item-quantity">
                        <a href="#" class="butt4 page-cart-item-quantity__add"> <i></i></a>
                        <input class="page-cart-item-quantity__input" name="qty[<?=$item['ID']?>]" type="text" id="qty_<?=$item['ID']?>" size="2" maxlength="7" value="<?=format_qty($item['QUANTITY'])?>" readonly />
                        <a href="#" class="butt4 page-cart-item-quantity__del" ><i></i> </a>
                    </div>
                </div>
            </td>

            <td class="table-order__cell-name">
                <div class="page-cart-item-name">
                    <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                </div>
                <div class="page-cart-item-total">
                    <?=price($item['PRICE']*$item['QUANTITY'], $item['CURRENCY'])?>
                </div>
            </td>

            <?/* VTL-7*/?>
            <td class="table-order__cell-razmer">
                <div class="td-content"><?=$item['PROPS_OFFERS']['RAZMER']['VALUE_PROPS']?></div>
            </td>

            <td class="table-order__cell-cvet">
                <div class="td-content"><?=$item['PROPS_OFFERS']['CVET']['VALUE_PROPS']?></div>
            </td>
            <?/* VTL-7*/?>

            <td class="table-order__cell-quantity">
                <?//MM-107?>
                <div style="margin-bottom: 15px;">
                    <?if ($arResult['COUNT_REQUIRE_PURCHASE'] > 0):?>
                        <p class="title orange"><strong>Требуется докупить:</strong> <img align="baseline"/></p>
                        <?$APPLICATION->IncludeComponent("bitrix:news", "require_purchase", array(
                                "IBLOCK_TYPE" => "info",
                                "IBLOCK_ID" => "57360",
                                "ADDITIONAL_FILTER" => array(
                                    'PROPERTY_LINKED_ITEMS' => $arResult['ID'],
                                ),

                                "ITEM_ID" => $arResult['ID'],
                                "ITEM_CODE" => $arResult['CODE'],

                                "NEWS_COUNT" => "120",
                                "USE_SEARCH" => "N",
                                "USE_RSS" => "N",
                                "USE_RATING" => "N",
                                "USE_CATEGORIES" => "N",
                                "USE_FILTER" => "N",
                                "SORT_BY1" => "SORT",
                                "SORT_ORDER1" => "ASC",
                                "SORT_BY2" => "",
                                "SORT_ORDER2" => "",
                                "CHECK_DATES" => "Y",
                                "SEF_MODE" => "Y",
                                "SEF_FOLDER" => "/require_purchase/",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "86400",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "N",
                                "SET_TITLE" => "Y",
                                "SET_STATUS_404" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "USE_PERMISSIONS" => "N",
                                "PREVIEW_TRUNCATE_LEN" => "",
                                "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "LIST_FIELD_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "LIST_PROPERTY_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                "DISPLAY_NAME" => "Y",
                                "META_KEYWORDS" => "meta_keywords",
                                "META_DESCRIPTION" => "meta_description",
                                "BROWSER_TITLE" => "custom_title",
                                "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "DETAIL_FIELD_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "DETAIL_DISPLAY_TOP_PAGER" => "N",
                                "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                                "DETAIL_PAGER_TITLE" => "Страница",
                                "DETAIL_PAGER_TEMPLATE" => "",
                                "DETAIL_PAGER_SHOW_ALL" => "Y",
                                "DISPLAY_TOP_PAGER" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "PAGER_TITLE" => "Требуется докупить",
                                "PAGER_SHOW_ALWAYS" => "Y",
                                "PAGER_TEMPLATE" => "",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "CATALOG_IBLOCK_TYPE" => "catalog",
                                "CATALOG_IBLOCK_ID" => "",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "SEF_URL_TEMPLATES" => array(
                                    "news" => "/require_purchase/",
                                    /*"section" => "#SECTION_CODE#/",
                                    "detail" => "#ELEMENT_CODE#/",*/
                                    "detail" => "#ELEMENT_CODE#/#TOVAR_CODE#/",
                                    //"detail" => "/require_purchase/#TOVAR_CODE#/#ELEMENT_CODE#/",
                                )
                            ),
                            false
                        );?>
                    <?endif;?>
                </div>
                <?//MM-107?>
            </td>

            <td class="table-order__cell-total">

            </td>

            <td class="table-order__cell-delete">
                <div class="page-cart-item-delete">
                    <a href="#" class="page-cart__delete_checkbox-item"></a>
                </div>
            </td>
            <td id="tr-background" style="padding: 16px 0 15px 0;">
                <div class="popup-back">
                    <div class="close-popup">
                        <a href="#" rel="#" class="come-back"><i></i><span>Вернуть</span></a>
                    </div>
                    <script>
                        $(".close-popup").on("click",function(){
                            $(".page-cart__delete_checkbox-item").show();
                            $(this).parent().parent().parent().removeClass("in-tr-background");
                        });
                    </script>
                    <? /* Ссылка отложить */?>
                    <div id="product-wishlist-<?=$item['ID']?>" class="product-wishlist-block cart-wishlist-block">
                        <a href="#product-wishlist-<?=$item['ID']?>"
                           rel="<?=$arResult['AJAX_CALL_ID']?>"
                           class="top-wishlist-link wishlist-link ajax_link_main_catalog cart-wishlist"
                           params="do=add2wishlist&id=<?=$offer_id?>"><i></i><span>В избранное</span>
                        </a>
                    </div>
                    <div class="delete-detail-block">
                        <a href="#" class="page-cart__delete_checkbox"><i></i><span>Удалить</span></a>
                        <input type="checkbox" class="delete_checkbox" name="del[<?=$item['ID']?>]" value="1" />
                    </div>
                </div>
            </td>
        </tr>
    <?endforeach;?>
    <script>
        $(".page-cart__delete_checkbox-item").on("click",function(){
            $(this).hide();
            $(this).parent().parent().parent().addClass("in-tr-background");
        });
    </script>
    </table>

    <div class="basket-bottom-block">
        <div class="basket-total-price">
            Итого без доставки: <span class="basket-total-price__inner"><?=price($arResult['TOTAL_PRICE'], $arResult['CURRENCY'])?></span>
        </div>
        <div class="button-make-order">
            <input class="butt3 butt3--big" type="submit" title="Заказать" onclick="$('#basket-form').submit();" value="Оформить заказ" id="send_order" />
        </div>
    </div>



    <?if (count($arResult['CART_ITEMS']) >= 4):?>
        <a href="#" class="cart-delete-all" onclick="if (confirm('Вы действительно хотите удалить все товары из корзины?')) {$('#hidden_do').val('deleteAll'); $('#basket-form').submit(); return false;} else { return false; }">Удалить все</a>
    <?endif;?>
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


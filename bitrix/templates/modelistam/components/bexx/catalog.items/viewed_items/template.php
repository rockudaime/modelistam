<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<?
//print_r($arResult);
if ($arResult['ITEMS']):?>

<?
$itemsToScroll = ($arParams['SCROLL_ITEMS']) ? $arParams['SCROLL_ITEMS'] : 5;
$showNavigation = ($arParams['SCROLL_HIDE_NAVIGATION'] != 'Y') ? 'true' : 'false';
$showPagination = ($arParams['SCROLL_HIDE_PAGINATION'] != 'Y') ? 'true' : 'false';
?>

<script>
	if (typeof(BIS.ajaxItemsAddToBasket) !== "object") {
        //init once
		BIS.ajaxItemsAddToBasket = {
            init: function(arrWithCodes) {
                //IMPORTANT!
                var arrWithCodes = arrWithCodes || ['new','hit', 'similar', 'viewed', 'motorcycle', 'vozd-zmei', 'roboti-igrushki', 'similar-products', 'original_parts'];
                this.initAjaxForItems(arrWithCodes);
            },
            initAjaxForItems: function(arrWithCodes) {
                var id,
                    formItem,
                    data,
                    i = 0;

                if (arrWithCodes.length) {
                    for (i=0; i<arrWithCodes.length; i++) {
                        (function(i) {
                            if ($('.wrap-order-'+arrWithCodes[i]).length) {
                                $('.wrap-order-'+arrWithCodes[i]).on('click', '.ajax-buy-product', function(e) {
                                    e.preventDefault();
                                    id = $(this).attr('data-href');
                                    formItem =  $('.wrap-order-'+arrWithCodes[i]).find('#product-order-form-'+id);
                                    data = formItem.serializeArray();

                                    ajax_load(formItem, '<?=$arResult['AJAX_CALL_ID']?>', data);

                                    $.gritter.add({
                                        title: 'Товар в корзине!',
                                        text: "Вы успешно добавили товар в <a href='/personal/cart/'>корзину</a>",
                                        time: 2000
                                    });
                                    return false;
                                });
                            }
                        })(i);
                    }
                }
            }
		};

		$(function() {
            BIS.ajaxItemsAddToBasket.init();
		});
	}

    $(function() {
        $('#owl-carousel-<?=$arParams['CODE'];?>').owlCarousel({
            items: <?=$itemsToScroll;?>,
            navigation: <?=$showNavigation;?>,
            pagination: <?=$showPagination;?>,
            responsive: true,
            responsiveRefreshRate : 200,
            responsiveBaseWidth: window,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,3],
            itemsTablet: [769,3],
            itemsTabletSmall: [600, 2],
            itemsMobile : [479,1],
        });
    })
</script>

    <?if ($arParams['AJAX_ENABLED']!="Y"):?>
        <form id="view-form" method="post" action="">
    <?endif;?>
        <input type="hidden" name="do" value="send" id="hidden_do" />
        <div class="poly-items" id="poly-items-<?=$arParams['CODE']?>">

            <div class="poly-items__inner <?if ($showNavigation == 'false') echo 'poly-items__inner--no-buttons'?>">
                <?if ($arParams['BLOCK_TITLE']):?>
                    <div class="poly-items__title">
                        <?=$arParams['BLOCK_TITLE']?>
                    </div>
                <?endif;?>
                <?if ($arParams['VIEWED']=="Y"):?>
                    <div class="how-many-items">
                        <a id="deleteAllviewed" href="#" onclick="ajax_load('#view-form', '<?=$arResult['AJAX_CALL_ID']?>', 'do=deleteAllviewed'); return false;" class="" title="Удалить все"><i></i><span>удалить эти товары</span></a>
                        <div class="items-in-cart">
                            <?//MM-231?>
                            <?$APPLICATION->IncludeComponent("bexx:cart", "line_template", array(
                                    "SHOW_DETAILS" => "N",
                                    "ORDER_DISCOUNT" => "N",
                                    "DELIVERY_ALLOW" => "N",
                                    "NOT_DELIVERY_SAME_CITY" => array(
                                    ),
                                    "WISHLIST" => "N",
                                    "SET_TITLE" => "N",
                                    "TOP_TEMPLATE" => "Y",
                                    "CACHE_TYPE" => "N",
                                    "PATH_TO_CART" => "/personal/cart/",
                                    "PATH_TO_ORDER" => "/personal/order/",
                                ),
                                false
                            );?>
                            <?//MM-231?>
                            <div class="button-make-order"style="display: inline-block; margin: 0 0 0 20px">
                                <input class="butt3 butt3--big" type="submit" title="Заказать" onclick="$('#basket-form').submit();" value="Оформить заказ" id="send_order" />
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <div  class="poly-items__inner__inner">
                    <div id="owl-carousel-<?=$arParams['CODE'];?>">
                        <?foreach ($arResult['ITEMS'] as $item):?>
                            <div class="poly-items__item">
                                <div class="poly-items__item-inner">
                                    <?if ($item['DETAIL_PICTURE']):?>
                                        <div class="poly-items__item-image-block">
                                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                                <?//MM-79 добавлен параметр 'zc'=>1  было 'h'=>141 изменено на 'h'=>226 и возвращено 'zc'=>0?>
                                                <img class="poly-items__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=MakeImage_two($item['DETAIL_PICTURE'], array('w'=>226, 'h'=>226, 'zc'=>0, 'q'=>100))?>" />
                                            </a>
                                        </div>
                                    <?else:?>
                                        <div class="poly-items__item-image-block">
                                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                                <img class="poly-items__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=SITE_TEMPLATE_PATH.'/images/no-photo.jpg'?>" />
                                            </a>
                                        </div>
                                    <?endif;?>

                                    <div class="poly-items__item-name">
                                        <a class="poly-items__item-name__link" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                                    </div>

                                    <div class="poly-items__price">
                                        <?if ($item['DISCOUNT_PRICE'] > 0):?>
                                            <span><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
                                            <script>
                                                $('.poly-items__price span').each(function() {
                                                    var toreplace = $(this).html();
                                                    toreplace = toreplace.replace("грн.","<p>грн</p>");
                                                    $(this).html(toreplace);
                                                });

                                            </script>
                                        <?else:?>
                                            <span>нет цены</span>
                                        <?endif;?>
                                    </div>
                                    <div id="product-order-<?=$item['ID'] ?>" class="button-mobile-display-change">
                                        <!--<a href="<?//=$item['DETAIL_PAGE_URL']?>" class="butt2 poly-items__bottom-link">Детали</a>-->
                                        <? if ($item['PRICE']>0): ?>
                                            <div class="product-add-basket wrap-order-<?=$arParams['CODE']?>">
                                                <div class="product-add-basket">
                                                    <form method="post" action="" id="product-order-form-<?= $item['ID'] ?>">
                                                        <input type="hidden" name="do" value="add2cart" />
                                                        <input type="hidden" name="qty" value="1" />
                                                        <input type="hidden" name="id" id="product-order-id-<?= $item['ID'] ?>" value="<?= $offer_id ? $offer_id : $item['ID'] ?>" />
                                                        <div id="product-order-<?= $item['ID'] ?>">
                                                            <a class="butt2 ajax-buy-product" data-href="<?= $item['ID'] ?>"><span>Купить</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        <? else:?>
                                            <a class="butt2 ajax-buy-product" href="<?=$item['ID'] ?>"><span>Уточнить цену</span></a>
                                        <?endif;?>

                                    </div>
                                    <? /* Ссылка отложить */?>
                                    <div id="product-wishlist-<?=$item['ID']?>" class="product-wishlist-block">
                                        <a href="#product-wishlist-<?=$item['ID']?>"
                                           rel="<?=$arResult['AJAX_CALL_ID']?>"
                                           class="top-wishlist-link wishlist-link ajax_link_main_catalog"
                                           params="do=add2wishlist&id=<?=$offer_id?>"><div>В избранное</div>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    <?if ($arParams['AJAX_ENABLED']!="Y"):?>
        </form>
    <?endif;?>

<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
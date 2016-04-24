<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<?if ($arResult['ITEMS']):?>

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
            pagination: <?=$showPagination;?>
        });
    })
</script>

<div class="poly-items" id="poly-items-<?=$arParams['CODE']?>">

    <div class="poly-items__inner <?if ($showNavigation == 'false') echo 'poly-items__inner--no-buttons'?>">
        <?if ($arParams['BLOCK_TITLE']):?>
            <div class="poly-items__title">
                <?=$arParams['BLOCK_TITLE']?>
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
                                        <?//MM-79 было 'h'=>141 изменено на 'h'=>226 и возвращено 'zc'=>0?>
                                        <img class="poly-items__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>226, 'h'=>226, 'zc'=>0, 'q'=>100))?>" />
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

                            <?// if ($arParams['DISABLE_RATING'] != 'Y'):?>
                               <!-- <div class="poly-items__rating">
                                    <div class="rating-content" title="Всего оценок: <?//=intval($item['PROPERTY_VALUES']['score_count']['VALUE'])?>, средняя оценка <?//=number_format(floatval($item['PROPERTY_VALUES']['score']['VALUE']), 2, ".", " ");?>">
                                        <input type="hidden" id="product-ratingback-<?//=$arParams['CODE']?>-<?=$item['ID']?>" value="<?//=intval($item['PROPERTY_VALUES']['score']['VALUE'])?>" />
                                        <div id="product-rating-<?//=$arParams['CODE']?>-<?//=$item['ID']?>"></div>
                                        <div id="product-ratingс-<?//=$arParams['CODE']?>-<?//=$item['ID']?>"></div>
                                    </div>
                                </div>-->
                            <?//endif;?>


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
                           <!-- <script type="text/javascript">
                                var productPriceUI = {
                                    init: function() {
                                        var priceBlock = $(".poly-items__price span");
                                        var priceText = $.trim(priceBlock.text());
                                        var currency = "<?=$GLOBALS['default_currency'];?>".toUpperCase();

                                        switch (currency) {
                                            case 'RUB':
                                                priceText = priceText.replace(/руб./g, "<span class='price_curr'>руб</span>");
                                                priceBlock.html(priceText);
                                                break;
                                            case 'UAH':
                                                priceText = priceText.replace(/грн./g, "<span class='price_curr'>грн</span>");
                                                priceBlock.html(priceText);
                                                break;
                                            default:
                                                //nothing to change
                                                break;
                                        }
                                    }
                                }
                                $(function() {
                                    productPriceUI.init();
                                })
                            </script>-->
                            <div id="product-order-<?=$item['ID'] ?>">
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

                            <?//if ($arParams['DISABLE_BUY_FUNCTIONALITY'] != 'Y'):?>
                                <!--<div class="poly-items__bottom-wrap">
                                    <div class="poly-items__bottom">
                                        <div class="product-add-basket wrap-order-<?//=$arParams['CODE']?>">
                                            <form method="post" action="" id="product-order-form-<?//= $item['ID'] ?>">
                                                <input type="hidden" name="do" value="add2cart" />
                                                <input type="hidden" name="qty" value="1" />
                                                <input type="hidden" name="id" id="product-order-id-<?//= $item['ID'] ?>" value="<?//= $offer_id ? $offer_id : $item['ID'] ?>" />
                                            </form>
                                        </div>
                                    </div>
                                </div>-->
                            <?//endif;?>
                        </div>

                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>

<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
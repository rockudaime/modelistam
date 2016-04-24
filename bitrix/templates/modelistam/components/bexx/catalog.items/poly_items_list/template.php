<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<?if ($arResult['ITEMS']):?>

<script>
	if (typeof(BIS.newAjaxItemsAddToBasket) !== "object") {
        //init once
		BIS.newAjaxItemsAddToBasket = {
            init: function(arrWithCodes) {
                //IMPORTANT!
                var arrWithCodes = arrWithCodes || ['similar-products'];

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
                                    id = $(this).attr('href');
                                    formItem =  $('.wrap-order-'+arrWithCodes[i]).find('#product-order-form-'+id);
                                    data = formItem.serializeArray();

                                    console.log('ajaxed..');

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
            BIS.newAjaxItemsAddToBasket.init();
		});
	}
</script>

<div class="poly-items-list" id="poly-items-list-<?=$arParams['CODE']?>">

    <div class="poly-items-list__inner">
        <?foreach ($arResult['ITEMS'] as $item):?>
            <div class="poly-items-list__item">
                <div class="poly-items-list__item-inner">

                    <?if ($item['DETAIL_PICTURE']):?>
                        <div class="poly-items-list__item-image-block">
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <?//MM-79 было 'h'=>131 изменено на 'h'=>229 и возвращено 'zc'=>0?>
                                <img class="poly-items-list__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>229, 'h'=>229, 'zc'=>0, 'q'=>100))?>" />
                            </a>
                        </div>
                    <?else:?>
                        <div class="poly-items-list__item-image-block">
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <img class="poly-items-list__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=SITE_TEMPLATE_PATH.'/images/no-photo.jpg'?>" />
                            </a>
                        </div>
                    <?endif;?>

                    <div class="poly-items-list__content">
                        <div class="poly-items-list__item-name">
                            <a class="poly-items-list__item-name__link" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                        </div>

                        <div class="poly-items-list__price">
                            <?if ($item['DISCOUNT_PRICE'] > 0):?>
                                <span><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
                            <?else:?>
                                <span>нет цены</span>
                            <?endif;?>
                        </div>

                        <?if ($arParams['DISABLE_BUY_FUNCTIONALITY'] != 'Y'):?>
                            <div class="poly-items-list__bottom-wrap">
                                <div class="poly-items-list__bottom">
                                    <div class="product-add-basket wrap-order-<?=$arParams['CODE']?>">
                                        <form method="post" action="" id="product-order-form-<?= $item['ID'] ?>">
                                            <input type="hidden" name="do" value="add2cart" />
                                            <input type="hidden" name="qty" value="1" />
                                            <input type="hidden" name="id" id="product-order-id-<?= $item['ID'] ?>" value="<?= $offer_id ? $offer_id : $item['ID'] ?>" />
                                            <div id="product-order-<?=$item['ID'] ?>">
                                                <? if ($item['PRICE']>0): ?>
                                                    <a class="butt1 ajax-buy-product" href="<?=$item['ID'] ?>"><span>Купить</span></a>
                                                <?endif;?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>

                    </div>
                </div>
            </div>
        <?endforeach;?>

    </div>
</div>

<?else:?>
    <p>Похожих товаров нет в наличии</p>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
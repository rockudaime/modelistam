<?
//PST-9
$frame = $this->createFrame()->begin('');
//PST-9
?>

<?if ($arParams['AJAX_ENABLED']!="Y"):?>
<script>
function update_cart () {
	$('form.hidden').remove();
	ajax_block('#basket-form');
	ajax_load('#basket-form', '<?=$arResult['AJAX_CALL_ID']?>', $('#basket-form').serializeArray());
}
</script>
<?endif;?>
<?if (is_array($arResult['ITEMS'])):?>
<?foreach ($arResult['ITEMS'] as $item):?>
	<form id="pricealert-item-<?=$item['ID']?>" method="post" action="/personal/cart/" class="hidden">
		<input type="hidden" name="do" value="add" />
		<input type="hidden" name="id" value="<?=$item['ID']?>" />
	</form>
<?endforeach;?>
<?if ($arParams['AJAX_ENABLED']!="Y"):?>
<div class="basket">
<form id="basket-form" method="post" action="">
<?endif;?>

	<div id="product-list" class="product-list responsive-table">
		<table class="table-order-product">
            <thead>
                <tr>
                    <th>Фото и наименование</th>
                    <th>Цена</th>
                    <th>Удалить</th>
                    <th>В корзину</th>
                </tr>
            </thead>

            <tbody>
                <?foreach ($arResult['ITEMS'] as $item):?>
                <tr>
                    <td data-title="Товар">
                        <div class="td-content">
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <?if ($item['DETAIL_PICTURE']):?>
                                <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" align="left" src="<?=MakeImage($item['DETAIL_PICTURE']?$item['DETAIL_PICTURE']:$item['PREVIEW_PICTURE'], array('wl'=>40, 'hl'=>40, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                <?else:?>
                                    <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" align="left" width="40" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                                <?endif;?>
                            </a>
                            <?if ($item['SECTION']['UF_ITEM_NAME']):?>
                                <p style="margin-left: 50px; font-size: 10px; margin-bottom: 2px;"><?=$item['SECTION']['UF_ITEM_NAME']?></p>
                            <?endif;?>
                            <p style="margin-left: 50px;"><a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></p>
                        </div>
                    </td>

                    <td data-title="Цена">
                        <div class="td-content"><?=price($item['PRICE'], $item['CURRENCY'])?></div>
                    </td>

                    <td data-title="Удалить">
                        <div class="td-content"> &nbsp;
                            <input type="checkbox" class="delete_checkbox" name="del[<?=$item['ID']?>]" value="1" />
                        </div>
                    </td>

                    <td data-title="В корзину">
                        <div class="td-content">
                            <?if (($arParams['WHISHLIST_ALLOW_BUY_NOT_EXISTING']=="N" AND $item['CATALOG_QUANTITY']>0) OR $arParams['WHISHLIST_ALLOW_BUY_NOT_EXISTING']!="N"):?>
                                <a class="butt1 detail-tabs__link" href="#" onclick="$('#pricealert-item-<?=$item['ID']?>').submit(); return false;">купить</a>
                            <?else:?>
                                Нет в наличии
                            <?endif;?>
                        </div>
                    </td>
                </tr>
                <?endforeach;?>
            </tbody>
		</table>
	</div>
	<div style="margin: 10px 0;">
		<div class="float-left" style="padding-left: 10px;">
			<input type="hidden" name="do" value="update" id="hidden_do" />
			<a href="javascript: void(0)" class="pricealert-delete" style="margin: 0;" onclick="update_cart()" title="Удалить отмеченные">Удалить отмеченные</a>
			<br clear="all" />
		</div>
		<br class="clear" />
	</div>
	<?if ($arParams['AJAX_ENABLED']!="Y"):?>
		</form>
		</div>
	<?endif;?>
<?else:?>
	<p class="text-large">У вас нет товаров с подпиской на изменение цен</p>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
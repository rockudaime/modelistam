<?//d($arResult);?>
<?
//PST-9
$frame = $this->createFrame()->begin('');
//PST-9
?>

<?if ($arParams['AJAX_ENABLED']=="Y"):?>
<script>
$(function(){change_city ()});
</script>
<?endif;?>
<?if ($arParams['AJAX_ENABLED']!="Y"):?>
<script>
function update_cart_wishlist () {
	$('form.hidden').remove();
	ajax_block('#basket-form-wishlist');
	ajax_load('#basket-form-wishlist', '<?=$arResult['AJAX_CALL_ID']?>', $('#basket-form-wishlist').serializeArray());
}
function change_city () {
	$('#zip_or_city').autocomplete({ 
		serviceUrl:'/bitrix/tools/ajax.php?ajax_call=<?=$arResult['AJAX_CALL_ID']?>&mode=location',
		minChars:2, 
		maxHeight:400,
		width:300,
		// callback function:
		//onSelect: function(value, data){ alert('You selected: ' + value + ', ' + data); }
		onSelect: function (value, data) {
			update_cart();
		}
	});
}
$(function(){change_city()});
</script>
<?endif;?>

<?if (is_array($arResult['CART_ITEMS'])):?>
<?foreach ($arResult['CART_ITEMS'] as $item):?>
	<form id="wishlist-item-<?=$item['ID']?>" method="post" action="" class="hidden">
		<input type="hidden" name="do" value="add" />
		<input type="hidden" name="id" value="<?=$item['ID']?>" />
	</form>
<?endforeach;?>
<?if ($arParams['AJAX_ENABLED']!="Y"):?>
<div class="basket">
<form id="basket-form-wishlist" method="post" action="">
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
			<?foreach ($arResult['CART_ITEMS'] as $item):?>
			<tr>
				<td data-title="Товар">
					<div class="td-content">

                        <a href="<?=$item['DETAIL_PAGE_URL']?>">
                            <?if ($arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE']):?>
                            <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" align="left" src="<?=MakeImage($arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE']?$arResult['ITEMS'][$item['PRODUCT_ID']]['DETAIL_PICTURE']:$arResult['ITEMS'][$item['PRODUCT_ID']]['PREVIEW_PICTURE'], array('wl'=>40, 'hl'=>40, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" width="40" height="40" />
                            <?else:?>
                                <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" align="left" width="40" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                            <?endif;?>
                        </a>


						<?if ($arResult['ITEMS'][$item['PRODUCT_ID']]['SECTION']['UF_ITEM_NAME']):?>
							<p style="margin-left: 50px; font-size: 10px; margin-bottom: 2px;"><?=$arResult['ITEMS'][$item['PRODUCT_ID']]['SECTION']['UF_ITEM_NAME']?></p>
						<?endif;?>
						<p style="margin-left: 50px;"><a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></p>
					</div>
				</td>

				<td data-title="Цена">
					<div><?=price($item['PRICE'], $item['CURRENCY'])?></div>
				</td>

				<td data-title="Удалить">
					<div> &nbsp;
						<input type="checkbox" class="delete_checkbox" name="del[<?=$item['ID']?>]" value="1" />
					</div>
				</td>

				<td data-title="В корзину">
					<?if (($arParams['WHISHLIST_ALLOW_BUY_NOT_EXISTING']=="N" AND $arResult['ITEMS'][$item['PRODUCT_ID']]['CATALOG_QUANTITY']>0) OR $arParams['WHISHLIST_ALLOW_BUY_NOT_EXISTING']!="N"):?>
					<div>
						<a class="butt1 detail-tabs__link" href="#" onclick="$('#wishlist-item-<?=$item['ID']?>').submit(); return false;">купить</a>
					</div>
					<?else:?>
						нет в наличии
					<?endif;?>
				</td>
			</tr>
			<?endforeach;?>
            </tbody>

		</table>
	</div>
	<div style="margin: 10px 0;">
		<div>
			<input type="hidden" name="do" value="update" id="hidden_do" />
			<a href="javascript: void(0)" class="basket-btns" style="margin: 0;" onclick="update_cart_wishlist()" title="Удалить отмеченные">Удалить отмеченные</a>
			<br clear="all" />
		</div>
		<br class="clear" />
	</div>
	<?if ($arParams['AJAX_ENABLED']!="Y"):?>
		</form>
		</div>
	<?endif;?>
<?else:?>
	<p class="text-large">У вас нет отложенных товаров</p>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
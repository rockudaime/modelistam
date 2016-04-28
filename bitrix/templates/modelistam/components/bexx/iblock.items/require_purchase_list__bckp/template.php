<?//d($arParams);?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin('');
//PST-9
?>

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

<?if ($arParams['AJAX_ENABLED']!="Y"):?>
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
            ajax_load('#basket-form', '<?=$arResult['AJAX_CALL_ID']?>', $('#basket-form').serializeArray());
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
    $(function() {
        cartObj.init();
    })
	</script>
<?endif;?>


<?if (is_array($arResult['ITEMS'])):?>

	<?if ($arParams['AJAX_ENABLED']!="Y"):?>
		<div class="basket-container">
		<form id="basket-form" method="post" action="">
	<?endif;?>
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
			<?foreach ($arResult['ITEMS'] as $item):?>

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
                           
                         
                        </div>
                        <?//MM-107?>
					</td>
					
					<td class="table-order__cell-total">

					</td>

                    <td class="table-order__cell-delete">
                        <div class="page-cart-item-delete">
                            <a href="#" class="page-cart__delete_checkbox"></a>
                            <input type="checkbox" class="delete_checkbox" name="del[<?=$item['ID']?>]" value="1" />
                        </div>
                    </td>
				</tr>
			<?endforeach;?>
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

<?
//PST-9
$frame->end();
//PST-9
?>
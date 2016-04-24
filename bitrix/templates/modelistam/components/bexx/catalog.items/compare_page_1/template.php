<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?
//d($arResult);
$back_url = "";
if ($_SERVER['HTTP_REFERER']) {
	$back_url = $_SERVER['HTTP_REFERER'];
} elseif ($_SERVER['REDIRECT_URL']) {
	$back_url = $_SERVER['REDIRECT_URL'];
}
?>
<?if (is_array($arResult['ITEMS'])):?>
	<?
	$arResult['ITEMS'] = array_slice($arResult['ITEMS'], 0, 3, true);
	$items_ids = array_keys($arResult['ITEMS']); // знаем все ID всех товаров
	$count = count($arResult['ITEMS']);
	if ($count<2 AND $back_url) {
		//LocalRedirect($back_url);
		unset($_SESSION['back_url']);
		//exit();
	}
	// Формируем ссылки для удаления товаров из сравнения. Зажопский код, не обессутьте
	$delete_urls = array();
	$delete_url_parts = array();
	foreach ($items_ids as $items_id) $delete_url_parts[$items_id] = "compare[]=".$items_id;
	foreach ($items_ids as $items_id) {
		$temp_url_parts = $delete_url_parts;
		unset($temp_url_parts[$items_id]);
		$delete_urls[$items_id] = $APPLICATION->GetCurPageParam(implode("&", $temp_url_parts), array("compare"), false);
	}
	?>

    <h1>Сравнить товар</h1>

	
	<div class="compare-page">
		<table class="compare-page__table">
			<tr>
				<td width="25%" valign="top">
                    <span class="compare-page__top-info">
                        Вы отметили <?=padej(count($arResult['ITEMS']), "товарную<br/>позицию", "товарные<br/>позиции", "товарных<br/>позиций")?>
                        для сравнения
                    </span>
					<a id="removeItems" class="compare-page__remove-all-items" title="Удалить товары из сравнения и вернуться на предыдущую категорию" href="<?=$back_url?>">Удалить товары из сравнения</a>
				</td>
				<?foreach ($arResult['ITEMS'] as $item):?>
				    <td width="25%" valign="top">
                        <div class="compare-page__item">
                            <?
                            if ($count>1 AND $delete_urls):?>
                            <div class="compare-page__item__delete">
                                <a class="del-red-left" href="<?=$delete_urls[$item['ID']]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-delete.png" /></a>
                            </div>
                            <?endif;?>


                            <div class="compare-page__item__image-block">

                                <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                    <?if ($item['DETAIL_PICTURE']):?>
                                    <img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>80, 'h'=>80))?>" />
                                    <?else:?>
                                        <img width="80" alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                                    <?endif;?>
                                </a>
                            </div>

                            <div class="compare-page__item__right">
                                <div class="compare-page__item__name"> <?=$arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['UF_ITEM_NAME']?><br />
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                                </div>

                                <?
                                $offer_id = $item['ID'];
                                if (!$item['DISCOUNT_PRICE'] AND !empty($item['OFFERS']) AND is_array($item['OFFERS'])) {
                                    $min_offer_price = 0;
                                    foreach ($item['OFFERS'] as $offer) {
                                        if ($offer['PRICE']<$min_offer_price OR $min_offer_price==0) {
                                            $min_offer_price = $offer['PRICE'];
                                            $offer_id = $offer['ID'];
                                        }
                                    }
                                    if ($min_offer_price>0) {
                                        $item['DISCOUNT_PRICE'] = $min_offer_price;
                                    }
                                }
                                ?>

                                <div class="product-compare__item__price">
                                    <div class="price bold">
                                        <?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?>
                                    </div>
                                </div>

                                <div class="product-compare__item__buy-block product-status">
                                    <div id="product-order-<?=$offer_id?>">
                                        <a href="#product-order-<?=$offer_id?>" rel="<?=$arResult['AJAX_CALL_ID']?>" params="do=add2cart&id=<?=$offer_id?>" id="basket-button-product-order-<?=$offer_id?>" class="ui-button-blue ui-button-blue--cart ajax_link" title="купить <?=$item['NAME']?>"><span>Купить</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>
				    </td>
				<?endforeach;?>
				<?for ($i=3-$count;$i>0;$i--):?>
					<td width="25%"></td>
				<?endfor;?>
			</tr>
		</table>
		
		<script type="text/javascript">
			var removeItems = function() {
				var removeLink = $('#removeItems');
				var hrefLink = removeLink.attr('href');
				var ajaxLoader= $("<img />");
				
				ajaxLoader.attr('alt', 'Редирект..')
				ajaxLoader.attr('src', '<?=SITE_TEMPLATE_PATH?>/images/ajax-loader.gif');
				
				removeLink.on('click', function(e) {
					e.preventDefault();
					removeLink.html(ajaxLoader);
					$.ajax({
						url : hrefLink,
						data : 'compare_clear',
						success: function() {
							window.location.href = hrefLink;
						}
					})
				});
			}
	
			$(function () {
				removeItems();
			
				$('#product-rating-<?=$item['ID']?>').rateit({
					max: 5,
					step: 1,
					backingfld: '#product-ratingback-<?=$item['ID']?>',
					starwidth: 15,
					starheight: 15,
					resetable: false
				});
				$("#product-rating-<?=$item['ID']?>").bind('rated', function (event, value) {
					ajax_load('#product-ratingс-<?=$item['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=rate&id=<?=$item['ID']?>&rating='+value);
				});
			});
		</script>
	</div>

    <?if ($arResult['PRIMARY_TYPE']):?>
	    <?if (is_array($arResult['MAIN_PROPS'][$arResult['PRIMARY_TYPE']]) AND !empty($arResult['MAIN_PROPS'][$arResult['PRIMARY_TYPE']])):?>

            <div class="product-compare">
                <table class="product-compare__table">
                    <tr>
                        <td width="50%" align="left">
                            <div class="compare-page__tech-title">Технические характеристики</div>
                        </td>
                        <td width="50%" align="right"><a href="javascript:void(0);" onclick="$('.diff').toggleClass('compare-difference'); return false;" class="compare-light">Подсветить различия</a></td>
                    </tr>
                </table>
            </div>

		    <table class="compare-page__tech" width="100%" >
			    <?$count_props = 0?>
			    <?foreach ($arResult['MAIN_PROPS'][$arResult['PRIMARY_TYPE']] as $prop_id=>$main_prop):?>
				    <?
				    // маленькая проверка на наличие значений
				    ?>
				    <?$count_props++;?>
				    <?if ($main_prop['USER_TYPE']=="Delimiter"):?>
					    <tr>
						    <td colspan="4" class="blue-header"><strong><?=$main_prop['NAME']?></strong></td>
					    </tr>
				    <?else:?>
					    <?
					    $next_prop = array_slice($arResult['MAIN_PROPS'], $count_props, 1);
					    // Проверяем свойства на одинаковость
					    $test = array();
					    $diff = "diff";
					    $is_empty = false;
					    foreach ($items_ids as $items_id) {
                            $v = $arResult['ITEMS'][$items_id]['DESCRIPTION'][$prop_id]['VALUE'];
                            if (is_array($v)) $v = implode(", ", $v);
						    $test[] = $v;
					    }
					    $uniq = array_unique($test);
					    if (count($uniq)==1) $diff=""; // одниковые свойства все
					    if (count($uniq)==1 AND empty($uniq[0])) $is_empty = true;
					    if (!$is_empty):?>
						    <tr>
							    <td width="25%" class="compare-page__tech__cell property <?=$diff?>" valign="top">
								    <div class="property-name"><?=$main_prop['NAME']?></div>
							    </td>
							    <?foreach ($arResult['ITEMS'] as $item):?>
                                    <?
                                    $v = $item['DESCRIPTION'][$prop_id]['VALUE'];
                                    ?>
								    <td width="25%" class="compare-page__tech__cell <?=$diff?>" valign="top">
										<div class="info-block-inner">
											<?if ($main_prop['PROPERTY_TYPE']=="L"):?>
												<?if ($main_prop['MULTIPLE']=="Y" AND is_array($v)) {
													$out = array();
													foreach ($v as $vv) $out[] = $main_prop['ENUM_VALUES'][$vv];
													echo implode(", ", $out);
												} else {
													echo $main_prop['ENUM_VALUES'][$v];
												}?>
											<?elseif ($main_prop['USER_TYPE']=="Checkbox"):?>
												<?if ($v==1) echo "Есть";?>
											<?elseif ($main_prop['USER_TYPE']=="Measured" AND $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']):?>
												<?
												$v =(is_array($v))?implode(", ", $v):$v;
												if ($v AND !empty($v)) {
													echo str_replace("#", $v, $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']);
												}?>
											<?else:?>
												<?if (!empty($v)) {
													$v = (is_array($v))?implode(", ", $v):$v;
													$findText = 'http:';
													if (strstr($v, $findText)) {
														echo "<a href='".$v."' class='uri-value' target='_blank'>Перейти на сайт</a>";
													} else {
														echo $v;
													}
												}?>
											<?endif;?>
											<br />
										</div>
								    </td>
							    <?endforeach;?>
							    <?for ($i=3-$count;$i>0;$i--):?>
								    <td width="25%" class="compare-page__tech__cell <?=$diff?>"></td>
							    <?endfor;?>
						    </tr>
					    <?endif;?>
				    <?endif;?>
			    <?endforeach;?>
		    </table>
        <?endif;?>
	<?endif;?>
<?else:?>
	<?=ShowError("Нет товаров для сравнения");?>
<?endif;?>
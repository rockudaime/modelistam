<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?//d($arResult);?>
<?if (is_array($arResult['ITEMS'])):?>


<?
    if($arResult['SECTION']['NAME']){
        $APPLICATION->SetTitle($arResult['SECTION']['NAME']." - интернет магазин BSP (Харьков, Украина)");
        $APPLICATION->SetPageProperty("description", "купить в Харькове ".$arResult['SECTION']['NAME']." в интернет-магазине BSP по самым низким ценам.");
        $APPLICATION->SetPageProperty("custom_h1", "Y");
        $APPLICATION->SetPageProperty("custom_h1_text", $arResult['SECTION']['NAME']);
    } else{
        $APPLICATION->SetPageProperty("title","Каталог товаров");
        $APPLICATION->SetTitle("Каталог товаров");
    }
    ?>
<?
    // Небольшие настройки шаблона
    $new_days = 10; // Количество дней с момента появления товара, в течение которых товар считается новым
    $arUriKillParams = array( // Эти параметры удаляются из адреса страницы в постраничной навигации
        "page", // номер страницы
        "p", // количество элементов на страницу
        "s", // поле для сортировки
        "d", // направление сортировки
        "sort", // сортировка (устаревшее)
        "s_prop", // поле для сортировки по характеристикам
        "s_prop_dir", // направление для сортировки по характеристикам
        "reset_sorting", // сброс сортировки
    );
    ?>

<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/hider-prices/hider.min.js"></script>


	<?if ($arParams['ALLOW_USER_PAGENAV']=="Y"):?>
	<!-- panel -->
        <form id="sort-form" method="get" action="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>">
            <input type="hidden" name="sort" id="sort-order" value="" />
            <input type="hidden" name="p" id="paging" value="" />
            <div class="sort sort-main-block">
                <div class="float-right">
                    <a href="<?=$APPLICATION->GetCurPageParam("reset_sorting", $arUriKillParams, false)?>">сбросить</a>
                </div>
                <div id="product-sort-simple" style="width: 100%;">
                    <?if (is_array($arParams['SORTING_PANEL_OPTIONS']) AND !empty($arParams['SORTING_PANEL_OPTIONS'])):?>
                        <div class="float-left">
                            сортировка: &nbsp; 
                            <?$counter=0?>
                            <?foreach ($arResult['SORTING_NAMES'] as $sk=>$sort_name):?>
                                <?$counter++?>
                                <?if ($sk):?>
                                    <?
                                    if (strpos($sk, "property_")===0 AND $sort_name==1) {
                                        $sort_name = $arResult['PROPERTIES'][str_replace("property_", "", $sk)]['NAME'];
                                    }
                                    ?>
                                    <?if ($_SESSION['sorting']==$sk):?>
                                        <a class="selected" href="<?=$APPLICATION->GetCurPageParam("s=".$sk."&d=".($_SESSION['sorting_dir']=="asc"?"desc":"asc"), $arUriKillParams, false)?>"><?=strtolower($sort_name)?> <img src="<?=SITE_TEMPLATE_PATH?>/images/arr-black-<?=$_SESSION['sorting_dir']=="asc"?"up":"down"?>.gif" alt="<?=strtolower($sort_name)?>" /></a>
                                    <?else:?>
                                        <a href="<?=$APPLICATION->GetCurPageParam("s=".$sk, $arUriKillParams, false)?>"><?=strtolower($sort_name)?></a> &nbsp; 
                                    <?endif;?>
                                <?endif;?>
                                <?if ($counter<count($arParams['SORTING_PANEL_OPTIONS'])):?>
                                    |&nbsp;&nbsp;
                                <?endif;?>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                </div>
                <br class="clear" />
            </div>
        </form>
    <!-- / panel -->
    <?endif;?>
    
    
	<div id="catalog-container">
		<!-- items -->
		<div class="main-catalog-products">
			
			<?$i=0;?>
			<?foreach ($arResult['ITEMS'] as $item):?>
			
				<?//klm ZN-27
					$item['availability_value'] = $arResult['IBLOCK']['PROPERTIES']['availability']['ENUM_VALUES'][$item['PROPERTY_VALUES']['availability']['VALUE']]['VALUE'];
				//klm ZN-27?>         
			
				<?
				$i++;
				$offer_id = $item['ID'];
				?>
				
				<div class="product<?if ($i>=count($arResult['ITEMS'])):?> last<?endif;?>">
					<div class="product-inner">
						<div class="description">
			
							<!-- Картинка -->
							<?if ($item['DETAIL_PICTURE']):?>
								<div class="product-image">
									<a href="<?=$item['DETAIL_PAGE_URL']?>">
										<img alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>120, 'h'=>120))?>" />
									</a>
								</div>
							<?endif;?>
							<?if (!$item['PREVIEW_PICTURE'] && !$item['DETAIL_PICTURE']):?>
								<div class="product-image">
									<a href="<?=$item['DETAIL_PAGE_URL']?>"><img width="120" height="120" alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.gif" /></a>
								</div>
							<?endif;?>
							
							<div class="product-title">
								<?if (strlen($arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['UF_ITEM_NAME'])):?>
									<h4>
										<?=$arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['UF_ITEM_NAME']?>
									</h4>
								<?endif;?>
								<h4>
									<a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
								</h4>
							</div>
							
							<!--Рейтинг товара-->
							<div class="product-rating-block">
								<div class="rating-content" title="Всего оценок: <?=intval($item['PROPERTY_VALUES']['score_count']['VALUE'])?>, средняя оценка <?=number_format(floatval($item['PROPERTY_VALUES']['score']['VALUE']), 2, ".", " ");?>">
									<input type="hidden" id="product-ratingback-<?=$item['ID']?>" value="<?=intval($item['PROPERTY_VALUES']['score']['VALUE'])?>" />
									<div id="product-rating-<?=$item['ID']?>"></div>
									<div id="product-ratingс-<?=$item['ID']?>"></div>            
								</div>
								<div class="rating-count">
									<span><?=padej(intval($item['PROPERTY_VALUES']['score_count']['VALUE']), "оценка", "оценки", "оценок")?></span>
								</div>
							</div>
							
							<!-- Если есть в наличии -->
							<? if ($item['CATALOG_QUANTITY'] >= 1): ?>
								<div class="product-avail-yes">Есть в наличии</div>
							<? else: ?>
								<div class="product-avail-no">Нет в наличии</div>
							<? endif; ?>   
							
							<!--Цена товара -->
							<div class="product-price-block">
							
								<?if ($item['PRICE']>0 OR (is_array($item['OFFERS']) AND !empty($item['OFFERS']))):?>
									
									<?if ($item['DISCOUNT_PRICE']<$item['PRICE'] AND $item['DISCOUNT_PRICE']>0):?>
										<div class="inner-price-block">
											<span class="black">старая цена:</span><br />
											<strong class="dark-grey"><?=price($item['PRICE'], $item['CURRENCY'])?></strong>
										</div>
									<?endif;?>
									
									<div class="inner-price-block">
										<?
										// если цена = 0 и есть товарные предложения, то показваем первое товарное предложение
										if (!$item['DISCOUNT_PRICE'] AND (is_array($item['OFFERS']) AND !empty($item['OFFERS']))) {
											$offer = reset($item['OFFERS']);
											$offer_id = $offer['ID'];
											$item['DISCOUNT_PRICE'] = $offer['PRICE'];
											$item['CURRENCY'] = $offer['CURRENCY'];
										}
										?>
										<?if (!empty($item['OFFERS']) AND is_array($item['OFFERS'])):?>
											<?foreach ($item['OFFERS'] as $offer):?>
												<?
												$hidden = "";
												if ($offer_id!=$offer['ID']) $hidden = 'style="display: none;"';
												?>
												<div class="price-offer">
													<strong class="sku_price" id="sku_price_<?=$offer['ID']?>" <?=$hidden?>><?=price($offer['PRICE'], $offer['CURRENCY'])?></strong>
												</div>
											<?endforeach;?>
										<?else:?>
											<div id="sku_price_<?=$item['ID']?>" class="price-offer">
												<?//=price($item['DISCOUNT_PRICE'], $item['CURRENCY']);?>
												
												<? /* Price changer from text to image by Oleg v.01 :D (php+base64+js+canvas) For ie7-8 outputs numbers not images */ ?>
												<?$priceHide = price($item['DISCOUNT_PRICE'], $item['CURRENCY']);
												$saltWord = 'lEQVRoQaObLDMAiGk';
												$priceBase64 = $saltWord.base64_encode($priceHide);
												?>
												<canvas id="textCanvas_<?=$item['ID']?>" height="20" width="170"></canvas>
												<img id="imagePrice_<?=$item['ID']?>" />
												<script>
													$(function() {
														Base64._encodeIt532("textCanvas_<?=$item['ID']?>", "imagePrice_<?=$item['ID']?>", "<?=$priceBase64?>");
													});
												</script>
												<? /* end of Price changer */ ?>
												
											</div>
										<?endif;?>

										<?if (is_array($item['OFFERS']) AND !empty($item['OFFERS'])):?>
											<div>
												<select name="offer" style="width: 145px;" rel="<?=$item['ID']?>" class="sku_change">
													<?if ($item['PRICE']):?>
														<option value="<?=$item['ID']?>">-- выберите --</option>
													<?endif;?>
													<?foreach ($item['OFFERS'] as $offer):?>
														<option value="<?=$offer['ID']?>"><?=$offer['NAME']?>, <?=price($offer['PRICE'], $offer['CURRENCY']);?></option>
													<?endforeach;?>
												</select>
											</div>
										<?endif;?>
											
										<?//klm ZN-27?>
										<? if ($item['availability_value'] == 'Есть в наличии' OR $arParams['ALLOW_BUY_NOT_EXISTING'] == "Y"): ?>
											<div class="product-add-basket">
												<form method="post" action="" id="product-order-form-<?= $item['ID'] ?>">
													<input type="hidden" name="do" value="add2cart" />
													<input type="hidden" name="qty" value="1" />
													<input type="hidden" name="id" id="product-order-id-<?= $item['ID'] ?>" value="<?= $offer_id ? $offer_id : $item['ID'] ?>" />
													<div id="product-order-<?= $item['ID'] ?>">
														<a class="ui-button-blue ajax-buy-product" href="<?= $item['ID'] ?>">В корзину</a>
													</div>
												</form>
											</div>
										<? else: ?>
											<div class="gray float-left strong"></div>
										<? endif; ?>   
										<?//klm ZN-27?>                                            
											
										<br class="clear" />
										
										<ul class="list-mark-small">
											<?if ($item['DISCOUNT_PRICE']<$item['PRICE']):?>
												<li><span class="black">Ваша скидка <?=price($item['PRICE']-$item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span></li>
											<?endif;?>
											<?if ($item['PROPERTY_VALUES']['free_shipping']['VALUE']>date("d.m.Y")):?>
												<li><span class="black">Бесплатная доставка</span></li>
											<?endif;?>
										</ul>
									</div>
								
								<?else:?>
									<div class="product-inner-price">
										<div class="price-offer" style="color:#6a7272">
											Нет цены
										</div>
									</div>
								<?endif;?>
						
							</div>
							
							<!-- Код товара -->
							<?if ($item['PROPERTY_VALUES']['partnumber']['VALUE']):?>
								<div class="product-number">
									<span>Код товара: <?=$item['PROPERTY_VALUES']['partnumber']['VALUE']?></span>
								</div>
							<?endif;?>
							
							
							<!--Краткое описание товара-->
							<?if (strlen($item['PREVIEW_TEXT'])):?>
								<div class="product-short-info"><?=$item['PREVIEW_TEXT']?></div>
							<?endif;?>
							
							<!--Характеристики товара -->
							<?if ($arResult['MAIN_PROPS'] AND !empty($item['DESCRIPTION'])):?>
								<div class="product-properties">
									<?
									if ($arResult['TYPE_PROP']) {
										$item_type = $item['PROPERTY_VALUES'][$arResult['IBLOCK']['PROPERTIES'][$arResult['TYPE_PROP']]['CODE']?$arResult['IBLOCK']['PROPERTIES'][$arResult['TYPE_PROP']]['CODE']:$arResult['TYPE_PROP']]['DESCRIPTION'];
									} else {
										$item_type = $arResult['PRIMARY_TYPE'];
									}
									?>
									<?foreach ($item['DESCRIPTION'] as $k=>$v):?>
										<?if (!empty($v['VALUE']) AND !empty($arResult['MAIN_PROPS'][$item_type][$k])):?>
											<?
											$main_prop = $arResult['MAIN_PROPS'][$item_type][$k];
											if ($main_prop['USER_TYPE']=="Checkbox") $v['VALUE'] = "Есть";
											elseif ($main_prop['USER_TYPE']=="Measured" AND $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']) $v['VALUE'] = str_replace("#", $v['VALUE'], $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']);
											elseif ($main_prop['PROPERTY_TYPE']=="L") {
												if ($main_prop['MULTIPLE']=="Y") {
													foreach ($v['VALUE'] as $ke=>$ve) {
														$v['VALUE'][$ke] = $main_prop['ENUM_VALUES'][$ve];
													}
												} else {
													$v['VALUE'] = $main_prop['ENUM_VALUES'][$v['VALUE']];
												}
											}
											if (is_array($v['VALUE'])) $v['VALUE'] = implode(", ", $v['VALUE']);
											?>
											<strong><?=$main_prop['NAME']?>:</strong> <?=$v['VALUE']?>, 
										<?endif;?>
									<?endforeach;?>
								</div>
							<?endif;?>
							
							<!--Ссылка сравнить-->
							<?if ($arParams['SHOW_COMPARE_LINK']!="N"):?>
								<div id="product-compare-<?=$item['ID']?>" class="product-compare-block">
									<div class="float-left checkbox-black" onclick="ajax_load('#product-compare-<?=$item['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$item['ID']?>&back_url=<?=urlencode($APPLICATION->GetCurPageParam());?>');"></div>
									<div class="product-compare-link"><span>Сравнить</span></div>
								</div>
							<?endif;?>
							
							<!--Ссылка отложить-->
							<div id="product-wishlist-<?=$item['ID']?>" class="product-wishlist-block">
								<a href="#product-wishlist-<?=$item['ID']?>" rel="<?=$arResult['AJAX_CALL_ID']?>" class="ajax_link" params="do=add2wishlist&id=<?=$offer_id?>">Отложить</a>
							</div>
			

						</div>
					</div>
				</div>
				<?//d($item['OFFERS'])?>
			<?endforeach;?>
		</div>
		<script>
		$(function(){
			$('.ajax-buy-product').click(function(){
				var id = $(this).attr('href');
				var data = $('#product-order-form-'+id).serializeArray();
				ajax_load('#product-order-'+id, '<?=$arResult['AJAX_CALL_ID']?>', data);
				$.gritter.add({
					title: 'Товар в корзине!',
					text: "Вы успешно добавили товар в <a href='/personal/cart/'>корзину</a>",
					time: 2000
				});
				return false;
			});
			$('.sku_change').change(function(){
				var parent_id = $(this).attr('rel');
				var sku_id = $(this).val();
				$('.sku_price').hide();
				$('#sku_price_'+sku_id).show();
				$('#product-order-id-'+parent_id).val(sku_id);
				//ajax_load('#sku_price_'+parent_id, '<?=$arResult['AJAX_CALL_ID']?>', {'do': "update_sku", 'id': parent_id, 'sku': sku_id});
				return false;
			});
		});
		</script>
		<!-- / items -->
	
		<? /* Pager bottom */ ?>
		<?if ($arResult['NAV']['PAGES_COUNT']>1 AND $arParams['ALLOW_PAGENAV']=="Y"):?>
			<div class="catalog-bottom-pager">
				
				<div class="pager-main-block">
					<?if ($arResult['NAV']['CURRENT_PAGE']>1):?>
					<a class="pmb-black" href="<?=$APPLICATION->GetCurPageParam("", array("page"), false)?>">В начало</a>
					<a class="pmb-black" href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']-1), array("page"), false)?>">Пред.</a>
					<?endif;?>
					<?
					$left_space = 0;
					$right_space = 0;
					for ($i=1; $i<=$arResult['NAV']['PAGES_COUNT']; $i++) {
						if ($arResult['NAV']['PAGES_COUNT'] < 5) {
							if ($arResult['NAV']['CURRENT_PAGE'] == $i):?>
								<span class="strong"><?=$i?></span> &nbsp;
							<?else:?>
								<a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"<?if ($arResult['NAV']['CURRENT_PAGE'] == $i) echo ' class="current_page"';?>><?=$i?></a> &nbsp;
							<?endif;
						} else {
							if ($arResult['NAV']['CURRENT_PAGE'] == $i) {
								?> <span class="strong"><?=$i?></span> &nbsp; <?
							} else {
								if ($i-1 == $arResult['NAV']['CURRENT_PAGE'] OR $i+1 == $arResult['NAV']['CURRENT_PAGE']
									OR $i-2 == $arResult['NAV']['CURRENT_PAGE'] OR $i+2 == $arResult['NAV']['CURRENT_PAGE']) {
									?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a> &nbsp; <?
								} elseif ($i < $arResult['NAV']['PAGES_COUNT'] AND $i > $arResult['NAV']['CURRENT_PAGE']) {
									if ($right_space == 0) echo "&nbsp;&rarr;&nbsp;";$right_space++;                                
								} elseif ($i > 1 AND $i < $arResult['NAV']['CURRENT_PAGE']) {
									if ($left_space == 0) echo "&nbsp;&larr;&nbsp;"; $left_space++;
								} else {
									?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a> &nbsp; <?
								}
							}
						}
					}
					?>
					<?if ($arResult['NAV']['CURRENT_PAGE']<$arResult['NAV']['PAGES_COUNT']):?>
					<a class="pmb-black" href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']+1), array("page"), false)?>">След.</a>
					<a class="pmb-black" href="<?=$APPLICATION->GetCurPageParam("page=".$arResult['NAV']['PAGES_COUNT'], array("page"), false)?>">В конец</a>
					<?endif;?>
				</div>
				
				<div class="pager-bottom-block">
					<span class="grey">
						<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+1?> 
						-
						<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+count($arResult['ITEMS'])?>
						из
					</span>
					<span class="strong"><?=$arResult['NAV']['TOTAL']?></span>
				</div>
				
			</div>
		<?endif;?>
	
		<? /* SEO block */ ?>
		<?if ($arResult['SECTION']['DESCRIPTION'] AND intval($_GET['page'])<=1):?>
			<div class="catalog-seo-block">
				<p><?=$arResult['SECTION']['DESCRIPTION']?></p>
			</div>
		<?endif;?>

	</div>
	<!-- / #catalog-container -->

<?else:?>
    <p>Ничего не найдено</p>
<?endif;?>
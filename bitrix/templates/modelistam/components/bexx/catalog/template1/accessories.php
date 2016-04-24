<div style="margin: 0pt; width: 572px;" class="block float-left">
	<div class="top_line"></div>
	<div class="corners-white top_right"></div>
	<div class="corners-white top_left"></div>
	<div class="content">
		
		<?	
		$ADDITIONAL_FILTER = array();
		if ($_GET['for']>0) { // Ищем аксессуары для
			// Выборка аксессуаров
			if (isset($_GET['for']) AND is_numeric($_GET['for'])) {
				$for = intval($_GET['for']);
				CModule::IncludeModule("iblock");
				$rs = CIBlockElement::GetList(array(), array('ID'=>$for));
				$for = $rs->GetNext();
				if ($for['ID']>0 AND $for['IBLOCK_ID']==$arParams['IBLOCK_ID']) {
					$APPLICATION->SetTitle("Аксессуары для ".$for['NAME']);
					$APPLICATION->AddChainItem("Аксессуары для ".$for['NAME'], $APPLICATION->GetCurUri());
					$rs = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $for['ID'], "sort", "asc", array('CODE'=>"accessories"));
					while ($ar = $rs->GetNext()) {
						if ($ar['VALUE']) {
							$ADDITIONAL_FILTER['ID'][] = $ar['VALUE'];
						} else {
							$ADDITIONAL_FILTER['<ID'] = 1;
							break;
						}
					}
                    $sectionsList = $APPLICATION->IncludeComponent(
                        "bexx:catalog.section.list",
                        "search",
                        Array(
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "SECTION_ID" => "",
                            "ADDITIONAL_FILTER" => "",
                            "ADDITIONAL_FILTER_ELEMENTS" => $ADDITIONAL_FILTER,
                            "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                            "USE_ONLY_CHILDS" => "N",
                            "COUNT_PRICES" => "N",
                            "COUNT_SECTION_ITEMS" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "86400",
                            "SORT_FIELD_1" => "left_margin",
                            "SORT_DIR_1" => "ASC",
                        ),
                        $component
                    );
                    
                    if ($_GET['section']) { // Применение текущего раздела для выборки товаров
                        if (isset($sectionsList['SECTIONS'][intval($_GET['section'])])) {
                            $current_section = $sectionsList['SECTIONS'][intval($_GET['section'])];
                            $APPLICATION->AddChainItem($current_section['NAME']);
                        }
                        $ADDITIONAL_FILTER['SECTION_ID'] = intval($_GET['section']);
                        $ADDITIONAL_FILTER['INCLUDE_SUBSECTIONS'] = "Y";
                    }
                    
                    $listItems = $APPLICATION->IncludeComponent("bexx:catalog.items", $arResult['SECTION_TEMPLATE'], array(
                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "ADDITIONAL_FILTER" => $ADDITIONAL_FILTER,
                        "SECTION_ID" => false,
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                        "SHOW_OLD_PRICE" => "N",
                        "DESCRIPTION_FROM_PROPS" => $arParams['DESCRIPTION_FROM_PROPS'],
                        "USE_EXTERNAL_FILTERING" => "Y",
                        "SHOW_NAVIGATION" => "Y",
                        "ITEMS_PER_PAGE" => $arParams['ITEMS_PER_PAGE'],
                        "ALWAYS_EXISTING_FIRST" => $arParams['ALWAYS_EXISTING_FIRST'],
                        "PAGING_VARIANTS" => "", // параметр от шаблона
                        "SORT_FIELD_1" => $arParams['SORT_FIELD_1'],
                        "SORT_DIR_1" => $arParams['SORT_DIR_1'],
                        "SORT_FIELD_2" => $arParams['SORT_FIELD_2'],
                        "SORT_DIR_2" => $arParams['SORT_DIR_2'],
                        "SORT_FIELD_3" => $arParams['SORT_FIELD_3'],
                        "SORT_DIR_3" => $arParams['SORT_DIR_3'],
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                        "SET_TITLE" => "N",
                        "CATALOG_RESULT"=>$arResult,
                        ),
                        $component
                    );
				}
			}
		}
		?>
		<br class="clear"/>
	</div>
	<div class="corners-white bottom_right"></div>
	<div class="corners-white bottom_left"></div>
	<div class="bottom_line"></div>
</div>

<div id="extra">
	<?$APPLICATION->IncludeComponent(
		"bexx:cart",
		"block",
		Array(
			"SHOW_DETAILS" => "Y",
			"HIDE_COUPON" => "Y",
			"WISHLIST" => "N",
			"DELIVRY_ALLOW" => "N",
			"PATH_TO_CART" => "/personal/cart/",
			"PATH_TO_ORDER" => "/personal/order/",
			"NOT_DELIVERY_SAME_CITY" => Array("cpcr"),
			"SET_TITLE" => "N"
		)
	);?>
	<?$APPLICATION->IncludeComponent(
		"bexx:catalog.filter",
		"",
		Array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"SECTION_ID" => $arResult['SECTION']['ID'],
			"ADDITIONAL_FILTER" => $ADDITIONAL_FILTER,
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"SET_TITLE" => "N",
			"CATALOG_PATH" => $arParams['SEF_FOLDER'],
			"arResult" => $arResult
		),
	false
	);?>
	<?$newItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "detail_small_block", array(
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"ADDITIONAL_FILTER" => "",
		"SECTION_ID" => $arResult['SECTION']['ID'],
		"INCLUDE_SUBSECTIONS" => "Y",
		"SORT_FIELD_1" => "id",
		"SORT_DIR_1" => "DESC",
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"SET_TITLE" => "N",
		"CATALOG_PATH" => $arParams['CATALOG_PATH'],
		"SHOW_OLD_PRICE" => "N",
		"DESCRIPTION_FROM_PROPS" => "N",
		"SHOW_NAVIGATION" => "N",
		"ITEMS_PER_PAGE" => "5",
		"IGNORE_ITEMS_PER_PAGE" => "Y",
		"BLOCK_TITLE" => "Новинки",
		"ALWAYS_EXISTING_FIRST" => "Y",
		),
		$component
	);?>
	<?if ($newItemsResult):?>
	<div class="float-right text-small" style="margin-bottom: 10px; padding-right: 10px;"><a class="arr-2-right-orange" href="/new/">все новинки</a></div>
	<br class="clear" />
	<?endif;?>
	<?$hitItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "detail_small_block", array(
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"ADDITIONAL_FILTER" => "",
		"SECTION_ID" => $arResult['SECTION']['ID'],
		"INCLUDE_SUBSECTIONS" => "Y",
		"SORT_FIELD_1" => "shows",
		"SORT_DIR_1" => "DESC",
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"SET_TITLE" => "N",
		"CATALOG_PATH" => $arParams['CATALOG_PATH'],
		"PRICE_TYPE_ID" => $arParams['PRICE_TYPE_ID'],
		"SHOW_OLD_PRICE" => "N",
		"DESCRIPTION_FROM_PROPS" => "N",
		"SHOW_NAVIGATION" => "N",
		"ITEMS_PER_PAGE" => "5",
		"IGNORE_ITEMS_PER_PAGE" => "Y",
		"BLOCK_TITLE" => "Хиты продаж",
		"ALWAYS_EXISTING_FIRST" => "Y",
		),
		$component
	);?>
	<?if ($hitItemsResult):?>
	<div class="float-right text-small" style="margin-bottom: 10px; padding-right: 10px;"><a class="arr-2-right-orange" href="/catalog/hit/">все популярные</a></div>
	<br class="clear" />
	<?endif;?>
</div>
<!-- extra -->
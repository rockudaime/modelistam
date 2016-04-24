<div class="compare-container">
	<?
	if ((!empty($_SESSION['compare']) AND is_array($_SESSION['compare'])) OR (!empty($_GET['compare']) AND is_array($_GET['compare']))) {
		if (is_array($_SESSION['compare'])) $ids = array_keys($_SESSION['compare']);
		if (is_array($_GET['compare'])) {
			$ids = $_GET['compare'];
			$_SESSION['compare'] = array_combine($_GET['compare'], array_fill(0, count($_GET['compare']), 1));
		}
		/**
		 * Если для сравнения заданы товары разных типов, будет произведена выборка товаров только одного типа
		 * Если сравнение происходит в разделе и на нем установлен дефолтный тип и товары этого типа есть в списке - используем его
		 * Иначе находим первые 2 и более попавшиеся товары одного типа
		 * Всё это можно не кэшировать, ибо всё равно для каждого пользователя свой набор товаров
		 */
		
		$APPLICATION->IncludeComponent("bexx:catalog.items", "compare_page_1", array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ADDITIONAL_FILTER" => array(
				'ID' => $ids,
			),
			"SECTION_ID" => $arResult['SECTION']['ID'],
			"INCLUDE_SUBSECTIONS" => "Y",
			"CATALOG_PATH" => $arParams['SEF_FOLDER'],
			"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
			"CHECK_ACTIVE" => $arParams['CHECK_ACTIVE'],
			"FILTER_PROPS" => "N",
			"SHOW_OLD_PRICE" => "N",
			"DESCRIPTION_FROM_PROPS" => "A",
			"SHOW_NAVIGATION" => "Y",
			"ITEMS_PER_PAGE" => "3",
			"SORT_FIELD_1" => "",
			"SORT_DIR_1" => "",
			"CACHE_TYPE" => "N", // $arParams['CACHE_TYPE']
			"CACHE_TIME" => 0, // $arParams['CACHE_TIME']
			"SET_TITLE" => $arParams['SET_TITLE'],
			),
			$component
		);	
	} else {
		echo ShowError("Нет товаров для сравнения");
	}
	if (strlen($arResult['SECTION']['NAME'])) {
		$APPLICATION->SetTitle($arResult['SECTION']['NAME']." - сравнение");
	} else {
		$APPLICATION->SetTitle("Сравнение товаров");
	}
	?>
</div>

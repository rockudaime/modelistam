<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<? $APPLICATION->SetPageProperty("search_page", "Y"); ?>
<?
$r = strtolower(trim($_REQUEST['q']));

if (substr($r, 0, 2)=="ww" AND is_numeric(substr($r, 2)) AND substr($r, 2)>0) { // возможно задан ID товара
	CModule::IncludeModule("bexx.shop");
	CModule::IncludeModule("iblock");
	$rs = CIBlockElement::GetByID(intval(substr($r, 2)));
	if ($rs->SelectedRowsCount()==1) {
		$element = $rs->GetNext();
		if ($element['IBLOCK_TYPE_ID'] == "catalog") {
			$links = CBexxShop::GetElementUrl(array($element), $element['LIST_PAGE_URL']);
			if (strlen($links[0]['DETAIL_PAGE_URL'])) {
				LocalRedirect($links[0]['DETAIL_PAGE_URL']);
			}
		}
	}
}

//CModule::IncludeModule("bexx.shop");
if (is_array($arResult['SEARCH'])) {
    if (count($arResult['SEARCH'])==1) {
        if ($arResult['SEARCH'][0]['URL']) {
            LocalRedirect($arResult['SEARCH'][0]['URL']);
        }
    }
}

if ($arResult['REQUEST']['QUERY']) {
    $APPLICATION->SetTitle("Поиск ".$arResult['REQUEST']['QUERY']);
}
$founded_id = array();
$iblock_type = "";
$iblock_id = "";

if (is_array($arResult['SEARCH'])) {
    foreach ($arResult['SEARCH'] as $founded_item) {
        if (is_numeric($founded_item['ITEM_ID'])) {
            $founded_id[$founded_item['ITEM_ID']] = $founded_item['ITEM_ID'];
        }
        //GT-382 добавлено условие, т.к. если последний элемент массива результата поиска, не принадлежит инфоблоку, то записывались пустые значения и не отображались цены
        if ($founded_item['PARAM1']!==""){
            $iblock_type = $founded_item['PARAM1'];
            $iblock_id = $founded_item['PARAM2'];
        }
    }
}
?>

<?
if(isset($_REQUEST["view"])){
    $view = htmlspecialcharsbx($_REQUEST["view"]);
    $APPLICATION->set_cookie("view", $view);
}
else {
    $view = $APPLICATION->get_cookie("view")?$APPLICATION->get_cookie("view"):"block";
}

$anotherView = ($view == 'block')?"list":"block";
if ($anotherView == 'block') {
    $linkViewText = 'плиткой';
} else {
    $linkViewText = 'списком';
}
?>

<?if ($founded_id):?>
<div class="search-page">
    <div class="search-page__left">
        <?if ($arResult['SEARCH']):?>
            <div>По вашему запросу <strong><?=$arResult['REQUEST']['QUERY']?></strong> найдено <strong><?=count($arResult['SEARCH'])?></strong> <?=padej(count($arResult['SEARCH']), "товар", "товара", "товаров", false)?></div>
            <br />
        <?endif;?>
        <div class="search-side">
            <?
            $sectionsList = $APPLICATION->IncludeComponent(
                "bexx:catalog.section.list",
                "search",
                Array(
                    "IBLOCK_TYPE" => $iblock_type,
                    "IBLOCK_ID" => $iblock_id,
                    "SECTION_ID" => "",
                    "ADDITIONAL_FILTER" => "",
                    "ADDITIONAL_FILTER_ELEMENTS" => array(
                        'ID' => $founded_id
                    ),
                    "USE_ONLY_CHILDS" => "N",
                    "COUNT_PRICES" => "N",
                    "COUNT_SECTION_ITEMS" => "N",
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                    "SORT_FIELD_1" => "left_margin",
                    "SORT_DIR_1" => "ASC",
                )
            ); ?>
        </div>
    </div>

    <div class="search-page__right">
        <?
        $arUriKillParams = array( // Эти параметры удаляются из адреса страницы в постраничной навигации
            "page", // номер страницы
            "p", // количество элементов на страницу
            "s", // поле для сортировки
            "d", // направление сортировки
            "sort", // сортировка (устаревшее)
            "s_prop", // поле для сортировки по характеристикам
            "s_prop_dir", // направление для сортировки по характеристикам
            "reset_sorting", // сброс сортировки
            "view" // отображение списка товаров (block или list)
        );
        ?>
        <div class="search-content">
            <?
            $APPLICATION->IncludeComponent("bexx:catalog.items", "main_catalog_1", array(
                    "IBLOCK_TYPE" => $iblock_type,
                    "IBLOCK_ID" => $iblock_id,
                    "ADDITIONAL_FILTER" => array(
                        'ID' => $founded_id
                    ),
                    "CURRENT_VIEW" => $view,
                    "SECTION_ID" => intval($_GET['section']),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CATALOG_PATH" => "",//$arParams['SEF_FOLDER'],
                    "ALWAYS_EXISTING_FIRST" => "Y",
                    "SHOW_OLD_PRICE" => "N",
                    "DESCRIPTION_FROM_PROPS" => "Y",
                    "USE_EXTERNAL_FILTERING" => "N",
                    "SHOW_NAVIGATION" => "Y",
                    "ALLOW_BUY_NOT_EXISTING"=> "Y",
					//VTL-22
					"COUNT" => 20,
					//VTL-22
					"ITEMS_PER_PAGE" => 10,
                    "IGNORE_ITEMS_PER_PAGE" => "Y",
                    "PAGING_VARIANTS" => "",
                    //VTL-22
                    "SORT_FIELD_1" => "catalog_quantity",
                    "SORT_DIR_1" => "desc,nulls",
                    "SORT_FIELD_2" => "price",
                    "SORT_DIR_2" => "asc",

                    /*"SORT_FIELD_1" => "ID",
                    "SORT_DIR_1" => "DESC",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "DESC",*/
                    //VTL-22
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                    "SET_TITLE" => "N",
                    "SHOW_SORTING_PANEL" => "N",
                    "SHOW_COMPARE_LINK" => "N",
                ),
                false
            );?>
        </div>
    </div>
</div>
<?else:?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?endif;?>
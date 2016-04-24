<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
//$APPLICATION->SetPageProperty("not_show_page_title", "Y");
$APPLICATION->SetPageProperty("not_show_nav_chain", "N");
?>

<!--div class="block">
	<div class="header_line">
		<h2>Все группы товаров</h2>
	</div>
</div-->


<div style="padding: 20px;">
<?$APPLICATION->IncludeComponent(
	"bexx:catalog.section.list",
	"catalog",
	Array(
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"SECTION_ID" => "",
		"ADDITIONAL_FILTER" => "",
		"ADDITIONAL_FILTER_ELEMENTS" => array(),
		"USE_ONLY_CHILDS" => "N",
		"COUNT_PRICES" => "N",
		"COUNT_SECTION_ITEMS" => "Y",
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"SORT_FIELD_1" => "left_margin",
		"SORT_DIR_1" => "ASC",
	)
);?>

<div style="width: 880px">
	<?$APPLICATION->IncludeComponent("bexx:catalog.items", "scroll_template_1", array(
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"ADDITIONAL_FILTER" => "",
		"SECTION_ID" => "0",
		"INCLUDE_SUBSECTIONS" => "Y",
		"ALLOW_BUY_NOT_EXISTING" => "Y",
		"CHECK_PERMISSIONS" => "N",
		"CHECK_ACTIVE" => "Y",
		"SORT_FIELD_1" => "active_from",
		"SORT_DIR_1" => "asc",
		"SORT_FIELD_2" => "id",
		"SORT_DIR_2" => "desc",
		"SORT_FIELD_3" => "",
		"SORT_DIR_3" => "asc",
		"SORTING_PANEL_OPTIONS" => array(),
		"ALWAYS_EXISTING_FIRST" => "N",
		"USE_EXTERNAL_FILTERING" => "N",
        "CACHE_TIME" => $arParams['CACHE_TIME'],
         //PST-9
		//"CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "CACHE_TYPE" => "N",
        //PST-9
		"SET_TITLE" => "N",
		"CATALOG_PATH" => $arParams['CATALOG_PATH'],
		"DESCRIPTION_FROM_PROPS" => "N",
		"ITEMS_PER_PAGE" => "12",
		"IGNORE_ITEMS_PER_PAGE" => "Y",
		"CODE" => "new",
		"SCROLL_SKIP" => "4",
		"BLOCK_TITLE" => "Новинки",
		"BLOCK_URL" => "/catalog/new/",
		"BLOCK_URL_TITLE" => "все новинки",
		"BLOCK_IMAGE_SRC" => "/bitrix/templates/main/images/pic-new.png"
		),
		false
	);?>
</div>

</div>
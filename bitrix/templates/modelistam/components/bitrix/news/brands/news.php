<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?
$APPLICATION->SetPageProperty("not_show_breadcrumb", "Y");
?>

<?$listResult = $APPLICATION->IncludeComponent("bexx:iblock.items", "brands_list", array(   
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"SECTION_ID" => $arParams['IBLOCK_SECTION_ID'],
    "ACTIVE" => "Y",
    "ACTIVE_DATE" => "Y",
	"ADDITIONAL_FILTER" => "",
    "GET_LINKED_ELEMENTS" => "N",
    "GET_LINKED_SECTIONS" => "N",
	"SORT_FIELD_1" => $arParams["SORT_BY1"],
	"SORT_DIR_1" => $arParams["SORT_ORDER1"],
    "SORT_FIELD_2" => $arParams["SORT_BY2"],
    "SORT_DIR_2" => $arParams["SORT_ORDER2"],
    "USER_SORTING" => "N",
    "ALLOW_PAGENAV" => "Y",
    "ALLOW_USER_PAGENAV" => "N",
    "CHECK_PERMISSIONS" => "N",
    "EXTERNAL_FILTERING" => "N",
	"COUNT" => $arParams["NEWS_COUNT"],
	"SHOW_DATETIME" => "datetime",
	"SHOW_SECTION_NAME" => "N",
	"SHOW_PAGENAV" => "Y",
	"SHOW_PREVIEW_PICTURE" => "Y",
	"PAGER_DESC_NUMBERING" => $arParams["PAGER_TITLE"],
	"SHOW_PROPERTIES" => array(),
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"SET_TITLE" => $arParams["SET_TITLE"]
	),
	$component
);?>

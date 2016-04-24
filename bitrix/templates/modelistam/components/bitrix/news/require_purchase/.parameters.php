<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arIBlockType = array("" => GetMessage("IBLOCK_ALL_TYPES"));
$rsIBlockType = CIBlockType::GetList(array("sort"=>"asc"), array("ACTIVE"=>"Y"));
while ($arr=$rsIBlockType->Fetch()) {
    if($ar=CIBlockType::GetByIDLang($arr["ID"], LANGUAGE_ID)) {
        $arIBlockType[$arr["ID"]] = "[".$arr["ID"]."] ".$ar["NAME"];
    }
}

$arIBlock=array("" => GetMessage("IBLOCK_SELECT_ONE"));
$IBlockFilter = array("ACTIVE"=>"Y");
if ($arCurrentValues["IBLOCK_TYPE"]) $IBlockFilter["TYPE"] = $arCurrentValues["CATALOG_IBLOCK_TYPE"];
$rsIBlock = CIBlock::GetList(array("SORT"=>"ASC"), $IBlockFilter);
while($arr=$rsIBlock->Fetch()) $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];


$arTemplateParameters = array();
$arTemplateParameters["CATALOG_IBLOCK_TYPE"] = Array(
	"NAME" => GetMessage("SELECT_IBLOCK_TYPE"),
	"TYPE" => "LIST",
    "MULTIPLE" => "N",
	"REFRESH" => "Y",
	"VALUES" => $arIBlockType
);
$arTemplateParameters["CATALOG_IBLOCK_ID"] = Array(
    "NAME" => GetMessage("SELECT_IBLOCK_ID"),
    "TYPE" => "LIST",
    "MULTIPLE" => "N",
    "VALUES" => $arIBlock
);
?>

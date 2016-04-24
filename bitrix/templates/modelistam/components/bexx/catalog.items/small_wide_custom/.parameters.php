<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();

$arTemplateParameters["COLUMNS_COUNT"] = Array(
	"NAME" => "Количество колонок",
	"TYPE" => "STRING",
	"DEFAULT" => "3",
);
$arTemplateParameters["BLOCK_WIDTH"] = Array(
	"NAME" => "Ширина одной ячейки в пикселях",
	"TYPE" => "STRING",
	"DEFAULT" => "175",
);
$arTemplateParameters["SHOW_BORDER"] = Array(
    "NAME" => "Показывать рамку",
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
);



?>

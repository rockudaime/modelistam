<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();

$arTemplateParameters["BLOCK_TITLE"] = Array(
	"NAME" => "Название блока",
	"TYPE" => "STRING",
	"DEFAULT" => "Хиты продаж",
);
$arTemplateParameters["BLOCK_URL"] = Array(
	"NAME" => "Ссылка внизу блока",
	"TYPE" => "STRING",
	"DEFAULT" => "/catalog/hit/",
);
$arTemplateParameters["BLOCK_URL_TITLE"] = Array(
	"NAME" => "Название ссылки внизу блока",
	"TYPE" => "STRING",
	"DEFAULT" => "все хиты продаж",
);

?>

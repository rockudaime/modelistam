<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();

$arTemplateParameters["CODE"] = Array(
	"NAME" => "Уникальный код блока",
	"TYPE" => "STRING",
	"DEFAULT" => "hit",
);
$arTemplateParameters["SCROLL_SKIP"] = Array(
	"NAME" => "Элементов прокручивать за раз",
	"TYPE" => "STRING",
	"DEFAULT" => "4",
);
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
$arTemplateParameters["BLOCK_IMAGE_SRC"] = Array(
	"NAME" => "Путь до картинки наложения",
	"TYPE" => "STRING",
	"DEFAULT" => "/bitrix/templates/main/images/pic-hit.png",
);
?>

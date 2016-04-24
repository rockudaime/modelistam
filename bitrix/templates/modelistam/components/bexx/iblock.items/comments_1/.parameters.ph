<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();
$arTemplateParameters["ONLY_AUTHORIZED"] = Array(
	"NAME" => "Только для авторизованных",
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
);
$arTemplateParameters["ELEMENT_ID"] = Array(
    "NAME" => "Связанный элемент",
    "TYPE" => "STRING",
    "DEFAULT" => "",
);


?>

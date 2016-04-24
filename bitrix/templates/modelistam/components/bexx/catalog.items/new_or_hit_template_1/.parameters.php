<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();

$arTemplateParameters["PER_PAGE_VARIANTS"] = Array(
	"NAME" => "Варианты элементов на страницу",
	"TYPE" => "STRING",
	"MULTIPLE" => "Y",
	"DEFAULT" => array(10, 15, 20, 30, 50, 100, 200),
);
?>

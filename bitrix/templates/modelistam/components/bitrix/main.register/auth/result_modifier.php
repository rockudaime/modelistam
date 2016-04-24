<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>

<?
    COption::SetOptionString("main","captcha_registration","N");
    list($arResult["SHOW_FIELDS"][0], $arResult["SHOW_FIELDS"][4]) = array($arResult["SHOW_FIELDS"][4], $arResult["SHOW_FIELDS"][0]);
    list($arResult["SHOW_FIELDS"][3], $arResult["SHOW_FIELDS"][1]) = array($arResult["SHOW_FIELDS"][1], $arResult["SHOW_FIELDS"][3]);
    list($arResult["SHOW_FIELDS"][5], $arResult["SHOW_FIELDS"][2]) = array($arResult["SHOW_FIELDS"][2], $arResult["SHOW_FIELDS"][5]);
?>

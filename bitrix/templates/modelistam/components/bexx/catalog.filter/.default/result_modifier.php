<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
// BSP-24
foreach ($arResult['PROPERTIES'] as $k=>$prop) {
    $pos = strpos($prop['CODE'], 'HasDiap');
    if ($pos !== false) unset($arResult['PROPERTIES'][$k]);
}
// BSP-24
?>

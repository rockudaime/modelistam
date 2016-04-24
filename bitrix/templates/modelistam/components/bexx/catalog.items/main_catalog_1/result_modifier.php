<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
// BSP-24
foreach ($arResult['MAIN_PROPS'] as $k=>$props) {
    foreach ($props as $m=>$prop) {
        $pos = strpos($prop['CODE'], 'Diapazon');
        if ($pos !== false) unset($arResult['MAIN_PROPS'][$k][$m]);
    }
}
// BSP-24

//MM-227
foreach ($arResult['ITEMS'] as $k=>$item){
    if (strlen($item['PROPERTY_VALUES']['SALE']['VALUE']) || strlen($item['PROPERTY_VALUES']['SPECIALOFFER']['VALUE'])){
        if ($item['DISCOUNT_PRICE'] < $item["PROPERTY_VALUES"]["PREVPRICEROZN"]["VALUE"]) $arResult['ITEMS'][$k]["PRICE"] = $item["PROPERTY_VALUES"]["PREVPRICEROZN"]["VALUE"];
    }
}
//MM-227
?>

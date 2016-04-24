<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?

//MM-226
$rsEl = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>'25', "ID" => $arResult['PROPERTIES']['Brand']['VALUE']), false, false);
while ($arItemBrand = $rsEl->GetNext()) {
    $arResult['BRAND'] = $arItemBrand;
}
//MM-226

//BSP-32
foreach ($arResult['ITEM_PROPS'] as $prop_id=>$prop) {
    if (($prop['ACTIVE'] == "Y")&&($prop['FILTRABLE'] == "Y")) {
        $code = $prop['CODE']?$prop['CODE']:$prop['ID'];
        // BSP-24
        $pos = strpos($code, 'Diapazon');
        if ($pos !== false) continue;
        // BSP-24

        if ($prop['PROPERTY_TYPE'] == "L") {
            $rsMainPropEnum = CIBlockPropertyEnum::GetList(array("SORT"=>"ASC"), array('PROPERTY_ID'=>$prop['ID']));
            while ($arMainPropEnum = $rsMainPropEnum->GetNext()) {
                $prop['ENUM_VALUES'][$arMainPropEnum['ID']] = $arMainPropEnum['VALUE'];
            }
        }
        $arResult['MAIN_PROPS'][$code] = $prop;
    }
}
//BSP-32

//BSP-91
$rsEl = CIBlockElement::GetList(array(), array("IBLOCK_CODE" => 'ucenka', "PROPERTY_MAIN_UCENKA_TOVAR" => $arResult['ID']), false, false);
while ($arItemUcenka = $rsEl->GetNext()) {
    $arItemUcenka['DETAIL_PAGE_URL'] = CBexxShop::GetElementUrl($arItemUcenka);
    $arResult['UCENKA_ELEMENTS'][$arItemUcenka['ID']] = $arItemUcenka;
}
//BSP-91

//BSP-98
if ($arResult['IBLOCK_CODE']=='ucenka'){
    $rsEl = CIBlockElement::GetList(array(), array("IBLOCK_CODE" => 'ucenka', "ID" => $arResult['ID']), false);
    while($obEl = $rsEl->GetNextElement()){
        $arItem['PROPERTIES'] = $obEl->GetProperties();
        if (is_array($arItem['PROPERTIES'])) {
			if($arItem['PROPERTIES']['MAIN_UCENKA_TOVAR']['VALUE']!==""){
				$rs = CIBlockElement::GetList(array(), array("IBLOCK_CODE" => 'catalog', "ID" => $arItem['PROPERTIES']['MAIN_UCENKA_TOVAR']['VALUE']), false);

				while ($arCatalogItem = $rs->GetNext()) {
					$arCatalogItem['DETAIL_PAGE_URL'] = CBexxShop::GetElementUrl($arCatalogItem);
					$arResult['NO_UCENKA_ELEMENTS'][$arCatalogItem['ID']] = $arCatalogItem;
				}
            }
        }
    }
}
//BSP-98

//MM-227
if (($arResult["PROPERTIES"]["SALE"]["VALUE_XML_ID"] == "YES") || ($arResult["PROPERTIES"]["SPECIALOFFER"]["VALUE_XML_ID"] == "YES")){
    if ($arResult['DISCOUNT_PRICE'] < $arResult["PROPERTIES"]["PREVPRICEROZN"]["VALUE"]) $arResult["PREVPRICE"] = $arResult["PROPERTIES"]["PREVPRICEROZN"]["VALUE"];
}
//MM-227

?>

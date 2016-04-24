<?php

$disallowedPropKeys = array("prop", "page", "p", "s", "sort", "s_prop", "s_prop_dir", "prop", "price", "back_url"); // список запрещенных кодов свойств
$arResult['SHOW_RESULT'] = 0;
$all_parts = array();

// Базовый фильтр
$arMainFilter = array(
    'IBLOCK_ID'=>$arParams['IBLOCK_ID'], 
    'ACTIVE'=>"Y", 
    'INCLUDE_SUBSECTIONS'=>"Y"
);

// Обработка основных характеристик в фильтре, создание фильтра по основному каталогу, формирование URL для фильтрации
$all_parts = array();
$reciviedKeys = array();
if (is_array($arParams['FILTER_PROPS'])) $reciviedKeys = array_intersect($arParams['FILTER_PROPS'], array_keys($_REQUEST));
foreach ($reciviedKeys as $key) {
    if (!in_array($key, $disallowedPropKeys)) {
        if (is_array($_REQUEST[$key]) AND count($_REQUEST[$key])==1 AND !empty($_REQUEST[$key][0])) {
            $all_parts[] = $key."=".reset($_REQUEST[$key]);
            $arMainFilter['PROPERTY_'.$key] = reset($_REQUEST[$key]);
        } elseif ((isset($_REQUEST[$key]['min']) OR isset($_REQUEST[$key]['max'])) AND is_array($_REQUEST[$key])) {
            if (is_numeric($_REQUEST[$key]['min'])) {
                $all_parts[] = $key."[min]=".$_REQUEST[$key]['min'];
                $arMainFilter['>=PROPERTY_'.$key] = $_REQUEST[$key]['min'];
            }
            if (is_numeric($_REQUEST[$key]['max'])) {
                $all_parts[] = $key."[max]=".$_REQUEST[$key]['max'];
                $arMainFilter['<=PROPERTY_'.$key] = $_REQUEST[$key]['max'];
            }
        } else {
            foreach ($_REQUEST[$key] as $val) if ($val) $all_parts[] = $key."[]=".$val;
            $arMainFilter['PROPERTY_'.$key] = $_REQUEST[$key];
        }
    }
}

// Обработка диапазона цены
$price_limits = array();
if ($_REQUEST['price']['min']>0) {
    $price_limits['min'] = floatval($_REQUEST['price']['min']);
    $all_parts[] = "price[min]=".$price_limits['min'];
}
if ($_REQUEST['price']['max']>0) {
    $price_limits['max'] = floatval($_REQUEST['price']['max']);
    $all_parts[] = "price[max]=".$price_limits['max'];
}

// Аксессуары
if ($_REQUEST['accessories_for']) {
    $all_parts[] = "accessories_for=".intval($_REQUEST['accessories_for']);
    $rs = CIBlockElement::GetByID(intval($_REQUEST['accessories_for']));
    $parent_element = $rs->GetNext();
    $accessories = array();
    $rs = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $parent_element['ID'], "sort", "asc", array('CODE'=>"_accessories"));
    while ($ar = $rs->GetNext()) {
        $accessories[] = $ar['VALUE'];
    }
}
$descriptions_itype = $arResult['IBLOCK']['PROPERTIES'][$arResult['TYPE_PROP']]['USER_TYPE_SETTINGS']['DESCRIPTIONS'];

// Обработка свойств товаров
$prop_parts = array();
$check_descriptions = false;
$selected_props = array();
if (is_array($_REQUEST['prop']) AND !empty($_REQUEST['prop'])) {
    $arFilter = array(
        'IBLOCK_TYPE' => $descriptions_itype,
        'IBLOCK_ID' => $arResult['PRIMARY_TYPE'],
        'ACTIVE' => "Y"
    );
    if ($accessories) $arFilter['ID'] = $accessories;
    foreach ($_REQUEST['prop'] as $prop_id=>$prop_val) {
        if (isset($prop_val['min']) OR isset($prop_val['max'])) { // Число от и до
            $min_val = floatval(str_replace(",", ".", $prop_val['min']));
            $max_val = floatval(str_replace(",", ".", $prop_val['max']));
            if ($max_val>0 AND $min_val>0 AND $min_val==$max_val) {
                $arFilter['=PROPERTY_'.$prop_id] = $max_val;
                $all_parts[] = "prop[".$prop_id."]=".$min_val;
                $check_descriptions = true;
            } else {
                if ($min_val>0) {
                    $arFilter['>=PROPERTY_'.$prop_id] = $min_val;
                    $all_parts[] = "prop[".$prop_id."][min]=".$min_val;
                    $check_descriptions = true;
                }

                if ($max_val>0 AND $max_val>$min_val) {
                    $arFilter['<=PROPERTY_'.$prop_id] = $max_val;
                    $all_parts[] = "prop[".$prop_id."][max]=".$max_val;
                    $check_descriptions = true;
                }
            }
        } else { // Списки
            if (is_array($prop_val)) {
                foreach ($prop_val as $prop_enum_id) {
                    if (!is_array($arFilter['PROPERTY_'.$prop_id])) $arFilter['PROPERTY_'.$prop_id] = array();
                    $arFilter['PROPERTY_'.$prop_id][] = $prop_enum_id;
                    $all_parts[] = "prop[".$prop_id."][]=".$prop_enum_id;
                    $selected_props[$prop_id][] = $prop_enum_id;
                    $check_descriptions = true;
                }
            }
        }
    }
    if ($check_descriptions) {
        $allowed_ids = array();
        $rs = CIBlockElement::GetList(array(), $arFilter, false, false, array('CODE'));
        while ($ar = $rs->GetNext()) {
            $allowed_ids[] = $ar['CODE'];
        }
        if (empty($allowed_ids)) $allowed_ids = array(0); // ничего не найдено
    }
}

// Формирование фильтра для выборки
//BSP-126 закоментил, чтоб popup выскакивал всегда
//if ($check_descriptions OR $price_limits OR $all_parts) {
//BSP-126
    $arResult['SHOW_RESULT'] = 1; // Показываем результаты поиска вне зависимости от найденного количества, т.е. задан фильтр
    // Фильтр по аксессуарам для указанного товара
    if ($accessories) $arMainFilter['ID'] = $accessories;
    // Фильтр по ценам
    if ($price_limits) {
        CModule::IncludeModule("catalog");
        CModule::IncludeModule("currency");
        $rsCatalogGroups = CCatalogGroup::GetList(array(), array('CAN_ACCESS'=>"Y"));
        $rsCurrencies = $rsCurrencies = CCurrency::GetList($by="", $order="");
        $arCurrencies = array();
        $source_currency_code = COption::GetOptionString("sale", "default_currency", "UAH"); // Дефолтная валюта каталога
        while ($arCurrency = $rsCurrencies->GetNext()) {
            $arCurrencies[] = $arCurrency['CURRENCY'];
            if ($_GET['price']['cur']==$arCurrency['CURRENCY'] AND isset($_GET['price']['cur'])) {
                $source_currency_code = $arCurrency['CURRENCY'];
            }
        }
        $allCatalogGroupsIDs = array();
        while ($arCatalogGroup = $rsCatalogGroups->GetNext()) {
            $allCatalogGroupsIDs[] = $arCatalogGroup['ID'];
        }
        // Применение к фильтру - нижняя граница, все валюты, все типы цен

        //TM-18
        if ((isset($_REQUEST['price']['max'])) AND !isset($_REQUEST['price']['min'])) {
            $_REQUEST['price']['min'] = '0';
        }
        //TM-18

        if ($price_limits['min']>0 OR $price_limits['max']>0) {
            $price_select_condition = array('LOGIC' => "OR");
            foreach ($arCurrencies as $currency_code) {
                $currency_price_min = CCurrencyRates::ConvertCurrency($price_limits['min'], $source_currency_code, $currency_code);
                $currency_price_max = CCurrencyRates::ConvertCurrency($price_limits['max'], $source_currency_code, $currency_code);
                foreach ($allCatalogGroupsIDs as $price_type_id) {
                    //TM-18
                    if ($_REQUEST['price']['min'] == '0'){
                        $price_select_condition[] = array(
                            '>CATALOG_PRICE_'.$price_type_id => $currency_price_min,
                            '<=CATALOG_PRICE_'.$price_type_id => $currency_price_max?$currency_price_max:NULL,
                            'CATALOG_CURRENCY_'.$price_type_id => $currency_code,
                        );

                    }
                    else
                    //TM-18
                    {
                        $price_select_condition[] = array(
                            '>=CATALOG_PRICE_'.$price_type_id => $currency_price_min?$currency_price_min:NULL,
                            '<=CATALOG_PRICE_'.$price_type_id => $currency_price_max?$currency_price_max:NULL,
                            'CATALOG_CURRENCY_'.$price_type_id => $currency_code,
                        );
                    }
                }
            }
            $arMainFilter[] = $price_select_condition;
        }
    }

    // Проверка по параметрам товаров
    if ($check_descriptions AND $allowed_ids) {
        $arMainFilter['ID'] = $allowed_ids;
    }
    if ($arParams['SECTION_ID']>0) $arMainFilter['SECTION_ID'] = $arParams['SECTION_ID'];


    // Собственно выборка
    $arResult['COUNT'] = CIBlockElement::GetList(array(), $arMainFilter, array());


//}

// Сформируем ссылку на показ этих товаров
if ($_REQUEST['back_url']) $arResult['LINK'] = $_REQUEST['back_url'];
$filter_link_id = md5($arResult['LINK']);
if (!strpos($arResult['LINK'], "?")) $arResult['LINK'] .= "?";
elseif (substr($arResult['LINK'], -1, 1)!="&") $arResult['LINK'] .= "&";
$arResult['LINK'] .= implode("&", $all_parts);

$this->IncludeComponentTemplate('ajax_filter');

exit();
?>
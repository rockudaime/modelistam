<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
    global $DB;

    $idsToExclude = $_POST['ids'];
    $countItems = intval($_REQUEST['count']);
    $arResult['ITEMS'] = array();

    $arSorting = array();

    // Обработка сортировки - дефолтные параметры компонента
    foreach ($arParams as $k=>$param) {
        if (strpos($k, "SORT_FIELD_", 0) === 0) {
            $i = str_replace("SORT_FIELD_", "", $k);
            if (strlen($param)) {
                $arSorting[strtoupper($param)] = $arParams['SORT_DIR_'.$i];
            }
        }
    }

    // Дефолтный фильтр
    $arFilter = array(
        '!ID' => $idsToExclude,
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'INCLUDE_SUBSECTIONS' => "Y",
        'CHECK_PERMISSIONS' => $arParams['CHECK_PERMISSIONS'] // проверка прав доступа. Грузит систему, лучше отключать.
    );
    if ($arParams['ACTIVE']!="A") $arFilter['ACTIVE'] = $arParams['ACTIVE']=="Y"?"Y":"N";
    if ($arParams['ACTIVE_DATE']!="A") {
        if ($arParams['ACTIVE_DATE']=="N") $arFilter['!ACTIVE_DATE'] = "Y";
        else $arFilter['ACTIVE_DATE'] = "Y";
    }

    if ($arParams['SECTION_ID'] > 0) $arFilter['SECTION_ID'] = $arParams['SECTION_ID']; // в параметрах указана выборка из раздела

    // получим элементы
    $arSelect = array('*');
    if (is_array($arResult['PRICE_TYPES'])) {
        foreach ($arResult['PRICE_TYPES'] as $price_type) {
            $arSelect[] = "CATALOG_GROUP_".$price_type['ID'];
            $arFilter['CATALOG_SHOP_QUANTITY_'.$price_type['ID']] = 1; // выбрать цены для количества = 1
        }
    }

    $arNavParams['nPageSize'] = $countItems;

    if ($arParams['ADDITIONAL_FILTER']) {
        if (is_array($arParams['ADDITIONAL_FILTER'])) {
            $additional_filter = $arParams['ADDITIONAL_FILTER'];
        } else {
            $arParams['ADDITIONAL_FILTER'] = trim(str_replace(";", "&", $arParams['ADDITIONAL_FILTER']));
            parse_str($arParams['ADDITIONAL_FILTER'], $additional_filter);
        }
        if (is_array($additional_filter)) $arFilter = array_merge($arFilter, $additional_filter);
    }
    $rsElements = CIBlockElement::GetList($arSorting, $arFilter, false, $arNavParams, $arSelect);


    // обработка выборки
    while ($arItem = $rsElements->Fetch()) {
        //$arItem['DETAIL_PAGE_URL']
        $arItem['PRICES'] = CIBlockPriceTools::GetItemPrices($arParams['IBLOCK_ID'], $arResult['PRICE_TYPES'], $arItem);
        if (is_array($arItem['PRICES'])) {
            foreach ($arItem['PRICES'] as $price_type=>$price_ar) {
                if ($price_ar['CAN_BUY']=="Y" AND ((isset($arItem['PRICE']) AND $arItem['PRICE']>$price_ar['VALUE']) OR ($price_ar['VALUE']>0 AND !isset($arItem['PRICE'])))) {
                    $arItem['PRICE'] = $price_ar['VALUE'];
                    $arItem['CURRENCY'] = $price_ar['CURRENCY'];
                    $arItem['PRICE_TYPE'] = $price_type;
                }
                if ($price_ar['CAN_BUY']=="Y" AND ((isset($arItem['DISCOUNT_PRICE']) AND $arItem['DISCOUNT_PRICE']>$price_ar['DISCOUNT_VALUE']) OR ($price_ar['DISCOUNT_VALUE']>0 AND !isset($arItem['DISCOUNT_PRICE'])))) {
                    $arItem['DISCOUNT_PRICE'] = $price_ar['DISCOUNT_VALUE'];
                    $arItem['CURRENCY'] = $price_ar['CURRENCY'];
                    $arItem['PRICE_TYPE'] = $price_type;
                }
            }
        }
        $arResult['ITEMS'][$arItem['ID']] = $arItem;
    }

    // Получим адреса страниц
    CBexxShop::GetElementUrl($arResult['ITEMS'], $arParams['CATALOG_PATH']);

    if (count($arResult['ITEMS'])) {
        // узнаем все ID свойств основного инфоблока
        $arResult['LINKED_ELEMENTS'] = array(); // коллекционируем связанные элементы
        $arResult['LINKED_SECTIONS'] = array(); // коллекционируем связанные разделы
        $props_E = array();
        $props_G = array();
        $all_single_ids = array();
        $all_multiple_ids = array();
        $linked_descriptions = array();
        if (is_array($arResult['IBLOCK']['PROPERTIES'])) {
            foreach ($arResult['IBLOCK']['PROPERTIES'] as $code=>$prop) {
                if ($prop['MULTIPLE']=="N") $all_single_ids[$prop['ID']] = $prop['CODE']?$prop['CODE']:$prop['ID'];
                else $all_multiple_ids[$prop['ID']] = $prop['CODE']?$prop['CODE']:$prop['ID'];
                if ($prop['PROPERTY_TYPE']=="E") {
                    $props_E[] = $prop['ID']; // $prop['CODE']?$prop['CODE']:
                } elseif ($prop['PROPERTY_TYPE']=="G") {
                    $props_G[] = $prop['ID']; // $prop['CODE']?$prop['CODE']:
                }
            }
        }
        $props_E = array_unique($props_E);
        $props_G = array_unique($props_G);

        // Получим значения свойств для выбранных элементов
        if ($arResult['IBLOCK']['VERSION']==2) {
            // единичные свойства
            $rs = $DB->Query("
                    SELECT *, IBLOCK_ELEMENT_ID as EL_ID
                    FROM b_iblock_element_prop_s".$arParams['IBLOCK_ID']."
                    WHERE IBLOCK_ELEMENT_ID IN (".implode(",", array_keys($arResult['ITEMS'])).")"
            );
            while ($ar = $rs->Fetch()) {
                foreach ($all_single_ids as $prop_id=>$prop_code) {
                    if (in_array($prop_id, $props_E) AND $ar['PROPERTY_'.$prop_id]>0) {
                        $arResult['LINKED_ELEMENTS'][$ar['PROPERTY_'.$prop_id]] = 1; // собираем связанные элементы
                    }
                    if (in_array($prop_id, $props_G) AND $ar['PROPERTY_'.$prop_id]>0) {
                        $arResult['LINKED_SECTIONS'][$ar['PROPERTY_'.$prop_id]] = 1; // собираем связанные разделы
                    }
                    $arResult['ITEMS'][$ar['EL_ID']]['PROPERTY_VALUES'][$prop_code?$prop_code:$prop_id] = array(
                        'VALUE' => $ar['PROPERTY_'.$prop_id],
                        'DESCRIPTION' => $ar['DESCRIPTION_'.$prop_id]
                    );
                    if ($arResult['TYPE_PROP']==$prop_id AND $ar['DESCRIPTION_'.$prop_id]>0) {
                        $linked_descriptions[$ar['DESCRIPTION_'.$prop_id]][doubleval($ar['PROPERTY_'.$prop_id])] = $ar['EL_ID'];
                    }
                }
            }
            // множественные свойства
            $rs = $DB->Query("
                    SELECT ID, IBLOCK_ELEMENT_ID, IBLOCK_PROPERTY_ID, VALUE, VALUE_ENUM, VALUE_NUM, DESCRIPTION
                    FROM b_iblock_element_prop_m".$arParams['IBLOCK_ID']."
                    WHERE IBLOCK_ELEMENT_ID IN (".implode(",", array_keys($arResult['ITEMS'])).")"
            );
            while ($ar = $rs->Fetch()) {
                switch ($arResult['IBLOCK']['PROPERTIES'][$all_multiple_ids[$ar['IBLOCK_PROPERTY_ID']]]['PROPERTY_TYPE']) {
                    case "N": $ar['VALUE'] = doubleval($ar['VALUE_NUM']); break;
                    case "L": $ar['VALUE'] = $ar['VALUE_ENUM']; break;
                    case "E": $arResult['LINKED_ELEMENTS'][$ar['VALUE']] = 1; break;
                    case "G": $arResult['LINKED_SECTIONS'][$ar['VALUE']] = 1; break;
                }
                $arResult['ITEMS'][$ar['IBLOCK_ELEMENT_ID']]['PROPERTY_VALUES'][$all_multiple_ids[$ar['IBLOCK_PROPERTY_ID']]]['VALUE'][] = $ar['VALUE'];
                $arResult['ITEMS'][$ar['IBLOCK_ELEMENT_ID']]['PROPERTY_VALUES'][$all_multiple_ids[$ar['IBLOCK_PROPERTY_ID']]]['DESCRIPTION'][] = $ar['DESCRIPTION'];
            }
        } // закончили выборку основных свойств

        // выборка связанных разделов, если есть
        if (!empty($arResult['LINKED_ELEMENTS'])) {
            $rsLinkedElements = CIBlockElement::GetList(
                array(),
                array(
                    'ID'=>array_keys($arResult['LINKED_ELEMENTS']),
                    'ACTIVE'=>"Y"
                )
            );
            while ($arLinkedElement = $rsLinkedElements->GetNext()) {
                $arLinkedElement['DETAIL_PAGE_URL'] = CBexxShop::GetElementUrl($arLinkedElement);
                $arResult['LINKED_ELEMENTS'][$arLinkedElement['ID']] = $arLinkedElement;
            }
        }

        // если есть характеристики товаров
        if ($arResult['TYPE_PROP']>0 AND !empty($linked_descriptions) AND $arParams['DESCRIPTION_FROM_PROPS']!="N") {
            $arResult['MAIN_PROPS'] = array();
            foreach ($linked_descriptions as $iblock_id=>$links) {

                $arPropFilter = array('IBLOCK_ID'=>$iblock_id, 'ACTIVE'=>"Y");
                if ($arParams['DESCRIPTION_FROM_PROPS']=="Y") $arPropFilter['FILTRABLE'] = "Y"; // выборка только фильтруемых свойств

                // ZN-29 Oleg
                $rs = CIBlockProperty::GetList(array("SORT"=>"ASC"), $arPropFilter);
                // ZN-29 Oleg

                while ($arMainProp = $rs->Fetch()) {
                    $code = $arMainProp['CODE']?$arMainProp['CODE']:$arMainProp['ID'];
                    if ($arMainProp['PROPERTY_TYPE'] == "L") {
                        $rsMainPropEnum = CIBlockPropertyEnum::GetList(array("SORT"=>"ASC"), array('PROPERTY_ID'=>$arMainProp['ID']));
                        while ($arMainPropEnum = $rsMainPropEnum->GetNext()) {
                            $arMainProp['ENUM_VALUES'][$arMainPropEnum['ID']] = $arMainPropEnum['VALUE'];
                        }
                    }
                    $arResult['MAIN_PROPS'][$iblock_id][$code] = $arMainProp;
                }

                // Сопоставим коды свойств и ID
                $sopMainProps = array();
                $all_single_ids = array();
                foreach ($arResult['MAIN_PROPS'][$iblock_id] as $code=>$prop) {
                    if ($prop['MULTIPLE']=="N") $all_single_ids[] = $prop['ID'];
                    else $all_multiple_ids[] = $prop['ID'];
                    $sopMainProps[$prop['ID']] = $prop['CODE']?$prop['CODE']:$prop['ID'];
                }

                // Найдем значения свойств для каждого товара. Также, как и выше. Сначала единичные, затем множественные
                $rs = $DB->Query("
                        SELECT *
                        FROM b_iblock_element_prop_s".$iblock_id."
                        WHERE IBLOCK_ELEMENT_ID IN (".implode(",", array_keys($links)).")"
                );
                while ($ar = $rs->Fetch()) {
                    foreach ($all_single_ids as $id) {
                        //d($arResult['IBLOCK']['PROPERTIES'][$sopMainProps[$id]]['PROPERTY_TYPE']);
                        switch ($arResult['MAIN_PROPS'][$iblock_id][$sopMainProps[$id]]['PROPERTY_TYPE']) {
                            case "N": $ar['PROPERTY_'.$id] = doubleval($ar['PROPERTY_'.$id]); break;
                        }
                        $arResult['ITEMS'][$links[$ar['IBLOCK_ELEMENT_ID']]]['DESCRIPTION'][$sopMainProps[$id]] = array(
                            'VALUE' => $ar['PROPERTY_'.$id],
                            'DESCRIPTION' => $ar['DESCRIPTION'.$id],
                        );
                    }
                }
                $rs = $DB->Query("
                        SELECT ID, IBLOCK_ELEMENT_ID, IBLOCK_PROPERTY_ID, VALUE, VALUE_ENUM, VALUE_NUM, DESCRIPTION
                        FROM b_iblock_element_prop_m".$iblock_id."
                        WHERE IBLOCK_ELEMENT_ID IN (".implode(",", array_keys($links)).")"
                );
                while ($ar = $rs->Fetch()) {
                    switch ($arResult['IBLOCK']['PROPERTIES'][$all_multiple_ids[$ar['IBLOCK_PROPERTY_ID']]]['PROPERTY_TYPE']) {
                        case "N": $ar['VALUE'] = doubleval($ar['VALUE_NUM']); break;
                        case "L": $ar['VALUE'] = $ar['VALUE_ENUM']; break;
                    }
                    $arResult['ITEMS'][$links[$ar['IBLOCK_ELEMENT_ID']]]['DESCRIPTION'][$sopMainProps[$ar['IBLOCK_PROPERTY_ID']]]['VALUE'][] = $ar['VALUE'];
                    $arResult['ITEMS'][$links[$ar['IBLOCK_ELEMENT_ID']]]['DESCRIPTION'][$sopMainProps[$ar['IBLOCK_PROPERTY_ID']]]['DESCRIPTION'][] = $ar['DESCRIPTION'];
                }

            }
        } // закончили обработку связанных описаний, жизнь продолжается
    }
?>



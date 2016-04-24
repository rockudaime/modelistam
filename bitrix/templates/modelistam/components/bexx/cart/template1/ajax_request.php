<?php

switch ($_REQUEST['do']) {
    case "update":
    case "send": { // изменен город пользователя
        if ($_GET['do']=="calculate") {
            $component->SetTemplateName(".default_delivery");
            break;
        }
        if (is_array($_REQUEST['qty'])) {
            foreach ($_REQUEST['qty'] as $cart_item_id=>$new_qty) {
                if ($new_qty>0 AND !$_REQUEST['del'][$cart_item_id]) {
                    $cart = CSaleBasket::GetByID($cart_item_id);
                    $arCallbackPrice = BexxCartCallback($cart['PRODUCT_ID'], $new_qty);
                    if ($arCallbackPrice['PRODUCT_PRICE_ID']) {
                        $arFields = array(
                            "PRODUCT_PRICE_ID" => $arCallbackPrice["PRODUCT_PRICE_ID"],
                            "PRICE" => $arCallbackPrice["PRICE"],
                            "CURRENCY" => $arCallbackPrice["CURRENCY"],
                            "QUANTITY" => doubleval($new_qty)
                        );
                        CSaleBasket::Update(intval($cart_item_id), $arFields);
                    }
                } else {
                    CSaleBasket::Delete($cart_item_id);
                }
            }
        }
        $this->IncludeComponentTemplate("ajax_cart");
        break;
    }
    case "deleteAll": {
        CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
        break;
    }
    case "location": { // производится ввода названия города
        if (strlen($_GET['query']) > 1) {
            CModule::IncludeModule("sale");
            $arCities = array();
            $city_or_zip = trim(htmlspecialcharsbx(strip_tags($_GET['query'])));
            if (!defined("BX_UTF") OR !BX_UTF) {
                if (utf8_compliant($city_or_zip)) $city_or_zip = utf8win1251($city_or_zip); // Если через AJAX передалось в кодировке UTF-8 - конвертируем в windows-1251
            }
            
            // Кэшируем результат по введенным данным
            if (is_numeric($city_or_zip)) { // Поиск по индексу
                $db_result = $DB->Query("SELECT LOCATION_ID FROM b_sale_location_zip WHERE ZIP LIKE '".$city_or_zip."%'"); // Делаем выборку ID ГОРОДОВ, для которых подходит введенный индекс
                $arCitiesIDs = array();
                while ($city = $db_result->Fetch()) {
                    $arCitiesIDs[] = $city['LOCATION_ID'];
                }
                if (count($arCitiesIDs)) {
                    $rsCities = CSaleLocation::GetList(array("NAME"=>"ASC"), array("ID"=>$arCitiesIDs, "COUNTRY_LID"=>LANGUAGE_ID, "CITY_LID"=>LANGUAGE_ID), false, array('nTopCount'=>10));
                }
            } else { // Поиск по городу
                $rsCities = CSaleLocation::GetList(array("NAME"=>"ASC"), array("~CITY"=>$city_or_zip."%", "COUNTRY_LID"=>LANGUAGE_ID, "CITY_LID"=>LANGUAGE_ID), false, array('nTopCount'=>10));
            }
            if ($rsCities) {
                while ($arCity = $rsCities->GetNext()) {
                    $arCities[$arCity['ID']] = $arCity['CITY_NAME'];
                }
            }
            if (count($arCities)) {
                echo "{
                    query:'".$city_or_zip."',
                    suggestions:['".implode("','", $arCities)."'],
                    data:[]
                }";
            }
        }
        exit();
    }
}
?>

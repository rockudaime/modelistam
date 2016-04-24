<?php
/**
* Данный файл используется исключительно для обработки AJAX-запросов.
* Подключается только в случае поступления AJAX-запросов ($_REQUEST['ajax_call'])
* 
* Если через AJAX обновляется только часть данных, например, добавляется товар в корзину, тогда необходимо прерывать запрос.
* Если обновляется весь компонент, например, в форме оформления заказа, тогда надо убрать exit() в конце этого файла.
*/

$id = intval($_REQUEST['id']);
switch ($_POST['do']) {
    case "recount_offer": { // ищем SKU по параметрам
        // определим ИБ SKU
        $_REQUEST['param'] = array_map("trim", $_REQUEST['param']);
        $params_set_count = 0;
        foreach ($_REQUEST['param'] as $k=>$v) if (!empty($v)) $params_set_count++;
        $prop_code = reset($arParams['SKU_PROPS']);

        /*$arResult["CAT_PRICES"] = array();
        foreach ($arResult['PRICE_TYPES'] as $price_id=>$price_type) { // подготовка параметров для выборки
            $arResult["CAT_PRICES"][] = array(
                'ID' => $price_id,
                'TITLE' => $price_type['TITLE'],
                'SELECT' => 'CATALOG_GROUP_'.$price_id,
                'CAN_VIEW' => $price_type['CAN_VIEW'],
                'CAN_BUY' => $price_type['CAN_BUY']
            );
        }
        $arIblockFields = CIblock::GetFields($arParams['IBLOCK_ID']);
        if (is_array($arIblockFields)) $skuSelectFields = array_keys($arIblockFields);
        $arResult['OFFERS'] = CIBlockPriceTools::GetOffersArray(
            $arParams['IBLOCK_ID'],
            $arResult['ID'],
            array($arParams['SKU_SORT_FIELD']=>$arParams['SKU_SORT_DIR']),
            $skuSelectFields,
            $arParams['SKU_PROPS'],
            $arParams['SKU_COUNT'],
            $arResult["CAT_PRICES"],
            "Y"
        );
        d($arResult['OFFERS']);*/


        $offers_iblock = CIBlockPriceTools::GetOffersIBlock($arParams['IBLOCK_ID']);
        if ($offers_iblock['OFFERS_IBLOCK_ID']) {
            $arAllSKU = array();
            $arFilter = array(
                'IBLOCK_ID' => $offers_iblock['OFFERS_IBLOCK_ID'],
                'ACTIVE' => "Y",
                'PROPERTY_'.$offers_iblock['OFFERS_PROPERTY_ID'] => $id,
            );
            $rsSKUelements = CIBlockElement::GetList(array(), $arFilter);
            while ($obSKU = $rsSKUelements->GetNextElement()) {
                $this_sku_allowed = true;
                $sku = $obSKU->GetFields();

                $sku['PROPERTIES'] = $obSKU->GetProperties(array(), array('CODE'=>$prop_code));
                if (is_array($sku['PROPERTIES'][$prop_code]['VALUE'])) {
                    $sku_params = array();
                    foreach ($sku['PROPERTIES'][$prop_code]['VALUE'] as $k=>$param_value) {
                        $param_name = $sku['PROPERTIES'][$prop_code]['DESCRIPTION'][$k];
                        $sku_params[$param_name] = $param_value;
                    }
                }


                foreach ($_REQUEST['param'] as $param_name=>$param_value) {
                    if (!empty($param_value)) {
                        if ($sku_params[$param_name]!==$param_value) $this_sku_allowed = false;
                    }
                }

                if ($this_sku_allowed) {
                    $arAllSKU[$sku['ID']] = $sku;
                }

            }
            if (count($arAllSKU)==1) { // найден уникальный товар по параметрам, находим цену
                $finalSKU = reset($arAllSKU);
                $finalSKUprice = CCatalogProduct::GetOptimalPrice($finalSKU['ID'], $_REQUEST['qty']?intval($_REQUEST['qty']):1, $USER->GetUserGroupArray());
                $arResult['FINAL_SKU'] = array_merge($finalSKU, $finalSKUprice);
            } else {
                $arResult['SKU'] = $arAllSKU;
            }
        }
        $this->IncludeComponentTemplate("ajax_sku");
        break;
    }
    case "add2cart": { // добавлен в корзину
        CModule::IncludeModule("sale");
        CModule::IncludeModule("catalog");
        $orderParams = array();
        // Проверка входных переменных на предмет параметров товара для заказа
        foreach ($_REQUEST as $k=>$v) {
            if (strpos($k, "prop_")===0) {
                $prop_id = intval(str_replace("prop_", "", strip_tags(trim($k))));
                if ($prop_id>0 AND is_numeric($prop_id)) {
                    CModule::IncludeModule("iblock");
                    $prop_fields = CIBlockProperty::GetByID($prop_id)->GetNext();
                    if (is_array($prop_fields) AND !empty($prop_fields)) {
                        $value = intval(strip_tags(trim($v)));
                        if ($prop_fields['PROPERTY_TYPE'] == "L" AND $value>0) { // если список, надо преобразовать выбранное значение в выбранное
                            $value = CIBlockPropertyEnum::GetByID($value);
                            $value = $value['VALUE'];
                        }
                        $orderParams[] = array(
                            'NAME' => $prop_fields['NAME'],
                            'CODE' => $prop_id,
                            'VALUE' => $value,
                        );
                    }
                }
            }
        }
        $code = BexxAdd2Cart($id, $_REQUEST['qty']?intval($_REQUEST['qty']):1, $orderParams);
        $arResult['ADD2BASKET_OK'] = CSaleBasket::GetByID($code);
        $this->IncludeComponentTemplate("ajax_cart");
        break;
    }
    case "wishlist": {
        CModule::IncludeModule("sale");
        if ($id) {
            $rs = CSaleBasket::GetList(array(), array('PRODUCT_ID'=>$id, 'DELAY'=>"Y", 'FUSER_ID'=>CSaleBasket::GetBasketUserID(), 'ORDER_ID'=>NULL));
            if ($ar = $rs->GetNext()) {
                CSaleBasket::Delete($ar['ID']);
                unset($GLOBALS['wishlist_content'][$id]);
            } else {
                if (BexxAdd2Cart($id, 1, false, false, true)) {
                    $arResult['ADD2WISHLIST_OK'] = true;
                    $GLOBALS['wishlist_content'][$id] = 1;
                }
            }
        }
        $this->IncludeComponentTemplate("ajax_wishlist");
        break;
    }
    case "rate": { // оценен
        CModule::IncludeModule("bexx.shop");
        $arResult = CBexxShop::SetProductRating($id, intval($_REQUEST['rating']), $arParams['COMMENTS_ONLY_AUTHORIZED']=="Y");
        if (!$arResult['ERROR_MSG'] AND $arResult['ITEM_ID']) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->ClearByTag("bexx_item_".$arResult['ITEM_ID']); // удаляем кеш компонента после обновления рейтинга
        }
        $this->IncludeComponentTemplate("ajax_rater");
        break;
    }
    case "compare": { // добавлен в сравнение
        if (isset($_SESSION['compare'][$id])) {
            unset($_SESSION['compare'][$id]);
        } else {
            $_SESSION['compare'][$id] = 1;
        }
        $this->IncludeComponentTemplate("ajax_compare");
        break;
    }
    case "price_alert": {
        if ($USER->IsAuthorized()) {
            global $DB;
            $user_fields = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", $USER->GetId());
            $new_price_alert = $user_fields['UF_PRICE_ALERT']['VALUE'];
            if (!is_array($new_price_alert)) $new_price_alert = array();
            if (in_array($id, $new_price_alert)) { // такой товар есть в списке пользователя, удаляем
                unset($new_price_alert[array_search($id, $new_price_alert)]);
                $arResult['DELETE'] = 1;
            } else { // такого товара нет в списке оповещений пользователя, добавляем
                $new_price_alert[] = $id;
                $new_price_alert = array_unique($new_price_alert);
                $arResult['ADD'] = 1;
            }
            // В любом случае изменяем значение поля для пользователя
            $USER->Update($USER->GetId(), array(
                'UF_PRICE_ALERT' => $new_price_alert,
            ));
        }
        $this->IncludeComponentTemplate("ajax_price_alert");
        break;
    }
    //MM-249
    case "stock_alert": {
        if ($USER->IsAuthorized()) {
            global $DB;
            $user_fields = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", $USER->GetId());
            $new_stock_alert = $user_fields['UF_STOCK_ALERT']['VALUE'];
            if (!is_array($new_price_alert)) $new_price_alert = array();
            if (in_array($id, $new_stock_alert)) { // такой товар есть в списке пользователя, удаляем
                unset($new_stock_alert[array_search($id, $new_stock_alert)]);
                $arResult['DELETE'] = 1;
            } else { // такого товара нет в списке оповещений пользователя, добавляем
                $new_stock_alert[] = $id;
                $new_stock_alert = array_unique($new_stock_alert);
                $arResult['ADD'] = 1;
            }
            // В любом случае изменяем значение поля для пользователя
            $USER->Update($USER->GetId(), array(
                'UF_STOCK_ALERT' => $new_stock_alert,
            ));
        }
        $this->IncludeComponentTemplate("ajax_stock_alert");
        break;
    }
    //MM-249
    case "fast_buy_send":
    case "fast_buy": {
        $qty = $_POST['qty']?doubleval($_POST['qty']):1;
        if ($id) {
            if ($_POST['do']=="fast_buy_send") {
                if (strlen($_POST['phone'])>4) {
                    CModule::IncludeModule("iblock");
                    $el = CIBlockElement::GetByID(intval($_POST['id']))->Fetch();
                    $send = CEvent::Send("BEXX_FASTBUY_ORDER", SITE_ID, array(
                        'ITEM_ID' => $id,
                        'ITEM_NAME' => $el['NAME'],
                        'ITEM_QTY' => $qty,
                        'CLIENT_PHONE' => htmlspecialchars(strip_tags($_POST['phone'])),
                        'CLIENT_NAME' => htmlspecialchars(strip_tags(defined("BX_UTF")?$_POST['name']:utf8win1251($_POST['name']))),
                        'EMAIL' => COption::GetOptionString("sale", "order_email")
                    ));
                    if ($send) {
                        echo '<div class="fastbuy-container"><h3 class="blue">Благодарим вас, ваш заказ отправлен.</h3><p>В ближайшее время по указанному телефону вам позвонит менеджер интернет-магазина и уточнит детали вашего заказа. </p></div>';
                        break;
                    } else {
                        $arResult['ERRORS'][] = "Не удалось отправить сообщение";
                    }
                } else {
                    $arResult['ERRORS'][] = "Слишком короткий номер телефона";
                }
            }
            CModule::IncludeModule("iblock");
            CModule::IncludeModule("catalog");
            $arFilter = array(
                'ID' => $id, 
                'IBLOCK_ID' => $arParams['IBLOCK_ID'], 
                'INCLUDE_SUBSECTIONS' => "Y",
                'CHECK_PERMISSIONS' => $arParams['CHECK_PERMISSIONS'] // проверка прав доступа. Грузит систему, лучше отключать.
            );
            if ($arParams['CHECK_ACTIVE']=="Y") {
                $arFilter['ACTIVE'] = "Y";
                $arFilter['ACTIVE_DATE'] = "Y";
                $arFilter['GLOBAL_ACTIVE'] = "Y";
                $arFilter['IBLOCK_ACTIVE'] = "Y";
                $arFilter['BP_PUBLISHED'] = "Y"; // Бизнес-процессы
            }
            $arSelect = array('*');
            $arResult['PRICE_TYPES'] = array();
            $rs = CCatalogGroup::GetList(array('BASE'=>"DESC", 'SORT'=>"ASC"), array('CAN_ACCESS'=>"Y"));
            while ($price_type = $rs->Fetch()) {
                $arSelect[] = "CATALOG_GROUP_".$price_type['ID'];
                $arFilter['CATALOG_SHOP_QUANTITY_'.$price_type['ID']] = $qty; // выбрать цены для количества = 1
                $price_type['CAN_VIEW'] = $price_type['CAN_ACCESS'];
                $arResult['PRICE_TYPES'][$price_type['ID']] = $price_type;
            }
            $rsEl = CIblockElement::GetList(array(), $arFilter, false, false, $arSelect);
            if ($arItem = $rsEl->Fetch()) {
                $arItem['PRICES'] = CIBlockPriceTools::GetItemPrices($arParams['IBLOCK_ID'], $arResult['PRICE_TYPES'], $arItem);
                $arItem['PRICE'] = false;
                if (is_array($arItem['PRICES'])) {
                    foreach ($arItem['PRICES'] as $price) {
                        if ($price['VALUE']<$arItem['PRICE'] OR $arItem['PRICE']===false) {
                            $arItem['PRICE'] = $price['VALUE'];
                            $arItem['CURRENCY'] = $price['CURRENCY'];
                        }
                    }
                }
                $arItem['QUANTITY'] = $qty;
                $arResult['ITEM'] = $arItem;
            }
        }
        $this->IncludeComponentTemplate("ajax_fastbuy");
        break;
    }
    case "fast_buy_count": {
        CModule::IncludeModule("catalog");
        $price = CCatalogProduct::GetOptimalPrice(intval($_POST['id']), doubleval($_POST['qty']), $USER->GetUserGroupArray());
		$baseCurrency = CCurrency::GetBaseCurrency();
		$price["DISCOUNT_PRICE"] = CCurrencyRates::ConvertCurrency($price['DISCOUNT_PRICE'], $baseCurrency, $price["PRICE"]["CURRENCY"]);
      
		$item_price = price($price['DISCOUNT_PRICE'], $price['PRICE']['CURRENCY']);
        $total_price = price($price['DISCOUNT_PRICE']*doubleval($_POST['qty']), $price['PRICE']['CURRENCY']);
        echo $total_price."";
        ?>
        <script>$(function(){$('#fastbuy_price').text('<?=$item_price?>');$('#fastbuy_total').text('<?=$total_price?>');});</script>
        <?
        break;
    }
    //PST-7
    case "reserv_send":
    case "reserv": {
        if ($id) {
            if ($_POST['do']=="reserv_send") {
                if(strlen($_POST["email"]) > 1 && !check_email($_POST["email"]))
                    $arResult['ERRORS'][] = 'Указанный E-mail некорректен.';
                else{

                    CModule::IncludeModule("iblock");
                    $el = CIBlockElement::GetByID(intval($_POST['id']))->Fetch();

                    $send = CEvent::Send("RESERV_PRODUCT", SITE_ID, array(
                        'ITEM_ID' => $id,
                        'ITEM_NAME' => $el['NAME'],
                        'CLIENT_PHONE' => htmlspecialchars(strip_tags($_POST['phone'])),
                        'CLIENT_NAME' => htmlspecialchars(strip_tags(defined("BX_UTF")?$_POST['name']:utf8win1251($_POST['name']))),
                        'CLIENT_EMAIL' => $_POST['email'],
                        'EMAIL' => COption::GetOptionString("sale", "order_email")
                    ));

                    $send = true;
                    if ($send) {
                        echo '<div class="reserv-container"><h3>Благодарим!</h3><p>Ваша заявка принята, ожидайте извещения на свой e-mail</p></div>';
                        break;
                    } else {
                        $arResult['ERRORS'][] = "Не удалось отправить сообщение";
                    }
                }
            }

            CModule::IncludeModule("iblock");
            CModule::IncludeModule("catalog");
            $arFilter = array(
                'ID' => $id,
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'INCLUDE_SUBSECTIONS' => "Y",
            );
            $arSelect = array('*');
            $rsEl = CIblockElement::GetList(array(), $arFilter, false, false, $arSelect);
            if ($arItem = $rsEl->Fetch()) {
                $arResult['ITEM'] = $arItem;
            }
        }

        $this->IncludeComponentTemplate("ajax_reserv");
        break;
    }
    //PST-7
    default: exit();
}

exit(); // прерываем работу компонента
?>

<?php
/**
* Данный файл используется исключительно для обработки AJAX-запросов.
* Подключается только в случае поступления AJAX-запросов ($_REQUEST['ajax_call'])
* 
* Если через AJAX обновляется только часть данных, например, добавляется товар в корзину, тогда необходимо прерывать запрос.
* Если обновляется весь компонент, например, в форме оформления заказа, тогда надо убрать exit() в конце этого файла.
*/

switch ($_POST['do']) {
    case "add2cart": { // добавлен в корзину
        $arResult = BexxAdd2Cart(intval($_REQUEST['id']), $_REQUEST['qty']!=1?doubleval($_REQUEST['qty']):1);
        $this->IncludeComponentTemplate("ajax_cart");
        break;
    }
    case "add2wishlist": {
        if (BexxAdd2Cart(intval($_REQUEST['id']), 1, false, false, true)) {
            $arResult['ADD2WISHLIST_OK'] = true;
            $GLOBALS['wishlist_content'][intval($_REQUEST['id'])] = 1;
        }
        $this->IncludeComponentTemplate("ajax_wishlist");
        break;
    }
    case "update_sku": {
        $parent_id = intval($_REQUEST['id']); // товар-родитель
        $sku_id = intval($_REQUEST['sku']); // товарное предложение товара-родителя
        $sku_price = CCatalogProduct::GetOptimalPrice($sku_id, 1, $USER->GetUserGroupArray());
        echo price($sku_price['DISCOUNT_PRICE'], $sku_price['PRICE']['CURRENCY']);
        break;
    }
    case "rate": { // оценен
        CModule::IncludeModule("bexx.shop");
        $arResult = CBexxShop::SetProductRating(intval($_REQUEST['id']), intval($_REQUEST['rating']), $arParams['COMMENTS_ONLY_AUTHORIZED']=="Y");
        if (!$arResult['ERROR_MSG']) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->ClearByTag("bexx_item_".intval($_REQUEST['id'])); // удаляем кеш компонента после обновления рейтинга
        }
        break;
    }
    case "compare": { // добавлен в сравнение
        if (intval($_REQUEST['id'])>0) {
            if ($_SESSION['compare'][intval($_REQUEST['id'])]==1) {
                unset($_SESSION['compare'][intval($_REQUEST['id'])]);
            } else {
                $_SESSION['compare'][intval($_REQUEST['id'])]=1;
            }
        }
        $arResult['IDS'] = $_SESSION['compare'];
        $arResult['ID'] = intval($_REQUEST['id']);
        if (is_array($arResult['IDS'])) $arResult['COUNT'] = count($arResult['IDS']);
        else $arResult['COUNT'] = 0;
        if ($_REQUEST['back_url']) $_SESSION['back_url'] = $_REQUEST['back_url'];
        $this->IncludeComponentTemplate("ajax_compare");
        break;
    }
    default: exit();
}

exit(); // прерываем работу компонента
?>

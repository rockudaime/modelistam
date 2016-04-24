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
    //PST-7
    case "reserv_send":
    case "reserv": {
        if (intval($_REQUEST['id'])>0) {
            if ($_POST['do']=="reserv_send") {
                if(strlen($_POST["email"]) > 1 && !check_email($_POST["email"]))
                    $arResult['ERRORS'][] = 'Указанный E-mail некорректен.';
                else{

                    CModule::IncludeModule("iblock");
                    $el = CIBlockElement::GetByID(intval($_POST['id']))->Fetch();

                    $send = CEvent::Send("RESERV_PRODUCT", SITE_ID, array(
                        'ITEM_ID' => intval($_REQUEST['id']),
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
                'ID' => intval($_REQUEST['id']),
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

    // BIS new func show more
    case "show_more": {
        include_once("ajax_request_new_items.php");
        $this->IncludeComponentTemplate("view_block");
        break;
    }

    default: exit();
}

exit(); // прерываем работу компонента
?>

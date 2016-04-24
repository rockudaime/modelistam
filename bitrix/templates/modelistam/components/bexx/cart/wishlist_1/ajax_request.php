<?php

switch ($_REQUEST['do']) {
    case "update": { // изменен город пользователя
        if (is_array($_REQUEST['del'])) {
            foreach ($_REQUEST['del'] as $cart_item_id=>$new_qty) {
                CSaleBasket::Delete($cart_item_id);
            }
        }
        break;
    }
    case "deleteAll": {
        CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
        break;
    } 
}
?>

<?php
$arResult['USER_ID'] = CBexxShop::GetRatingUserID($arParams['ONLY_AUTHORIZED']=="Y");
if ($_REQUEST['do'] == "comment_vote") { // Добавление оценки комментария
    if (intval($_REQUEST['comment_id']) > 0 AND isset($_REQUEST['yes']) AND $arResult['USER_ID']) {
        $count = CIBlockElement::GetList(array(), array('ID'=>intval($_REQUEST['comment_id']), 'CREATED_BY'=>$arResult['USER_ID']), array()); // может это свой комментарий?
        if ($count == 0) { // не свой, значит можно
            $rs = CIBlockElement::GetList(array(), array('ID'=>intval($_REQUEST['comment_id']), 'ACTIVE'=>"Y"), false, array('nTopCount'=>1), array('ID', 'PROPERTY_helpful', 'PROPERTY_vain'));
            $ar = $rs->GetNext();
            $users_already_voted = array();
            if (is_array($ar['PROPERTY_HELPFUL_VALUE']) AND !empty($ar['PROPERTY_HELPFUL_VALUE']))
                $users_already_voted = array_merge($users_already_voted, $ar['PROPERTY_HELPFUL_VALUE']);
            if (is_array($ar['PROPERTY_VAIN_VALUE']) AND !empty($ar['PROPERTY_VAIN_VALUE']))
                $users_already_voted = array_merge($users_already_voted, $ar['PROPERTY_VAIN_VALUE']);
            if (!in_array($arResult['USER_ID'], $users_already_voted) AND $arResult['USER_ID']!=$ar['CREATED_BY']) {
                if ($_REQUEST['yes']) {
                    $ar['PROPERTY_HELPFUL_VALUE'][] = $arResult['USER_ID'];
                    CIBlockElement::SetPropertyValueCode($ar['ID'], 'helpful', $ar['PROPERTY_HELPFUL_VALUE']);
                    echo count($ar['PROPERTY_HELPFUL_VALUE']);
                } else {
                    $ar['PROPERTY_VAIN_VALUE'][] = $arResult['USER_ID'];
                    CIBlockElement::SetPropertyValueCode($ar['ID'], 'vain', $ar['PROPERTY_VAIN_VALUE']);
                    echo (count($ar['PROPERTY_VAIN_VALUE'])>0?"-":"").count($ar['PROPERTY_VAIN_VALUE']);
                }
            } else {
                if ($_REQUEST['yes']) {
                    if (!is_array($ar['PROPERTY_HELPFUL_VALUE'])) echo 0;
                    else echo count($ar['PROPERTY_HELPFUL_VALUE']);
                } else {
                    if (!is_array($ar['PROPERTY_VAIN_VALUE'])) echo 0;
                    else echo (count($ar['PROPERTY_VAIN_VALUE'])>0?"-":"").count($ar['PROPERTY_VAIN_VALUE']);
                }
            }
            if ($arParams['MANAGED_CACHE_ID']) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->ClearByTag($arParams['MANAGED_CACHE_ID']); // удаляем кеш компонента после обновления
            }
        } else { // Пользователь уже голосовал
            echo 0;
        }
    }
    exit();
}
?>

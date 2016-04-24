<?php
$arParams['ADDITIONAL_FILTER']['ID'] = 0;
if (is_array($_SESSION['compare']) AND !empty($_SESSION['compare'])) {
    $arParams['ADDITIONAL_FILTER'] = array('ID'=>array_keys($_SESSION['compare']));
}

// здесь exit(); не делаем, так как продолжается работа компонента целиком после обновления!
?>


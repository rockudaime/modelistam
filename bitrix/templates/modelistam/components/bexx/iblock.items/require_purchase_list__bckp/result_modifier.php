<?php
// Найдем аксессуары для товаров в корзине
if ($arResult['ITEMS'] AND $arResult['CART_ITEMS']) {
	$ids = array_keys($arResult['ITEMS']); // ID товаров в корзине уже
	
	$rs = CIBlockElement::GetList(array(
		"RAND"=>"ASC" // выбираем рэндомом
	), array(
		'ID'=>$ids, 
		'@PROPERTY_accessories'=>1
	), false, array('nTopCount'=>3), array(
		'ID', 
		'NAME', 
		'CODE', 
		'IBLOCK_SECTION_ID', 
		'IBLOCK_TYPE', 
		'IBLOCK_ID', 
		'LIST_PAGE_URL', 
		'PROPERTY_accessories',
	));
	
	$arResult['ACCESSORIES'] = array(); // Будет массив с аксессуарами для товаров в корзине
	while ($ar = $rs->GetNext()) {
		if ($ar['PROPERTY_ACCESSORIES_VALUE']) $arResult['ACCESSORIES'][$ar['ID']] = $ar;
		$arResult['ACCESSORIES_EXCLUDE'] = $ar['ID'];
	}
}

?>
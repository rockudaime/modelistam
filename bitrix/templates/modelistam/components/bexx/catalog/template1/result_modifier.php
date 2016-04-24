<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
//BSP-76
CModule::IncludeModule('iblock');
foreach ($arResult["SECTIONS"] as $k=>$arSection) {
    $arGroupedFilter[] = 'IBLOCK_ID';
    $rs = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arSection["ID"]), array('IBLOCK_ID'));
    while ($ar = $rs->GetNext()) {
        $arResult["SECTIONS"][$k]['QNT'] = $ar['CNT'];
    }
}
//BSP-76
?>
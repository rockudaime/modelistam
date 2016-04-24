<?if ($arResult['DELETE'] == 1):?>
    <a id="followProduct-link" href="#" class="follow-block-links item_money" onclick="ajax_load('#pricealertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=price_alert&id=<?=intval($_REQUEST['id'])?>');" title="Следить за ценой"><i></i><div class="hover-link">Следить<br/> за ценой</div></a>
<?else:?>
    <a id="followProduct-link" href="#" class="follow-block-links item_money item_money-hovered" onclick="ajax_load('#pricealertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=price_alert&id=<?=intval($_REQUEST['id'])?>');" title="Не отслеживать цену"><i></i><div class="hover-link">Не отслеживать<br/> цену</div></a>
<?endif;?>

<?//MM-223?>
<?

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->GetNext();

if ($arUser['UF_PRICE_ALERT']) {
    $arAlert = array();
    CModule::IncludeModule("iblock");
    $arSelect = array('ID', 'NAME', 'DETAIL_PICTURE', 'LIST_PAGE_URL', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'ACTIVE', 'CODE', 'CATALOG_QUANTITY');
    $rs = CIBlockElement::GetList(array("SORT"=>"ASC", 'ID'=>"DESC"), array('ID'=>$arUser['UF_PRICE_ALERT'], 'CHECK_PERMISSIONS'=>"Y"), false, $false, $arSelect);
    while ($ar = $rs->GetNext()) {
        $arAlert[$ar['ID']] = $ar;
    }
}
?>

<script>
    if (<?=count($arAlert)?> > 0){
        $("#price-count-alert").empty();
        $('#price-count-alert').append('<div class="wish-count "><?=count($arAlert)?></div>');

    }else{
        $("#price-count-alert").empty();
    }
</script>
<?//MM-223?>
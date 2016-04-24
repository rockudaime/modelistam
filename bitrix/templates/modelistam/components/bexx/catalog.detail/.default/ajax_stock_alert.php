<?if ($arResult['DELETE'] == 1):?>
    <a id="followProduct-link" href="#" class="follow-block-links waiting-link-item" onclick="ajax_load('#stockalertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=stock_alert&id=<?=intval($_REQUEST['id'])?>'); return false;" title="Следить за наличием"><i></i><div class="hover-link">Следить <br/>за наличием</div></a>
<?else:?>
    <a id="followProduct-link" href="#" class="follow-block-links waiting-link-item waiting-link-item-hovered" onclick="ajax_load('#stockalertProduct', '<?=intval($_REQUEST['id'])?>', 'do=stock_alert&id=<?=$arResult['ID']?>'); return false;" title="Не отслеживать наличие"><i></i><div class="hover-link">Не отслеживать<br/> наличие</div></a>
<?endif;?>
<?//MM-249?>
<?

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->GetNext();

if ($arUser['UF_STOCK_ALERT']) {
    $arAlert = array();
    CModule::IncludeModule("iblock");
    $arSelect = array('ID', 'NAME', 'DETAIL_PICTURE', 'LIST_PAGE_URL', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'ACTIVE', 'CODE', 'CATALOG_QUANTITY');
    $rs = CIBlockElement::GetList(array("SORT"=>"ASC", 'ID'=>"DESC"), array('ID'=>$arUser['UF_STOCK_ALERT'], 'CHECK_PERMISSIONS'=>"Y"), false, $false, $arSelect);
    while ($ar = $rs->GetNext()) {
        $arAlert[$ar['ID']] = $ar;
    }
}

?>

<script>
    if (<?=count($arAlert)?> > 0){
        $("#stock-count-alert").empty();
        $('#stock-count-alert').append('<div class="wish-count "><?=count($arAlert)?></div>');

    }else{
        $("#stock-count-alert").empty();
    }
</script>

<?//MM-249?>
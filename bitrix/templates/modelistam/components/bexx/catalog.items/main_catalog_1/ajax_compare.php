<script>
	update_compare_block();
</script>


<?if (!empty($_SESSION['compare']) AND is_array($_SESSION['compare'])) {
    //$_SESSION['compare']
}?>

<?if ($arResult['IDS'][$arResult['ID']] == 1):?>
    <div data-compare-id="<?=$arResult['ID']?>" class="float-left checkbox-black-checked" onclick="ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$arResult['ID']?>')"></div>
    <div class="product-compare-link compared"<?if ($arResult['COUNT']==1):?> onclick="ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$arResult['ID']?>')"<?endif;?>><span class="article">к сравнению</span></div>
<?else:?>
    <div data-compare-id="<?=$arResult['ID']?>" class="float-left checkbox-black" onclick="ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$arResult['ID']?>')"></div>
    <div class="product-compare-link" onclick="ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$arResult['ID']?>')"><span class="article">к сравнению</span></div>
<?endif;?>

<?if ($arResult['COUNT']>1):?>
<script>
$(function(){
    $('div.compared').each(function() {
        <?
        $url = $_SERVER['HTTP_REFERER'];
        ?>
        $(this).html('<a href="<?=$url.(strpos($url, "?")?"&":"?")."compare"?>">Сравнить</a>');
    });
});
</script>

<?endif;?>
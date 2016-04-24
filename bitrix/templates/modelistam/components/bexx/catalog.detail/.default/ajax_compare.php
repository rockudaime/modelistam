<script>
    update_compare_block();
</script>


<?if ($_SESSION['compare'][intval($_POST['id'])] == 1):?>
	<div class="product-compare-link compared" onclick="ajax_load('#product-compare-<?=intval($_POST['id'])?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=intval($_POST['id'])?>')">
        <span class="hover-link">Убрать из сравнения</span>
    </div>
<?else:?>
	<div class="product-compare-link" onclick="ajax_load('#product-compare-<?=intval($_POST['id'])?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=intval($_POST['id'])?>')">
        <span class="hover-link">Сравнить</span>
    </div>
<?endif;?>


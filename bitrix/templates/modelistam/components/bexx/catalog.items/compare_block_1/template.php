<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
//$this->setFrameMode(true);
$frame = $this->createFrame()->begin();
//PST-9
?>
<?if ($arParams['AJAX_CALL']!="Y"):?>
<script>
    function update_compare_block() {
        ajax_block('#compare_block');
        ajax_load('#compare_block', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare_block');
    }
    BIS.compareBlockObj = {
        init: function() {
            var deleteLinks = $('.compare-item__delete-link');
            var curDataID;
            var self = this;

            deleteLinks.on('click', function(e) {
                e.preventDefault();
                curDataID = $(this).data('delete-id');
                self.deleteCurrentItem(curDataID);
            })
        },
        deleteCurrentItem: function(id) {
            var catalogProducts = $('.main-catalog-products');
            var curCompareElem;
            curCompareElem = catalogProducts.find('.checkbox-black-checked').filter(function(){
                return $(this).data('compare-id')==id;
            });
            curCompareElem.trigger('click');
        }
    }
</script>
	<div id="compare_block">
<?endif;?>

<script>
    $(function() {
        BIS.compareBlockObj.init();
    })
</script>


<?if (is_array($arResult['ITEMS']) AND !empty($arResult['ITEMS'])):?>

<?
	$arResult['ITEMS'] = array_slice($arResult['ITEMS'], 0, 3, true);
	$items_ids = array_keys($arResult['ITEMS']); // знаем все ID всех товаров
	$count = count($arResult['ITEMS']);
	if ($count<2 AND $back_url) {
		exit();
	}
	// Формируем ссылки для удаления товаров из сравнения. Зажопский код, не обессутьте
	$delete_urls = array();
	$delete_url_parts = array();
	foreach ($items_ids as $items_id) $delete_url_parts[$items_id] = "compare[]=".$items_id;
	foreach ($items_ids as $items_id) {
		$temp_url_parts = $delete_url_parts;
		unset($temp_url_parts[$items_id]);
		$delete_urls[$items_id] = $APPLICATION->GetCurPageParam(implode("&", $temp_url_parts), array("compare"), false);
	}
?>

<div class="detail-small-block">
    <?if (strlen($arParams['BLOCK_TITLE'])):?>
    <div class="small-block__title"><?=$arParams['BLOCK_TITLE']?></div>
    <?endif;?>

    <div class="small-block__inner">
		<?$counter=0?>
		<?foreach ($arResult['ITEMS'] as $item):?>
		<?$counter++;?>
			<div class="block item">
				<a data-delete-id="<?=$item['ID'];?>" class="compare-item__delete-link" href="#"></a>
				<?if ($item['DETAIL_PICTURE']):?>
				<a href="<?=$item['DETAIL_PAGE_URL']?>">
					<img alt="<?=$item['NAME']?>" align="left" width="40" height="40" style="margin-right: 10px;" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>40, 'hl'=>40, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
				</a>
				<?else:?>
					<img alt="<?=$item['NAME']?>" align="left" width="40" style="margin-right: 10px;" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
				<?endif;?>
				<div class="product-special">
					<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
					<span class="price-span"><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
				</div>
			</div>
		<?endforeach;?>
		<div class="compare-link-parent">
			<?if (count($arResult['ITEMS'])==1):?>
				Добавьте еще хотя бы 1 товар к сравнению
			<?elseif (count($arResult['ITEMS'])>1):?>
				<div class="compare-link">
                    <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>?compare" class="butt3" title="Сравнить">Сравнить</a></div>
			<?endif;?>
		</div>
	</div>
</div>
<?endif;?>
<?if ($arParams['AJAX_CALL']!="Y"):?>
	</div>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
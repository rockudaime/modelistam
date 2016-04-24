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
</script>
	<div id="compare_block">
<?endif;?>

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

<div class="detail-compare-block">
	<div class="content">
        <div class="detail-compare-block"__inner">
            <?$counter=0?>
            <?foreach ($arResult['ITEMS'] as $item):?>
                <?$counter++;?>

                <div class="block-item">
                    <a data-delete-id="<?=$item['ID'];?>" class="compare-item__delete-link" href="#">
                        <img src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-delete.png" />
                    </a>

                    <div class="block-item__image">
                        <?if ($item['DETAIL_PICTURE']):?>
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <img alt="<?=$item['NAME']?>" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>221, 'hl'=>147, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                            </a>
                        <?else:?>
                            <img alt="<?=$item['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                        <?endif;?>
                    </div>

                    <div class="block-item__content product-special">
                        <a class="block-item__content__name" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
                        <span class="price-span"><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
                    </div>
                </div>
            <?endforeach;?>
            <div class="compare-link-parent">
                <?if (count($arResult['ITEMS'])==1):?>
                    Добавьте еще хотя бы 1 товар к сравнению
                <?elseif (count($arResult['ITEMS'])>1):?>
                    <div class="compare-link">
                        <a href="javascript:void(0);" class="butt1" title="Сравнить">Сравнить</a>
                    </div>
                    <script type="text/javascript">
                        BIS.detailCompareObj = {
                            updateMainCompareLink: function() {
                                var breadcrumb = $('#breadcrumb');
                                var lastLinkUrl = $.trim(breadcrumb.find('a').last().attr('href'));
                                var compareLink = $('.compare-link > a');

                                if(lastLinkUrl != '') {
                                    lastLinkUrl+='?compare';
                                    compareLink.attr('href', lastLinkUrl);
                                }
                            }
                        }
                        $(function() {
                            BIS.detailCompareObj.updateMainCompareLink();
                        })
                    </script>
                <?endif;?>
            </div>
        </div>
	</div>
</div>
<?else:?>
    <p>Добавьте товары для сравнения</p>
<?endif;?>
<?if ($arParams['AJAX_CALL']!="Y"):?>
	</div>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>
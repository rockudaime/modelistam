<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?if (is_array($arResult['ITEMS'])):?>
<div class="block detail-small-block akcii-block">
	<div class="content">
		<?$counter=0?>
		<?foreach ($arResult['ITEMS'] as $item):?>
		<?$counter++;?>
			<div class="block item<?if ($counter>=count($arResult['ITEMS'])):?> last<?endif;?>">
				<?if ($item['DETAIL_PICTURE']):?>
				<a href="<?=$item['DETAIL_PAGE_URL']?>">
					<img alt="<?=$item['NAME']?>" align="left" width="40" height="40" style="margin-right: 10px;" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>40, 'hl'=>40, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
				</a>
				<?else:?>
					<img alt="<?=$item['NAME']?>" align="left" width="40" height="40" style="margin-right: 10px;" src="<?=SITE_TEMPLATE_PATH?>/images/eshop/bg-detail-small-no-image.png" />
				<?endif;?>
				<div class="product-special">
					<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
					<span class="price-span"><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
				</div>
			</div>
		<?endforeach;?>
	</div>
</div>
<?if ($arParams['BLOCK_URL'] AND $arParams['BLOCK_URL_TITLE']):?>
    <div class="float-right text-small">
		<a class="" href="<?=$arParams['BLOCK_URL']?>"><?=$arParams['BLOCK_URL_TITLE']?></a>
	</div>
    <br class="clear" />
<?endif;?>
<?endif;?>
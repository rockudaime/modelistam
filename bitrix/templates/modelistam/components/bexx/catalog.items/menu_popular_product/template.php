<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?if (is_array($arResult['ITEMS'])):?>
<?
if (!$arParams['COLUMNS_COUNT']) $arParams['COLUMNS_COUNT'] = 3;
if (!$arParams['BLOCK_WIDTH']) $arParams['BLOCK_WIDTH'] = 175;
if ($arParams['SHOW_BORDER']!="N") $arParams['SHOW_BORDER'] = "Y";
?>
<div class="wide-block">
<?if ($arParams['SHOW_BORDER']=="Y"):?>
<div class="block">
	<div class="content">
<?endif;?>
		<?if (strlen($arParams['BLOCK_TITLE'])):?><p class="title orange"><strong><?=$arParams['BLOCK_TITLE']?></strong> <img align="baseline" src="<?=SITE_TEMPLATE_PATH?>/images/arr-orange-down.gif" alt="" /></p><?endif;?>
		<?$counter=0?>
		<?foreach ($arResult['ITEMS'] as $item):?>
			<?
			$counter++;
			$is_last = false;
			if ($counter+$arParams['COLUMNS_COUNT']>count($arResult['ITEMS'])) { // приближаемся к концу, проверяем
				$is_last = true;
				for ($i=$counter; $i<count($arResult['ITEMS']); $i++) {
					if ($i%$arParams['COLUMNS_COUNT']==0) $is_last = false;
				}
			}
			?>
			<div class="catalog-item-card-menu">

               <div class="item-image-menu">
               		<?if ($item['DETAIL_PICTURE']):?>
						<a href="<?=$item['DETAIL_PAGE_URL']?>">
							<img alt="<?=$item['NAME']?>" src="<?=MakeImage($item['DETAIL_PICTURE'], 120, 30*86400, array('w'=>120, 'h'=>120))?>" />
						</a>
					<?else: ?>
						<img alt="<?=$item['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.gif" />
					<?endif;?>
            	</div>

				<div class="item-info-menu">
					<div class='item-title'>
						<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
					</div>
					
					<div class='item-price-menu'>
						<span><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
					</div>
					
				<div class="item-buy-block-menu">
					<a class="ui-button-blue" href="<?=$item['DETAIL_PAGE_URL']?>">Подробнее</a>
				</div>


				</div>
			</div>
		<?endforeach;?>
<?if ($arParams['SHOW_BORDER']=="Y"):?>
	</div>
</div>
</div>
<?endif;?>
<?endif;?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (count($arResult) > 0):?>
<div class="last-viewed-block__title">Вы уже смотрели:</div>
<div class="view-list">
	<ul>
	<?foreach($arResult as $arItem):?>
		<li class="view-item">
			
			<?if($arParams["VIEWED_IMAGE"]=="Y" && is_array($arItem["PICTURE"])):?>
				<div class="image-block">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img src="<?=$arItem["PICTURE"]["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">
					</a>
				</div>
			<?else:?>
				<div class="image-block">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<img src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.gif" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">
					</a>
				</div>
			<?endif?>
			
			<?if($arParams["VIEWED_NAME"]=="Y"):?>
				<div class="url-viewed"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
			<?endif?>
			
			<?if($arParams["VIEWED_PRICE"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
				<div class="price-viewed"><?=$arItem["PRICE_FORMATED"]?></div>
				
			<?else: ?>
				<div class="price-viewed">Нет цены</div>
			<?endif?>
			
			<noindex>
				<div class="buy-viewed">
					<a class="ui-button-blue" href="<?=$arItem["DETAIL_PAGE_URL"]?>" rel="nofollow">
						Посмотреть
					</a>
				</div>
			</noindex>
			
			<?if($arParams["VIEWED_CANBUSKET"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
				<noindex>
					<a href="<?=$arItem["ADD_URL"]?>" rel="nofollow"><?=GetMessage("PRODUCT_BUSKET")?></a>
				</noindex>
			<?endif?>
		</li>
	<?endforeach;?>
	</ul>
</div>
<?endif;?>
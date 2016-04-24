<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?//d($arResult);?>
<div style="height: 40px;">
	<div class="tabs_menu">
		<ul class="tabs_menu">
			<?foreach($arResult as $k=>$arItem):?>
				<?if ($arItem['SELECTED']):?>
					<li class="tabs_menu selected">
						<div class="selected">
							<a class="gray" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
						</div>
					</li>
				<?else:?>
					<li class="tabs_menu ">
						<a <?if ($k+1<count($arResult) AND !$arResult[$k+1]['SELECTED']):?>class="dotted_line-right"<?endif;?> style="padding-right: 10px;" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					</li>
				<?endif;?>
			<?endforeach?>
		</ul>
		<br class="clear" />
	</div>
</div>
<?endif?>
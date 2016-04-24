<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ROWS"]) > 0): ?>
<h5><?=GetMessage("CR_TITLE")?></h5>
<div class="catalog-top">
<?
foreach($arResult["ROWS"] as $arItems):
?>
	<div class="catalog-item-cards">
	<table class="catalog-item-card" cellspacing="0">
		<tr class="top">
<?
	foreach($arItems as $key => $arElement):
		if ($key > 0):
?>
			<td class="delimeter"></td>
<?
		endif;
?>
			<td width="<?=$arResult["TD_WIDTH"]?>"><?if(is_array($arElement)):?><div class="corner left-top"></div><div class="corner right-top"></div><div class="border-top"></div><?endif;?></td>
<?
	endforeach;
?>
		</tr>
		<tr>
<?
	foreach($arItems as $key => $arElement):
		if ($key > 0):
?>
			<td class="delimeter"></td>
<?
		endif;
		if(is_array($arElement)):
			$bPicture = is_array($arElement["PREVIEW_IMG"]);
?>
			<td>
				<div class="catalog-item-card<?=$bPicture ? '' : ' no-picture-mode'?>">
<?
			if ($bPicture):
?>
					<div class="item-image">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arElement["PREVIEW_IMG"]["SRC"]?>" width="<?=$arElement["PREVIEW_IMG"]["WIDTH"]?>" height="<?=$arElement["PREVIEW_IMG"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" id="catalog_list_image_<?=$arElement['ID']?>" /></a>
					</div>
					<?
			else:
?>
					<div class="item-image">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="/bitrix/templates/store_minimal_violet/images/no-photo.gif" width="100" height="100" alt="Фото ожидается" title="Фото ожидается" id="catalog_list_image_<?=$arElement['ID']?>" /></a>
					</div>
<?
			endif;
?>
					<div class="item-info">
						<p class="item-title">
							<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
						</p>
						
<?
			if(count($arElement["PRICES"])>0):
				foreach($arElement["PRICES"] as $code=>$arPrice):
					if($arPrice["CAN_ACCESS"]):
?>
						<p class="item-price">
<?
						if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):
?>
							<span><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span> <s><?=$arPrice["PRINT_VALUE"]?></s> 
<?
						else:
?>
							<span><?=$arPrice["PRINT_VALUE"]?></span>
<?
						endif;
?>
						</p>
<?
					endif;
				endforeach;
			endif;
?>
					</div>
				</div>
			</td>
<?
		else:
?>
			<td class="delimeter"></td>
<?
		endif;
?>
<?
	endforeach;
?>
		</tr>
		<tr class="bottom">
<?
	foreach($arItems as $key => $arElement):
		if ($key > 0):
?>
			<td class="delimeter"></td>
<?
		endif;
?>
			<td><?if(is_array($arElement)):?><div class="corner left-bottom"></div><div class="corner right-bottom"></div><div class="border-bottom"></div><?endif;?></td>
<?
	endforeach;
?>
		</tr>
	</table>
	</div>
<?
endforeach;
?>
</div>
<?elseif($USER->IsAdmin()):?>
<h5><?=GetMessage("CR_TITLE")?></h5>
<div class="catalog-top">
	<?=GetMessage("CR_TITLE_NULL")?>
</div>
<?endif;?>

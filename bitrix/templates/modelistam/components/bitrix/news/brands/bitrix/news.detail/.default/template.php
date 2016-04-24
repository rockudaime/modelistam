<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
	<p class="text-small grey"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
<?endif;?>
<h2><?=$arResult["NAME"]?></h2>
<?if ($arResult["DETAIL_PICTURE"]['ID']>0):?>
	<?
	CModule::IncludeModule("bexx.shop");
	?>
	<p><?=CFile::ShowImage(MakeImage($arResult["DETAIL_PICTURE"]['SRC'], array('w'=>550)))?>&nbsp;</p>
<?endif;?>
<div class="description">
	<?=$arResult["DETAIL_TEXT"];?>
</div>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (is_array($arResult['ITEMS'])):?>
	<?foreach ($arResult['ITEMS'] as $item):?>
		<div><span><?=date("d.m.Y", MakeTimeStamp($item['DATE_CREATE']))?></span> <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></div>
	<?endforeach;?>
<?endif;?>
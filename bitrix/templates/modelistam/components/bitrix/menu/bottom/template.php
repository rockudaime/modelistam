<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))
	return;
?>

<ul class="footer-list">
	<?foreach($arResult as $itemIdex => $arItem):?>
	<li class="footer-list-item">
        <a class="footer-list-link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
    </li>
	<?endforeach;?>
</ul>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?if (!empty($arResult)):?>
<div class="menu_line">
	<?foreach($arResult as $arItem):?>
		<div><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
	<?endforeach?>
</div>
<script>
$(function(){
	$(".menu_line div").mouseover(function(){$(this).addClass('active');});
	$(".menu_line div").mouseout(function(){$(this).removeClass('active');});
});
</script>
<?endif?>
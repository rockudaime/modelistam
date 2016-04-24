<?if ($arResult['DETAIL_PAGE_URL']):?>
	Спасибо, хотите <a href="<?=$arResult['DETAIL_PAGE_URL']?>#comment-form">оставить отзыв</a>?
<?else:?>
	Спасибо за вашу оценку
<?endif;?>
<script>
$(function(){$('.empty_rate_<?=$arResult['ITEM_ID']?>').hide()});
</script>
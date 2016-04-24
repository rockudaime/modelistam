<?if ($arResult['SHOW_RESULT']==1):?>
	<?if ($arResult['COUNT']>0):?>
		<script>
		$('#filter-result').show();
		</script>
		<span class="float-right" onclick="$('#filter-result').hide();" style="cursor: pointer;">x</span>
		<span class="float-left" style="width: 110px">
			<?=padej($arResult['COUNT'], "Найден", "Найдено", "Найдено", false)?> <?=padej($arResult['COUNT'], "товар", "товара", "товаров")?>
			<?if ($arResult['LINK']):?><br /><a href="<?=$arResult['LINK']?>">Показать</a><?endif;?>
		</span>
	<?else:?>
		<script>
		$('#filter-result').show();
		</script>
		<span class="float-right" onclick="$('#filter-result').hide();" style="cursor: pointer;">x</span>
		<span class="float-left" style="width: 110px">
			Ничего не найдено
		</span>
	<?endif;?>
<?else:?>
	<script>
	$('#filter-result').hide();
	</script>
<?endif;?>
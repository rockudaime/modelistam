<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$arResult['NAV'] = $arResult['NAV_CUSTOM']; // К черту NAV
$arUriKillParams = array("page", "p", "s", "sort", "s_prop", "s_prop_dir", "brand", "brands", "prop"); // Эти параметры удаляются из адреса страницы в постраничной навигации
?>
<?if (is_array($arResult['ITEMS'])):?>
	<?if ($arResult['NAV']['PAGES_COUNT'] > 1):?>
	<div class="pager-border-bottom pager">
		<div class="float-left">
			<span class="grey">Страница: </span> &nbsp;
			<?if ($arResult['NAV']['CURRENT_PAGE']>1):?>
			<a href="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>"><img alt="в начало" title="в начало" src="<?=SITE_TEMPLATE_PATH?>/images/first-orange.gif" /></a>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']-1), $arUriKillParams, false)?>"><img alt="предыдущая" title="предыдущая" src="<?=SITE_TEMPLATE_PATH?>/images/previous-orange.gif" /></a>
			<?endif;?>
			<?
			$left_space = 0;
			$right_space = 0;
			for ($i=1; $i<=$arResult['NAV']['PAGES_COUNT']; $i++) {
				if ($arResult['NAV']['PAGES_COUNT'] < 5) {
					if ($arResult['NAV']['CURRENT_PAGE'] == $i):?>
						<span class="strong"><?=$i?></span> &nbsp;
					<?else:?>
						<a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"<?if ($arResult['NAV']['CURRENT_PAGE'] == $i) echo ' class="current_page"';?>><?=$i?></a> &nbsp;
					<?endif;
				} else {
					if ($arResult['NAV']['CURRENT_PAGE'] == $i) {
						?> <span class="strong"><?=$i?></span> &nbsp; <?
					} else {
						if ($i-1 == $arResult['NAV']['CURRENT_PAGE'] OR $i+1 == $arResult['NAV']['CURRENT_PAGE']) {
							?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"><?=$i?></a> &nbsp; <?
						} elseif ($i < $arResult['NAV']['PAGES_COUNT'] AND $i > $arResult['NAV']['CURRENT_PAGE']) {
							if ($right_space == 0) echo "&nbsp;&rarr;&nbsp;";$right_space++;								
						} elseif ($i > 1 AND $i < $arResult['NAV']['CURRENT_PAGE']) {
							if ($left_space == 0) echo "&nbsp;&larr;&nbsp;"; $left_space++;
						} else {
							?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"><?=$i?></a> &nbsp; <?
						}
					}
				}
			}
			?>
			<?if ($arResult['NAV']['CURRENT_PAGE']<$arResult['NAV']['PAGES_COUNT']):?>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']+1), $arUriKillParams, false)?>"><img alt="следущая" title="следущая" src="<?=SITE_TEMPLATE_PATH?>/images/next-orange.gif" /></a>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".$arResult['NAV']['PAGES_COUNT'], $arUriKillParams, false)?>"><img alt="в конец" title="в конец" src="<?=SITE_TEMPLATE_PATH?>/images/last-orange.gif" /></a>
			<?endif;?>
		</div>
		<div class="float-right">
			<span class="grey">
				<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['ITEMS_PER_PAGE']-$arParams['ITEMS_PER_PAGE']+1?> 
				-
				<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['ITEMS_PER_PAGE']-$arParams['ITEMS_PER_PAGE']+count($arResult['ITEMS'])?>
				из
			</span>
			<span class="strong"><?=$arResult['NAV']['TOTAL']?></span>
		</div>
	</div>
	<br class="clear" />
	<?endif;?>
	<!-- .pager -->
	<br class="clear" />
	<?$counter=0;?>
	<?foreach ($arResult['ITEMS'] as $item):?>
	<?$counter++?>
	<div class="block item <?if ($counter==count($arResult['ITEMS'])):?>last<?endif;?>" style="padding-bottom: 12px;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="127" valign="top">
					<?$image = $item['PREVIEW_PICTURE']?$item['PREVIEW_PICTURE']:$item['DETAIL_PICTURE']?>
					<?if ($image):?>
					<div class="preview-image float-left display-block">
						<a href="<?=$item['DETAIL_PAGE_URL']?>"><img alt="<?=htmlspecialchars($item['NAME']);?>" width="108" src="<?=MakeImage($image, array('w'=>108))?>" /></a>
					</div>
					<?endif;?>
				</td>
				<td width="410">
					<div class="float-left news" style="width: 425px;">
						<div style="padding-bottom: 5px;"> <a class="black strong" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a> </div>
						<div>
							<p class="dark-grey" style="margin: 5px 0 0 0;">
								<?=$item['PREVIEW_TEXT']?>
							</p>
						</div>
						<div class="float-left"">
							<div class="text-center">
								<ul class="action-list">
									<li ><a class="arr-2-right-orange text-small" href="<?=$item['DETAIL_PAGE_URL']?>">подробнее</a></li>
								</ul>
							</div>
						</div>
						<br class="clear" />
					</div>
				</td>
			</tr>
		</table>
	</div>
	<?endforeach;?>
	<div class="pager-border-top pager">
		<div class="float-left">
			<span class="grey">Страница: </span> &nbsp;
			<?if ($arResult['NAV']['CURRENT_PAGE']>1):?>
			<a href="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>"><img alt="в начало" title="в начало" src="<?=SITE_TEMPLATE_PATH?>/images/first-orange.gif" /></a>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']-1), $arUriKillParams, false)?>"><img alt="предыдущая" title="предыдущая" src="<?=SITE_TEMPLATE_PATH?>/images/previous-orange.gif" /></a>
			<?endif;?>
			<?
			$left_space = 0;
			$right_space = 0;
			for ($i=1; $i<=$arResult['NAV']['PAGES_COUNT']; $i++) {
				if ($arResult['NAV']['PAGES_COUNT'] < 5) {
					if ($arResult['NAV']['CURRENT_PAGE'] == $i):?>
						<span class="strong"><?=$i?></span> &nbsp;
					<?else:?>
						<a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"<?if ($arResult['NAV']['CURRENT_PAGE'] == $i) echo ' class="current_page"';?>><?=$i?></a> &nbsp;
					<?endif;
				} else {
					if ($arResult['NAV']['CURRENT_PAGE'] == $i) {
						?> <span class="strong"><?=$i?></span> &nbsp; <?
					} else {
						if ($i-1 == $arResult['NAV']['CURRENT_PAGE'] OR $i+1 == $arResult['NAV']['CURRENT_PAGE']) {
							?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"><?=$i?></a> &nbsp; <?
						} elseif ($i < $arResult['NAV']['PAGES_COUNT'] AND $i > $arResult['NAV']['CURRENT_PAGE']) {
							if ($right_space == 0) echo "&nbsp;&rarr;&nbsp;";$right_space++;								
						} elseif ($i > 1 AND $i < $arResult['NAV']['CURRENT_PAGE']) {
							if ($left_space == 0) echo "&nbsp;&larr;&nbsp;"; $left_space++;
						} else {
							?> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", $arUriKillParams, false)?>"><?=$i?></a> &nbsp; <?
						}
					}
				}
			}
			?>
			<?if ($arResult['NAV']['CURRENT_PAGE']<$arResult['NAV']['PAGES_COUNT']):?>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']+1), $arUriKillParams, false)?>"><img alt="следущая" title="следущая" src="<?=SITE_TEMPLATE_PATH?>/images/next-orange.gif" /></a>
			<a href="<?=$APPLICATION->GetCurPageParam("page=".$arResult['NAV']['PAGES_COUNT'], $arUriKillParams, false)?>"><img alt="в конец" title="в конец" src="<?=SITE_TEMPLATE_PATH?>/images/last-orange.gif" /></a>
			<?endif;?>
		</div>
		<div class="float-right">
			<span class="grey">
				<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['ITEMS_PER_PAGE']-$arParams['ITEMS_PER_PAGE']+1?> 
				-
				<?=$arResult['NAV']['CURRENT_PAGE']*$arParams['ITEMS_PER_PAGE']-$arParams['ITEMS_PER_PAGE']+count($arResult['ITEMS'])?>
				из
			</span>
			<span class="strong"><?=$arResult['NAV']['TOTAL']?></span>
		</div>
	</div>
	<!-- .pager -->
	<br class="clear" />
<?endif;?>
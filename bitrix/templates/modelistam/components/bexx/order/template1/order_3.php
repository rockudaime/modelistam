<h3>3 - Служба доставки</h3>
<?if (is_array($arResult['DELIVERY_SYSTEMS'])):?>
	<?if (count($arResult['DELIVERY_SYSTEMS']) > 6):?>
		<select name="delivery_system" onchange="order_form_reload()">
		<?foreach ($arResult['DELIVERY_SYSTEMS'] as $delivery_system_id=>$delivery_system):?>
			<option value="<?=$delivery_system_id?>"<?if ($arResult['CURRENT']['DELIVERY_SYSTEM'] == $delivery_system_id):?> selected<?endif;?>><?=$delivery_system['NAME']?></option>
		<?endforeach;?>
		</select>
	<?elseif (count($arResult['DELIVERY_SYSTEMS']) > 1 AND count($arResult['DELIVERY_SYSTEMS']) <= 6):?>
		<table cellpadding="1" cellspacing="0" width="100%" border="0">
		<?foreach ($arResult['DELIVERY_SYSTEMS'] as $delivery_system_id=>$delivery_system):?>
				<tr valign="top">
					<td width="1">
						<input type="radio" name="delivery_system" value="<?=$delivery_system_id?>" <?if($arResult['CURRENT']['DELIVERY_SYSTEM'] == $delivery_system_id):?>checked<?endif;?> onclick="order_form_reload()" />
					</td>
					<td width="100%">
						<div><strong><?=$delivery_system['NAME']?></strong></div>
						<?if ($delivery_system['DESCRIPTION']):?><div><?=$delivery_system['DESCRIPTION']?></div><?endif;?>
						<?if ($delivery_system['PRICE'] > 0):?><div>Стоимость доставки: <?=price($delivery_system['PRICE'], $delivery_system['CURRENCY'])?></div><?endif;?>
						<?if ($delivery_system['PERIOD_FROM'] OR $delivery_system['PERIOD_TO']):?><div>Сроки доставки: 
							<?if ($delivery_system['PERIOD_FROM'] >= 0):?>от <?=$delivery_system['PERIOD_FROM']?><?endif;?>
							<?if ($delivery_system['PERIOD_TO'] >= 0):?>до <?=$delivery_system['PERIOD_TO']?><?endif;?>
							<?switch ($delivery_system['PERIOD_TYPE']) {
								case "H": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "часа", "часов", "часов", false); break;
								case "M": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "месяца", "месяца", "месяцев", false); break;
								case "D": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "дня", "дней", "дней", false); break;
								default: echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "дня", "дней", "дней", false); break;
							}?>
							</div>
						<?endif;?>
					</td>
				</tr>
		<?endforeach;?>
		</table>
	<?elseif (count($arResult['DELIVERY_SYSTEMS']) == 1):?>
		<?list($delivery_id, $delivery_system) = each($arResult['DELIVERY_SYSTEMS']);?>
		<input type="hidden" name="delivery_system" value="<?=$delivery_id;?>" />
		<div><strong><?=$delivery_system['NAME']?></strong></div>
		<?if ($delivery_system['DESCRIPTION']):?><div><?=$delivery_system['DESCRIPTION']?></div><?endif;?>
		<?if ($delivery_system['PRICE'] > 0):?><div>Стоимость доставки: <?=price($delivery_system['PRICE'], $delivery_system['CURRENCY'])?></div><?endif;?>
		<?if (isset($delivery_system['PERIOD_FROM']) OR isset($delivery_system['PERIOD_TO'])):?><div>Сроки доставки: 
		<?if ($delivery_system['PERIOD_FROM'] >= 0):?>от <?=$delivery_system['PERIOD_FROM']?><?endif;?>
		<?if ($delivery_system['PERIOD_TO'] >= 0):?>до <?=$delivery_system['PERIOD_TO']?><?endif;?>
		<?switch ($delivery_system['PERIOD_TYPE']) {
			case "H": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "часа", "часов", "часов", false); break;
			case "M": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "месяца", "месяца", "месяцев", false); break;
			case "D": echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "дня", "дней", "дней", false); break;
			default: echo padej($delivery_system['PERIOD_TO']?$delivery_system['PERIOD_TO']:$delivery_system['PERIOD_FROM'], "дня", "дней", "дней", false); break;
		}?>
		</div>
		<?endif;?>
	<?else:?>
		<p>Для определения доступных методов доставки выберите город</p>
	<?endif;?>
<?endif;?>
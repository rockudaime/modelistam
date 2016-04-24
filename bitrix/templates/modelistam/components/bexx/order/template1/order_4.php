<h3>4 - Оплата</h3>

<?if (is_array($arResult['PAY_SYSTEMS'])):?>
	<?if (count($arResult['PAY_SYSTEMS']) > 5):?>
		<select name="pay_system" onchange="order_form_reload()">
		<?foreach ($arResult['PAY_SYSTEMS'] as $pay_system_id=>$pay_system):?>
			<option value="<?=$pay_system_id?>"<?if ($arResult['CURRENT']['PAY_SYSTEM'] == $pay_system_id):?> selected<?endif;?>>
				<?=$pay_system['NAME']?>
				<?if ($arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]>0):?>
					(+<?=$arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]?>%)
				<?endif;?>
			</option>
		<?endforeach;?>
		</select>
	<?elseif (count($arResult['PAY_SYSTEMS']) > 1 AND count($arResult['PAY_SYSTEMS']) <= 5):?>
		<table cellpadding="1" cellspacing="0" width="100%" border="0">
		<?foreach ($arResult['PAY_SYSTEMS'] as $pay_system_id=>$pay_system):?>
			<tr <?if ($pay_system['DESCRIPTION']):?> valign="top"<?endif;?>>
				<td width="1">
					<input type="radio" name="pay_system" value="<?=$pay_system_id?>" <?if($arResult['CURRENT']['PAY_SYSTEM'] == $pay_system_id):?>checked<?endif;?> onclick="order_form_reload()" />
				</td>
				<td width="100%">
					<div>
						<strong><?=$pay_system['NAME']?></strong>
						<?if ($arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]>0):?>
							(+<?=$arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]?>%)
						<?endif;?>
					</div>
					<?if ($pay_system['DESCRIPTION']):?><div><?=$pay_system['DESCRIPTION']?></div><?endif;?>
				</td>
			</tr>
		<?endforeach;?>
		</table>
	<?else:?> <!-- Один единственный способ оплаты -->
		<?$pay_system = reset($arResult['PAY_SYSTEMS'])?>
		<input type="hidden" name="pay_system" value="<?=$pay_system['ID'];?>" />
		<div>
			<strong><?=$pay_system['NAME']?></strong>
			<?if ($arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]>0):?>
				(+<?=$arResult['PS_SETTINGS'][$arResult['CURRENT']['CUSTOMER_TYPE']][$pay_system['ID']]?>%)
			<?endif;?>
		</div>
		<?if ($pay_system['DESCRIPTION']):?><div><?=$pay_system['DESCRIPTION']?></div><?endif;?>
	<?endif;?>
<?endif;?>

<?if ($arParams['ALLOW_ACCOUNT_PAY']=="Y" AND $arResult['TOTAL_SUM_ACCOUNT']>0):?>
<div>На вашем счете находится <strong><?=price($arResult['TOTAL_SUM_ACCOUNT'], $arResult['CURRENCY'])?></strong>. Вы можете использовать данную сумму для полной или частичной оплаты заказа.</div>
<table cellpadding="1" cellspacing="0" width="100%" border="0">
	<td nowrap>Сумма для списания:</td>
	<td><input type="text" size="10" maxlength="10" name="account_sum" value="<?=$_REQUEST['account_sum']?floatval($_REQUEST['account_sum']):(($arResult['TOTAL_PRICE']>$arResult['TOTAL_SUM_ACCOUNT'])?$arResult['TOTAL_SUM_ACCOUNT']:$arResult['TOTAL_PRICE'])?>" /></td>
	<td width="100%" nowrap>
		<!--<input type="button" value="ok" onclick="order_form_reload(); return false;" />-->
	</td>
</table>
<br />
<?endif;?>

<?if ($arParams['ALLOW_COUPONS'] == "Y"):?>
<p>Если у вас есть купон скидок, введите его код здесь. Стоимость заказа будет уменьшена на сумму купона.</p>
<table cellpadding="1" cellspacing="0" width="100%" border="0">
	<td nowrap>Купон скидок:</td>
	<td><input type="text" size="30" maxlength="50" name="coupon" value="<?=$arResult['CURRENT']['COUPON']?>" /></td>
	<td width="100%" nowrap>
		<input type="button" value="ok" onclick="order_form_reload(); return false;" />
	</td>
</table>
<?endif;?>
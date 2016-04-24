<h3>1 - Плательщик</h3>
<?if ($USER->IsAuthorized()):?>
	<?if ($USER->GetLogin()):?><p>Ваш логин: <strong><?=$USER->GetLogin()?></strong></p><?endif;?>
	<?if ($arResult['USER_INFO']['NAME'] OR $arResult['USER_INFO']['LAST_NAME'] OR $arResult['USER_INFO']['SECOND_NAME']):?><p>Ваше имя: <strong>
		<?
		$name_parts = array();
		if ($arResult['USER_INFO']['NAME']) $name_parts[] = $arResult['USER_INFO']['NAME'];
		if ($arResult['USER_INFO']['SECOND_NAME']) $name_parts[] = $arResult['USER_INFO']['SECOND_NAME'];
		if ($arResult['USER_INFO']['LAST_NAME']) $name_parts[] = $arResult['USER_INFO']['LAST_NAME'];
		echo implode(" ", $name_parts);
		?>
	</strong></p><?endif;?>
	<?if ($USER->GetEmail()):?><p>Ваш e-mail: <?=$USER->GetEmail()?></p><?endif;?>
	<?if ($arResult['USER_INFO']['PERSONAL_PHONE']):?><p>Ваш телефон: <?=$arResult['USER_INFO']['PERSONAL_PHONE']?></p><?endif;?>
	<?if ($arResult['USER_INFO']['PERSONAL_STREET'] OR $arResult['USER_INFO']['PERSONAL_CITY'] OR $arResult['USER_INFO']['PERSONAL_STATE'] OR $arResult['USER_INFO']['PERSONAL_ZIP']):?>
		<p>Ваш адрес: 
			<?$address_parts = array();
			if ($arResult['USER_INFO']['PERSONAL_ZIP']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_ZIP'];
			if ($arResult['USER_INFO']['PERSONAL_STATE']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_STATE'];
			if ($arResult['USER_INFO']['PERSONAL_CITY']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_CITY'];
			if ($arResult['USER_INFO']['PERSONAL_STREET']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_STREET'];
			echo implode(", ", $address_parts);
			?>
		</p>
	<?endif;?>
<?else:?>
	<input type="hidden" name="registration_needed" value="1" />
	<table cellpadding="1" cellspacing="0" width="100%" border="0">
		<tr>
			<td nowrap align="right">Имя: <span class="required">*</span></td>
			<td width="100%"><input type="text" name="user[name]" size="30" maxlength="255" value="<?=get_order_param("user_name")?>" /></td>
		</tr>
		<tr>
			<td nowrap align="right">Фамилия: <span class="required">*</span></td>
			<td width="100%"><input type="text" name="user[name2]" size="30" maxlength="255" value="<?=get_order_param("user_name2")?>" /></td>
		</tr>
		<tr>
			<td nowrap align="right">E-mail: <span class="required">*</span></td>
			<td width="100%"><input type="text" name="user[email]" size="30" maxlength="255" value="<?=get_order_param("user_email")?>" /></td>
		</tr>
	</table>
	<p>Для вас будет произведена автоматическая регистрация, на e-mail будут высланы логин и пароль для доступа на сайт и отслеживания своих заказов</p>
<?endif;?>
<?if (is_array($arResult['CUSTOMER_TYPES']) AND $arResult['CUSTOMER_TYPES']):?>
	<?if (count($arResult['CUSTOMER_TYPES']) > 3):?>
		<select name="customer_type" onchange="order_form_reload()">
		<?foreach ($arResult['CUSTOMER_TYPES'] as $customer_type_id=>$customer_type_name):?>
			<option value="<?=$customer_type_id?>"<?if ($arResult['CURRENT']['CUSTOMER_TYPE'] == $customer_type_id):?> selected<?endif;?>><?=$customer_type_name?></option>
		<?endforeach;?>
		</select>
	<?elseif (count($arResult['CUSTOMER_TYPES']) > 1 AND count($arResult['CUSTOMER_TYPES']) <= 3):?>
		<table cellpadding="1" cellspacing="0" width="100%" border="0">
		<?if (is_array($arResult['CUSTOMER_TYPES'])):?>
			<?foreach ($arResult['CUSTOMER_TYPES'] as $customer_type_id=>$customer_type_name):?>
				<tr><td width="1">
					<input type="radio" name="customer_type" value="<?=$customer_type_id?>" <?if($arResult['CURRENT']['CUSTOMER_TYPE'] == $customer_type_id):?>checked<?endif;?> onclick="order_form_reload()" />
				</td><td width="100%"><?=$customer_type_name?></td></tr>
			<?endforeach;?>
		<?endif;?>
		</table>
	<?else:?>
		<input type="hidden" name="customer_type" value="<?=reset(array_keys($arResult['CUSTOMER_TYPES']));?>" />
		<div><strong><?=reset(array_values($arResult['CUSTOMER_TYPES']))?></strong></div>
	<?endif;?>
<?endif;?>
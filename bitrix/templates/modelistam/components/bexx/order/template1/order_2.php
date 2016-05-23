<?/*
<div class="order-block__title">Реквизиты</div>
*/?>


<?//PM-10?>
<input type="hidden" name="customer_type" value="1">
<input type="hidden" name="delivery_system" value="1">
<input type="hidden" name="pay_system" value="1">
<?//PM-10?>

<?if (is_array($arResult['PROFILES'])):?>
    <?if (count($arResult['PROFILES']) AND $USER->IsAuthorized()):?>
        <table class="page-order__table">
            <tr>
                <td><span>Адресная книга:</span></td>
                <td>
                    <div class="page-order__table-content">
                        <select name="profile" onchange="order_form_reload()">
                            <option value="0">Новый адрес</option>
                            <?foreach ($arResult['PROFILES'] as $profile):?>
                                <option value="<?=$profile['ID']?>" <?if ($arResult['CURRENT']['PROFILE'] == $profile['ID']):?> selected<?endif;?>><?=$profile['NAME']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </td>
            </tr>
        </table>
    <?endif;?>
<?endif;?>

<?if (is_array($arResult['ORDER_PROPERTIES_GROUPS'])):?>
	<?if (count($arResult['ORDER_PROPERTIES_GROUPS'])):?>
		<table class="page-order__table">
            <tbody>
                <?foreach ($arResult['ORDER_PROPERTIES_GROUPS'] as $prop_group_id=>$prop_group_name):?>
                    <?if (count($arResult['ORDER_PROPERTIES'][$prop_group_id])):?>

                        <?/*
                        <tr>
                            <td colspan="2">
                                <div class="order_prop_group_name"><?=$prop_group_name?></div>
                            </td>
                        </tr>
                        */?>
                        <tr>
                            <td colspan="2">
                                <?//PM-10?>
                                <?if ($prop_group_id == 1):?>
                                    <?if ($USER->IsAuthorized()):?>
                                        <table  class="page-order__table">
                                            <tbody>
                                                <?if ($USER->GetLogin()):?>
                                                    <tr>
                                                        <td>Ваш логин: </td>
                                                        <td><strong><?=$USER->GetLogin()?></strong></td>
                                                    </tr>
                                                <?endif;?>

                                                <?if ($USER->GetEmail()):?>
                                                    <tr>
                                                        <td>Ваш email: </td>
                                                        <td><strong><?=$USER->GetEmail()?></strong></td>
                                                    </tr>
                                                <?endif;?>

                                                <?if ($arResult['USER_INFO']['PERSONAL_PHONE']):?>
                                                    <tr>
                                                        <td>Ваш телефон:</td>
                                                        <td><strong><?=$arResult['USER_INFO']['PERSONAL_PHONE']?></strong></td>
                                                    </tr>
                                                <?endif;?>

                                                <?if ($arResult['USER_INFO']['PERSONAL_STREET'] OR $arResult['USER_INFO']['PERSONAL_CITY'] OR $arResult['USER_INFO']['PERSONAL_STATE'] OR $arResult['USER_INFO']['PERSONAL_ZIP']):?>
                                                    <tr>
                                                        <td>Ваш адрес:</td>
                                                        <td>
                                                            <?$address_parts = array();
                                                            if ($arResult['USER_INFO']['PERSONAL_ZIP']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_ZIP'];
                                                            if ($arResult['USER_INFO']['PERSONAL_STATE']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_STATE'];
                                                            if ($arResult['USER_INFO']['PERSONAL_CITY']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_CITY'];
                                                            if ($arResult['USER_INFO']['PERSONAL_STREET']) $address_parts[] = $arResult['USER_INFO']['PERSONAL_STREET'];
                                                            echo implode(", ", $address_parts);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?endif;?>
                                            </tbody>
                                        </table>
                                    <?else:?>
                                        <table  class="page-order__table">
                                            <tbody>
                                                <tr>
                                                    <?
                                                    /*
                                                    <td style="border-top: 0;">Имя:<span class="required">*</span></td>
                                                     <td class="no-borders"><input type="text" name="user[name]" size="30" maxlength="255" value="<?=get_order_param("user_name")?>" /></td>
                                                    */
                                                    ?>
                                                    <td>
                                                        <input type="hidden" name="registration_needed" value="1" />
                                                        <input type="hidden" name="user[name1]" value="<?=get_order_param("user_name")?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>E-mail: <span class="required">*</span></td>
                                                    <td class="no-borders">
                                                        <input type="text" class="ui-grey-input" name="user[email]" size="30" maxlength="255" value="<?=get_order_param("user_email")?>" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?endif;?>
                                <?endif;?>
                                <?//PM-10?>
                            </td>
                        </tr>

                        <?foreach ($arResult['ORDER_PROPERTIES'][$prop_group_id] as $prop_id=>$prop):?>

                            <?if ($prop_id == "EMAIL"):?>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$arResult[USER_INFO][EMAIL]?>">
                                    </td>
                                </tr>
                                <?continue;?>
                            <?endif;?>

                            <?if ($prop_id == "ZIP") continue;?>

                            <tr <?if ($arResult['ERRORS']['prop_'.$prop['ID']]):?> class="prop_error"<?endif;?>>
                                <td <?if (in_array($prop['TYPE'], array("TEXTAREA", "LOCATION", "RADIO", "MULTISELECT"))):?> valign="top"<?endif;?>>
                                    <?=$prop['NAME']?>
                                    <?if ($prop['REQUIED'] == "Y"):?>
                                        <span class="required">*</span>
                                    <?endif;?>
                                </td>
                                <td>
                                    <?
                                    $value = $arResult['CURRENT']['PROPS'][$prop['ID']]?$arResult['CURRENT']['PROPS'][$prop['ID']]:($arParams['AJAX_ENABLED'] != "Y"?$prop['DEFAULT_VALUE']:"");
                                    ?>

                                    <?if ($prop['TYPE'] == "TEXT"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?=$value?>
                                        <?else:?>
                                            <input class="order-addr-input ui-grey-input" type="text" name="prop[<?=$prop['ID']?>]" value="<?=$value?>" size="30" />
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "TEXTAREA"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?=$value?>
                                        <?else:?>
                                            <textarea class="ui-grey-input" name="prop[<?=$prop['ID']?>]" cols="<?=$prop['SIZE1']?$prop['SIZE1']:30?>" rows="<?=$prop['SIZE2']?$prop['SIZE2']:3?>"><?=$value?></textarea>
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "CHECKBOX"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?if ($value == "Y"):?>Да<?else:?>Нет<?endif;?>
                                        <?else:?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="N" />
                                            <input type="checkbox" name="prop[<?=$prop['ID']?>]" value="Y" <?if ($value):?> checked<?endif;?> />
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "SELECT"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?foreach ($prop['VARIANTS'] as $variant):?>
                                                <?if ($value == $variant['VALUE']):?><?=$variant['NAME']?><?endif;?>
                                            <?endforeach;?>
                                        <?else:?>
                                            <?if (count($prop['VARIANTS'])):?>
                                                <select name="prop[<?=$prop['ID']?>]" <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>readonly<?endif;?>>
                                                    <option value="0">-- Выберите --</option>
                                                    <?foreach ($prop['VARIANTS'] as $variant):?>
                                                        <option value="<?=$variant['VALUE']?>" <?if ($value == $variant['VALUE']):?> selected<?endif;?>><?=$variant['NAME']?></option>
                                                    <?endforeach;?>
                                                </select>
                                            <?endif;?>
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "MULTISELECT"):?>
                                        <?if (!is_array($value)) $value = explode(",", $value);?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <?$values = array();?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=implode(",", $value)?>">
                                            <?foreach ($prop['VARIANTS'] as $variant):?>
                                                <?
                                                if (in_array($variant['VALUE'], $value)) {
                                                    $values[] = $variant['NAME'];
                                                }
                                                ?>
                                            <?endforeach;?>
                                            <?=implode(", ", $values)?>
                                        <?else:?>
                                            <?if (count($prop['VARIANTS'])):?>
                                                <?if ($prop['SIZE1'] > 0) {
                                                    if (count($prop['VARIANTS']) <= $prop['SIZE1']) $rows = count($prop['VARIANTS']);
                                                } else {
                                                    if (count($prop['VARIANTS']) <= 5) $rows = 5;
                                                }
                                                if (!is_array($value)) $value = array($value);
                                                ?>
                                                <input type="hidden" name="prop[<?=$prop['ID']?>]" value="0" />
                                                <select name="prop[<?=$prop['ID']?>][]" multiple size="<?=$rows?>" <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>readonly<?endif;?>>
                                                    <?foreach ($prop['VARIANTS'] as $variant):?>
                                                        <option value="<?=$variant['VALUE']?>" <?if (in_array($variant['VALUE'], $value)):?> selected<?endif;?>><?=$variant['NAME']?></option>
                                                    <?endforeach;?>
                                                </select>
                                            <?endif;?>
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "RADIO"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?foreach ($prop['VARIANTS'] as $variant):?>
                                                <?if ($value == $variant['VALUE']):?>
                                                    <div><?=$variant['NAME']?></div>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?else:?>
                                            <?if (count($prop['VARIANTS'])):?>
                                                <table width="100%">
                                                    <?foreach ($prop['VARIANTS'] as $variant):?>
                                                        <tr <?if ($variant['DESCRIPTION']):?> valign="top"<?endif;?>>
                                                            <td><input type="radio" name="prop[<?=$prop['ID']?>]" value="<?=$variant['VALUE']?>" <?if ($value == $variant['VALUE']):?> checked<?endif;?> <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>readonly<?endif;?> /></td>
                                                            <td width="100%">
                                                                <?if ($variant['DESCRIPTION']):?>
                                                                    <div><strong><?=$variant['NAME']?></strong></div>
                                                                    <div><?=$variant['DESCRIPTION']?></div>
                                                                <?else:?>
                                                                    <div><?=$variant['NAME']?></div>
                                                                <?endif;?>
                                                            </td>
                                                        </tr>
                                                    <?endforeach;?>
                                                </table>
                                            <?endif;?>
                                        <?endif;?>
                                    <?elseif ($prop['TYPE'] == "LOCATION"):?>
                                        <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>
                                            <input type="hidden" name="prop[<?=$prop['ID']?>]" value="<?=$value?>">
                                            <?=$prop['CITIES'][$value]?>
                                        <?else:?>
                                            <?if (count($prop['CITIES'])):?>
                                                <select name="prop[<?=$prop['ID']?>]" onchange="order_form_reload()" <?if ($prop['USER_PROPS'] == "Y" AND $arResult['CURRENT']['PROFILE'] > 0):?>disabled<?endif;?>>
                                                    <option value="0">-- Выберите регион (или обл.) --</option>
                                                    <?foreach ($prop['CITIES'] as $city_id=>$city_name):?>
                                                        <option value="<?=$city_id?>" <?if ($value == $city_id):?> selected<?endif;?>><?=$city_name?></option>
                                                    <?endforeach;?>
                                                </select>
                                            <?endif;?>
                                        <?endif;?>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?endforeach;?>
                    <?endif;?>
                <?endforeach;?>
            </tbody>
		</table>

        <table class="page-order__table">
            <tbody>
                <tr>
                    <td>Комментарий к заказу:</td>
                    <td>
                        <textarea class="ui-grey-input" cols="30" rows="3" name="order_comments"><?isset($_POST['order_comments'])?strip_tags($_POST['order_comments']):""?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <?if (!$arResult['CURRENT']['PROFILE']):?>
            <table class="page-order__table">
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="save_address" value="0" />
                            <input type="checkbox" name="save_address" value="1" <?if ($arResult['CURRENT']['SAVE_ADDRESS']):?>checked<?endif;?> />
                            <span>Сохранить в адресной книге</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?endif;?>

	<?else:?>
		<?=ShowError("Нет свойств заказа для данного типа плательшиков");?>
	<?endif;?>
<?endif;?>

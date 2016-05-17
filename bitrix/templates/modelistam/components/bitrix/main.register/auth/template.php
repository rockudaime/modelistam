<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
?>
<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<script type="text/javascript">
    var regPopup = {
        init: function() {
            var regPopupLink = $('#top-register-link');
            var regBlock = $('.registration-block');

            regBlock.hide();

            regPopupLink.on('click', function(e) {
                e.preventDefault();
                $.fancybox(regBlock);
            })
        },
        addPlaceholders: function() {
            var container = $('.registration-block');
            var inputName = container.find("input[name='REGISTER[NAME]']");
            var inputEmail = container.find("input[name='REGISTER[EMAIL]']");
            var inputPhone = container.find("input[name='REGISTER[PERSONAL_PHONE]']");

            inputName.attr('placeholder', 'Анатолий');
            inputEmail.attr('placeholder', 'Anatol@mail.ru');
            inputPhone.attr('placeholder', '0 (057) 11 11 111');
        }
    }
    $(function() {
        regPopup.init();
        regPopup.addPlaceholders();
    });
</script>

<div class="bx-auth-reg">
    <?if($USER->IsAuthorized()):?>
    <p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>
    <?else:?>
        <?
        if (count($arResult["ERRORS"]) > 0):
            foreach ($arResult["ERRORS"] as $key => $error)
                if (intval($key) == 0 && $key !== 0)
                    $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

            ShowError(implode("<br />", $arResult["ERRORS"]));

        elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
            ?>
            <p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
        <?endif?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
            <?
            if($arResult["BACKURL"] <> ''):
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            endif;
            ?>
           <div class="registration__title">
                РЕГИСТРАЦИЯ НОВОГО ПОКУПАТЕЛЯ
            </div>
               <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
                    <?//BSP-36?>
                    <?if($FIELD == "LOGIN"):?>
                        <input type="hidden" name="REGISTER[<?=$FIELD?>]" value="<?=RandString(20)?>" />
                        <?Continue;?>
                    <?endif?>
                    <?//BSP-36?>

            <?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
                        <div class="registration__entity">
                            <label><?echo GetMessage("main_profile_time_zones_auto")?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?></label>
                            <select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
                                <option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
                                <option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
                                <option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
                            </select>
                        </div>

                        <div class="registration__entity">
                            <label><?echo GetMessage("main_profile_time_zones_zones")?></label>
                            <select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
                                <?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
                                    <option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
                                <?endforeach?>
                            </select>
                        </div>
                    <?else:?>
                        <div class="registration__entity">
                            <label><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?></label>
                            <?
                                switch ($FIELD)
                                {
                                    case "PASSWORD":
                                        ?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="bx-auth-input inputtext" required/>
                                        <?if($arResult["SECURE_AUTH"]):?>
                                        <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
            <noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
            </noscript>
            <script type="text/javascript">
                document.getElementById('bx_auth_secure').style.display = 'inline-block';
            </script>
            <?endif?>
                <? break;
                    case "CONFIRM_PASSWORD": ?>
                <input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" required/><?break;
                                    case "PERSONAL_GENDER":?>
                <select name="REGISTER[<?=$FIELD?>]">
                    <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                    <option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                    <option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                </select><?break; 
                case "PERSONAL_COUNTRY":
                case "WORK_COUNTRY":?>
                <select name="REGISTER[<?=$FIELD?>]">
                <?foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value) { ?>
                    <option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
                <? } ?>
                </select><? break;
                            case "PERSONAL_PHOTO":
                            case "WORK_LOGO":?>
                    <input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" />
                    <?break;
                    case "PERSONAL_NOTES":
                    case "WORK_NOTES":?>
                    <textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea>
                    <?break;
                    default:
                        if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br />
                        <?endif;?>
                    <input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
                    <? if ($FIELD == "PERSONAL_BIRTHDAY")
                        $APPLICATION->IncludeComponent(
                                'bitrix:main.calendar',
                                '',
                                array(
                                    'SHOW_INPUT' => 'N',
                                    'FORM_NAME' => 'regform',
                                    'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                    'SHOW_TIME' => 'N'
                                ),
                                null,
                                array("HIDE_ICONS"=>"Y")
                        );
                    }?>
            </div>
        <?endif?>
    <?endforeach?>

<?// ********************* User properties ***************************************************?>

    <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
        <div class="registration__entity">
            <label><?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></label>
        </div>

        <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
        <div class="registration__entity">
            <label><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?></label>
            <?$APPLICATION->IncludeComponent(
                "bitrix:system.field.edit",
                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
        </div>
        <?endforeach;?>
    <?endif;?>

<?// ******************** /User properties ***************************************************?>

    <div style="margin: 20px 0; color: #333333;">Регистрируясь, вы соглашаетесь с <a href="/about/dir_rules/">пользовательским соглашением</a></div>
    <div class="registration__entity registration__entity--submit">
        <input type="submit" name="register_submit_button" class="butt3 butt3--big" value="Зарегистрироваться" />
    </div>
</form>
<?endif?>
</div>

<?
//PST-9
$frame->end();
//PST-9
?>
<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	ShowNote($arResult["OK_MESSAGE"]);
}
?>

<form action="" method="POST">
<?=bitrix_sessid_post()?>
<div class="content-form feedback-form">

	<div class="fields">


        <div class="field-entity">
            <div class="field-title"><?=GetMessage("MFT_NAME")?></div>
            <div class="form-input"><input type="text" size="30" class="ui-grey-input author_name" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>"></div>
        </div>

        <div class="field-entity">
            <div class="field-title"><?=GetMessage("MFT_EMAIL")?></div>
            <div class="form-input"><input type="text" size="30" class="author_email ui-grey-input" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>"></div>
        </div>

		<div class="field-entity">
			<div class="field-title"><?=GetMessage("MFT_MESSAGE")?></div>
			<div class="form-input"><textarea class="ui-grey-input" name="MESSAGE" rows="3" cols="33"><?=$arResult["MESSAGE"]?></textarea></div>
		</div>
	
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="field-entity field-captcha">
            <p style="margin: 0 0 4px;"><?=GetMessage("MFT_CAPTCHA_CODE")?></p>
            <div class="form-input">
                <div style="margin: 0 0 4px;">
                    <input type="text" name="captcha_word" class="ui-grey-input ui-grey-input--captcha" size="30" maxlength="50" value="">
                </div>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
            </div>
		</div>
		<?endif;?>
	
		<div class="field-entity field-submit">
            <div class="form-input">
			    <input type="submit" class="input-submit butt1" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
		    </div>
        </div>
	</div>
</div>	
</form>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe-form-inner">
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<input type="text" class="input-text" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" />
		<input class="submit" type="submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" />
	</form>
</div>

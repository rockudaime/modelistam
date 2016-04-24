<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
//$this->setFrameMode(false);
$frame = $this->createFrame()->begin('Загрузка ...');
//PST-9
?>

<script type="text/javascript">
    BIS.authPopup = {
        init: function() {
            var authPopupLink = $('#top-login-link');
            var authBlock = $('.auth-block');

            authBlock.hide();
            this.addPopupHandler(authPopupLink, authBlock);
        },
        addPopupHandler: function(link, block) {
            link.on('click', function(e) {
                e.preventDefault();
                $.fancybox(block);
            })
        },
        triggerPopup: function() {
            var authPopupLink = $('#top-login-link');

            authPopupLink.trigger('click');
        }
    }

    $(function() {
        BIS.authPopup.init();
    });
</script>

<div class="bx-system-auth-form">
<?if($arResult["FORM_TYPE"] == "login"):?>

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']):?>
    <script type="text/javascript">
        $(function() {
            BIS.authPopup.triggerPopup();
        })
    </script>
	<? ShowMessage($arResult['ERROR_MESSAGE']);	?>
<?endif;?>


<div class="auth-page">
	<div class="auth-inner">

		<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?if($arResult["BACKURL"] <> ''):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" >

            <div class="auth__title">Вход в личный кабинет</div>

            <div class="auth-page__entity">
                <label>E-mail:</label>
                <input type="text" name="USER_LOGIN" autocomplete="off" maxlength="50" size="20" value="<?echo htmlspecialchars($last_login)?>" class="inputtext" />
            </div>

            <div class="auth-page__entity">
                <label>Пароль:</label>
                <input type="password" name="USER_PASSWORD" autocomplete="off" maxlength="50" class="inputtext" size="20" />
            </div>

            <div class="auth-page__entity">
                <?if (COption::GetOptionString("main", "store_password", "Y")=="Y") :?>
                    <span class="auth-page__entity-remember"><input type="checkbox" name="USER_REMEMBER" value="Y" class="inputcheckbox">&nbsp;Запомнить меня</span>
                <?endif;?>
            </div>


            <div class="auth-page__entity-submit">
                <a class="auth-page__register-link" href="<?=$arParams['REGISTER_URL']?>">Регистрация</a>
                <a class="auth-page__link-forgot" href="<?=$arParams['FORGOT_PASSWORD_URL']?>">Забыли пароль?</a>
            </div>
            <input type="submit" name="Login" value="Войти" class="butt1">


		</form>
	</div>
</div>


<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
		"POPUP"=>"Y",
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<?/*
<form action="<?=$arResult["AUTH_URL"]?>">
	<table width="95%">
		<tr>
			<td align="center">
				<?=$arResult["USER_NAME"]?><br />
				[<?=$arResult["USER_LOGIN"]?>]<br />
				<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a><br />
			</td>
		</tr>
		<tr>
			<td align="center">
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
			</td>
		</tr>
	</table>
</form>
*/?>

<?endif?>
</div>

<?
//PST-9
$frame->end();
//PST-9
?>
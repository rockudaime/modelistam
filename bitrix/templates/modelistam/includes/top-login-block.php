<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_auth");?>
<span id="dynamic_auth">
<?//PST-9?>

<div class="toppest-menu">
	<?if  (!$USER->IsAuthorized()):?>
	
	<ul class="login-block-ok">
		<li class="login-icon"><a id="top-login-link" href="/login"><b></b>
		<span class="login-text_full">Войти в личный кабинет<span></span></span>
		<span class="login-text_sm">В кабинет<span></span></span>
		</a></li>
		<!--<li><a id="top-register-link" href="/personal/registration.php">Регистрация</a></li>-->
		<!--<li><a href="">Выйти?</a></li>-->
	</ul>
	

		

	<?endif;?>
	<?if ($USER->IsAuthorized()):?>


	<ul class="login-block-ok">
		<li class="login-icon">
			<a href="/personal/">
				<b></b>
				<span class="login-text_full">Личный кабинет<span></span></span>
				<span class="login-text_sm">В кабинет<span></span></span>
			</a>
		</li>
		
		<!--<li><a href="<?//=$APPLICATION->GetCurPageParam("logout=yes", array(), false)?>">Выйти?</a></li>-->
	</ul>


	<?endif;?>
    <script type="text/javascript">
        var toppestObj = {
            init: function() {
                var pull = $('#pull-login-block');
                var container = $('.toppest-menu');

                if (pull.length) {
                    pull.on('click', function() {
                        if ($(this).hasClass('active')) {
                            container.slideUp('fast');
                            $(this).removeClass('active');
                        } else {
                            container.slideDown('fast');
                            $(this).addClass('active');
                        }
                    })
                }
            }
        }
        $(function() {
            toppestObj.init();
        })
    </script>
</div>

<?if (!$USER->IsAuthorized()):?>
    <div class="auth-block">
        <?$APPLICATION->IncludeComponent(
        "bitrix:system.auth.form",
        "auth_custom",
        Array(
            "REGISTER_URL" => "/personal/registration.php",
            "FORGOT_PASSWORD_URL" => "/login/?forgot_password=yes",
            "PROFILE_URL" => "",
            "SHOW_ERRORS" => "Y"
        )
        );
        ?>
    </div>

<?endif;?>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_auth", "");?>
<?//PST-9?>
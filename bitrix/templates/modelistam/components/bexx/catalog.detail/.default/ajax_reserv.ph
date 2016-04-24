<?//PST-7?>

<div class="reserv">
    <?if ($arResult['ITEM']):?>
        <div class="reserv__title">РЕЗЕРВИРОВАНИЕ ТОВАРА</div>

        <div class="reserv__wrap">
            <form id="reserv_click_form" method="post" action="#">
                <input type="hidden" name="id" value="<?=$arResult['ITEM']['ID']?>" />

                <div class="reserv__bottom">
                    <div class="reserv__bottom__text">
                        Вы можете указать свой e-mail для того, чтобы мы зарезервировали для вас<br/>
                        этот товар, если он появится.
                    </div>
                </div>

                <div class="reserv__inner">
                    <div class="reserv__name-block">
                        <span class="reserv__name">Ваше имя:</span>
                        <input class="reserv__name-input" type="text" name="name" value="<?=$_POST['name']?>" id="reserv_name" />
                    </div>

                    <div class="reserv__phone-block">
                        <span class="reserv__name">Телефон: </span>
                        <input class="reserv__phone-input" type="text" placeholder="+ 38 (093) 12 - 34 - 567" name="phone" value="<?=htmlspecialchars(strip_tags($_POST['phone']))?>" id="reserv_phone" />
                    </div>

                    <div class="reserv__email-block">
                        <span class="reserv__name">E-mail: <span class="required">*</span></span>
                        <input class="reserv__email-input" type="text" name="email" value="<?=$_POST['email']?>" id="reserv_email" />
                    </div>
                    <div class="reserv__button-block">
                        <a href="#" id="reserv-button" class="butt1 reserv__button">Зарезервировать</a>
                    </div>
                </div>


            </form>
        </div>

        <script type="text/javascript">
            $(function(){
                $('#reserv-button').click(function(){
                    if (!$('#reserv_email').val()) {
                        alert('Укажите email');
                    } else {
                         $('#reserv_click_form').append('<input type="hidden" name="do" value="reserv_send">');

                        ajax_load('#reserv', '<?=$arResult['AJAX_CALL_ID']?>', $('#reserv_click_form').serializeArray());
                    }
                    return false;
                });
            });
        </script>

        <?
        if (is_array($arResult['ERRORS']) AND !empty($arResult['ERRORS'])) {
            echo ShowError(implode("<br />", $arResult['ERRORS']));
        }
        ?>
	<?endif;?>
</div>
<?//PST-7?>
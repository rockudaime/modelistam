<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<div class="feedback__title">Обратный звонок</div>

<div class="mfeedback">
    <?if(!empty($arResult["ERROR_MESSAGE"]))
    {
        foreach($arResult["ERROR_MESSAGE"] as $v)
            ShowError($v);
    }
    ?>

    <?
    if(!empty($arResult["ERROR_MESSAGE"]))
    {
    ?>
    <script type="text/javascript">
        $(function() {
            $('.cb-wrapper').show();
            $('.callback-block').fadeIn(800);
        });
    </script>
    <?
    }
    ?>

    <?
    if(strlen($arResult["OK_MESSAGE"]) > 0)
    {
    ?>
    <div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div>
    <script type="text/javascript">
        $(function() {
            var formCB = $('.callback-block');
            $('.cb-wrapper').show();
            formCB.show();
        });
    </script>
    <?
    }
    ?>

    <form action="<?=$APPLICATION->GetCurPage()?>" method="POST">
    <?=bitrix_sessid_post()?>

            <div class="callback__entity">
                <label>Ваше имя: <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></label>
                <input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
            </div>

            <?php
             /*
            <tr>
                <td><div class="wrapCB">Ваш email<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></div></td>
                <td><input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>"></td>
            </tr>
            */
            ?>

            <?php /* GT-49 */ ?>
            <div class="callback__entity">
                <label>Телефон: <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("FEEDBACKPHONE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></label>
                <input type="text" name="user_feedbackphone" value="<?=$arResult["AUTHOR_FEEDBACKPHONE"]?>">
            </div>
            <?php /* GT-49 */ ?>

            <?/*
            <div class="callback__entity">
                <label>Комментарий: <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></label>
                <textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
            </div>
            */?>

        <?if($arParams["USE_CAPTCHA"] == "Y"):?>
             <div class="callback__entity">
                <label><?=GetMessage("MFT_CAPTCHA")?>: </label>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
            </div>

            <div class="callback__entity">
                <label><?=GetMessage("MFT_CAPTCHA_CODE")?>:<span class="mf-req">*</span></label>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="">
            </div>
        <?endif;?>

        <div class="callback__entity">
            <input class="callback__submit" type="submit" name="submit" value="Заказать звонок">
        </div>
    </form>
</div>

<script type="text/javascript">
    var callBackUI = {
        init: function() {
            var linkCB = $('#callback-link'),
                formCB = $('.callback-block'),
                closeCB = $('.closeCB'),
                wrapCB = $('.cb-wrapper');
                additionalLinks = $('#footer').find('.contacts-callback');

            var togglerCB = function() {
                formCB.toggle();
                wrapCB.toggle();
            };


            linkCB.on('click', function() {
                togglerCB();
                linkCB.toggleClass('active-link');
            });
            closeCB.on('click', function() {
                togglerCB();
                linkCB.removeClass('active-link');
            });
            wrapCB.on('click', function() {
                togglerCB();
                linkCB.removeClass('active-link');
            });

            if (additionalLinks.length) {
                additionalLinks.on('click', function() {
                    linkCB.trigger('click');
                })
            }
        }
    }
    $(function() {
        callBackUI.init();
    });
</script>
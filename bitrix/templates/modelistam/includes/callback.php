<div class="callback-block">
    <div class="closeCB"></div>
    <?$APPLICATION->IncludeComponent("bitrix:main.feedback", "template2", array(
        "USE_CAPTCHA" => "Y",
        "OK_TEXT" => "Спасибо, ваша заявка принята.",
        "EMAIL_TO" => "info@modelistam.com.ua",
        "REQUIRED_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "EVENT_MESSAGE_ID" => array(
            0 => "7",
        )
    ),
    false
    );?>
</div>
<div class="cb-wrapper"></div>
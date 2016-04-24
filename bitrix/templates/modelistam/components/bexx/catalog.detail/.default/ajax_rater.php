<?php
if ($arResult['ERROR_MSG']):?>
    <?=$arResult['ERROR_MSG']?>
    <script>
        $('.rating-result_<?=$arResult['ITEM_ID']?>').addClass("orange").removeClass("green");
    </script>
<?else:?>
    Спасибо за оценку
    <script>
        $('.rating-result_<?=$arResult['ITEM_ID']?>').addClass("green").removeClass("orange");
    </script>
<?endif;?>

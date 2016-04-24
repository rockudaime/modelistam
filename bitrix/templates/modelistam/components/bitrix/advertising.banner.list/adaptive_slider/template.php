<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?if ($arResult['BANNERS']):?>
 <script type="text/javascript">
    $(function() {
        $('#flexslider-<?=$arParams['CODE'];?>').flexslider({
            animation: "slide",
            slideshow: <?=($arParams["SLIDESHOW"]=="Y")?"true":"false"?>,
            pauseOnHover: true,
            touch: true,
            directionNav:false,
            slideshowSpeed: <?=$arParams['ANIMATION_DURATION']?>,
            animationSpeed: <?=$arParams['ANIMATION_SPEED']?>
        });
    });
</script>

<?
    $currentTime = time();
    $totalActiveBanners = count($arResult['BANNERS']);
?>

<div id="flexslider-<?=$arParams['CODE'];?>" class="flexslider">

    <ul class="slides">
        <?foreach ($arResult['BANNERS'] as $item):?>

            <?
            if ($item['DATE_SHOW_FROM'] != '') {
                if (strtotime($item['DATE_SHOW_FROM']) > $currentTime) {
                    if ($totalActiveBanners > 0) {
                        $totalActiveBanners--;
                    };
                    continue;
                }
            }

            if ($item['DATE_SHOW_TO'] != '') {
                if (strtotime($item['DATE_SHOW_TO']) <= $currentTime) {
                    if ($totalActiveBanners > 0) {
                        $totalActiveBanners--;
                    };
                    continue;
                }
            }

            if ($item['ACTIVE'] == 'N') {
                if ($totalActiveBanners > 0) {
                    $totalActiveBanners--;
                };
                continue;
            }

            ?>
            <li>
                <a target="<?=$item['URL_TARGET']?>" href="<?=$item['URL'];?>">
                    <img alt="<?=$item['NAME']; ?>" title="<?=$item['NAME'];?>" src="<?=$item['IMAGE_URL'];?>"  />
                </a>
            </li>
        <?endforeach;?>
    </ul>
</div>

<?endif;?>











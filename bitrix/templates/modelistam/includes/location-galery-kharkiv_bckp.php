<?
CModule::IncludeModule("fileman");
CMedialib::Init();

//Получения списка всех коллекций
$arColl =CMedialibCollection::GetList(array('arFilter' => array('ACTIVE' => 'Y')));

//Получения всех изображений коллекции с ID равным 1
$arItems = CMedialibItem::GetList(array('arCollections' => array("0" => 1)));
$len = count($arItems);


for($i = 0; $i < $len; $i++)
{
    $Item = $arItems[$i];
}
?>

<div class="product-cart__image location-image">
    <?
    $bigPictureParams = array('w'=>530, 'h'=>351, 'zc'=>0, 'q'=>'100', 'aoe'=>0, 'far'=>"C", 'only_big_images'=>"Y");
    ?>
    <?if ($len > 0):?>
        <div class="noprint">
            <div class="detail__gallery">
                <?for($i = 0; $i < $len; $i++):?>
                    <div class="detail__gallery__item">
                        <a href="<?=MakeImage($arItems[$i]['PATH'], $bigPictureParams)?>" class="link_toImage-kh" title="">
                            <img alt="" src="<?=MakeImage($arItems[$i]['PATH'], array('wl'=>126, 'hl'=>80, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                        </a>
                    </div>
                <?endfor;?>
            </div>
        </div>
    <?endif;?>

    <div class="product-image-block">
        <div class="product-main-image">
            <a href="<?=MakeImage($arItems[0]['PATH'], $bigPictureParams)?>" class="link_toImageMain-kharkiv" title="<?=$main_image_alt?>">
                <img class="product-cart__img-kh" title="<?=$main_image_alt?>" alt="<?=$main_image_alt?>" src="<?=MakeImage($arItems[0]['PATH'], array('w'=>530, 'h'=>351, 'aoe'=>0, 'q'=>100, 'detail_image'=>"Y", 'far'=>"C"))?>" />
            </a>
        </div>
        <div style="display: none;">
            <div id="image_gallery-kh" class="detail__popup-gallery">

                <div id="image_gallery_main" style="overflow: hidden;">
                    <img class="adaptive-img" src="<?=MakeImage($arItems[0]['PATH'], $bigPictureParams)?>" width="530" height="351" alt="" />
                </div>

                <?if ($len > 0):?>
                    <div class="detail__popup-gallery-wrap">
                        <div class="detail__gallery detail__gallery--popup">
                            <?for($i = 0; $i < $len; $i++):?>
                                <div class="detail__gallery__item">
                                    <a href="#" onclick="$('#image_gallery_main-kh img').attr('src', '<?=MakeImage($arItems[$i]['PATH'], $bigPictureParams)?>'); return false;">
                                        <img alt="" src="<?=MakeImage($arItems[$i]['PATH'], array('wl'=>80, 'hl'=>80,'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                    </a>
                                </div>
                            <?endfor;?>
                        </div>
                    </div>
                <?endif;?>

            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                var wWidth = $(window).width();
                var minWindowWidth = 750;

                if (wWidth > minWindowWidth) {
                    $("a.link_toImageMain-kharkiv").fancybox({
                        'padding': 40,
                        'overlayShow': true,
                        'hideOnContentClick': false,
                        'titleShow': false,
                        'href': "#image_gallery-kh",
                        'helpers':  {
                            title:  null
                        }
                    });
                }

                $(".link_toImageMain-kharkiv").on('click', function() {
                    $('#image_gallery_main-kh img').attr('src', $(this).attr('href'));
                });

                $("a.link_toImage-kh").on('click', function(e) {
                    e.preventDefault();

                    $('#image_gallery_main-kh img').attr('src', $(this).attr('href'));

                    $('.product-cart__img-kh')
                        .attr('src', $(this).attr('href'))
                        .parents('.link_toImageMain-kharkiv')
                        .attr('href', $(this).attr('href'));
                });



            });
        </script>
    </div>
</div>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//PST-9
$this->setFrameMode(true);
//PST-9

if (empty($arResult))
    return;

$lastSelectedItem = null;
$lastSelectedIndex = -1;

foreach($arResult as $itemIdex => $arItem)
{
    if (!$arItem["SELECTED"])
        continue;

    if ($lastSelectedItem == null || strlen($arItem["LINK"]) >= strlen($lastSelectedItem["LINK"]))
    {
        $lastSelectedItem = $arItem;
        $lastSelectedIndex = $itemIdex;
    }
}

?>
<?if ($arParams['SPECIAL_ID'] != ''):?>
    <nav class="response-menu clearfix" id="response-menu-<?=$arParams['SPECIAL_ID']?>">
        <ul class="clearfix">
            <?foreach($arResult as $itemIdex => $arItem):?>
                <li<?if ($itemIdex == $lastSelectedIndex):?> class="current"<?endif;?>>
					<div class="clearfix_text <? if($arItem["LINK"]=='/about/contacts/') { echo "contacts_t";} if($arItem["LINK"]=='/about/') { echo "about_t";} ?>">
						<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					</div>
				</li>
            <?endforeach;?>

        </ul>
        <!-- <a href="javascript:void(0);" id="pull" class="pull"><span>Меню</span></a>
       <a href="javascript:void(0);" id="pull-login-block" class="pull-login-block"><span>Войти</span></a>-->
    </nav>

    <script type="text/javascript">
        BIS.responseMenu = {
            init: function() {
                var self = this;
                var container = $('#response-menu-<?=$arParams['SPECIAL_ID']?>');
                var menu = container.find('ul');
                var pull = container.find('#pull');
                var windowWidth = $(window).width();

                var cssOpenedPull = 'pull--opened';

                $(pull).on('click', function(e) {
                    e.preventDefault();

                    if ($(this).hasClass(cssOpenedPull)) {
                        $(this).removeClass(cssOpenedPull);
                        $(this).find('span').text('Меню');
                        menu.slideUp(100, function() {});
                    } else {
                        $(this).addClass(cssOpenedPull);
                        $(this).find('span').text('Закрыть');
                        menu.slideDown(200, function() {});
                    }
                });

                $(window).resize(function() {
                    self.resizeWindow(menu,pull);
                });

                //invoke when load page
                self.resizeWindow(menu,pull);

            },
            resizeWindow: function(menu,pull) {
                var w = $(window).width();
                var self = this;

                if (w > 700 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            }
        }

        $(function() {
            BIS.responseMenu.init();
        });

    </script>

<?else:?>
    <nav>
        <ul>
            <?foreach($arResult as $itemIdex => $arItem):?>
                <li<?if ($itemIdex == $lastSelectedIndex):?> class="current"<?endif;?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?endforeach;?>
        </ul>
    </nav>
<?endif;?>
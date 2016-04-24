
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<div class="search" id="search">
	<form id="search-form" method="get" action="<?=$arParams['SEARCH_PATH']?>">
        <input type="text" name="q" maxlength="50" autocomplete="off" id="input-search-key" class="search__q-input" placeholder="модель, аксесуар, бренд, код товара" value="<?=$_REQUEST['q']?strval(trim(strip_tags($_REQUEST['q']))):"";?>" />
        <input class="search__submit" type="submit" value="Найти" id="search-submit-button" />
	</form>
    <script>
        $(".search__q-input, .search__submit")
        .focus(function() {
        $('#search').addClass('search_focused');
                $(".search_focused").css("border","4px solid #B4C4D5")
        })
        .blur(function() {
        $('#search').removeClass('search_focused');
                $("#search").css("border","1px solid #4B80BB")
        });
    </script>
    <script>
        var searchObj = {
            init: function() {
                var self = this;

                self.responseEnhance();
                self.enableAutocomplete();
            },
            enableAutocomplete: function() {
                $('#input-search-key').autocomplete({
                    serviceUrl:'/bitrix/tools/ajax.php?ajax_call=<?=$arResult['AJAX_CALL_ID']?>&mode=autocomplete',
                    minChars:2,
                    onSelect: function(value,data) {
                        $('#search-form').find('#search-submit-button').trigger("click");
                    }
                });
            },
            responseEnhance: function() {
                var searchBlock = $('.search-block');
                var pullSearch = $('#pull-search');
                var inputSearch = $('#input-search-key');
                var cssActive = 'active';
                var cssFixed = 'search-block--fixed';

                pullSearch.on('click', function() {
                    if ($(this).hasClass(cssActive)) {
                        $(this).removeClass(cssActive);
                        searchBlock.removeClass(cssFixed);
                    } else {
                        $(this).addClass(cssActive);
                        searchBlock.addClass(cssFixed);
                        inputSearch.focus();
                    }
                })

            }
        }
        $(function(){
            searchObj.init();
        });
    </script>

	<?if (is_array($arResult['EXAMPLES']) AND !empty($arResult['EXAMPLES'])):?>
		<div class="float-left grey" id="search-examples">
			<p style="position: absolute; margin: -6px 0 0 2px; padding: 0; width: 355px; overflow: hidden;">Например: 
				<?
				foreach ($arResult['EXAMPLES'] as $k) {
					$search_examples[] = '<a class="grey" href="#">'.$k.'</a>';
				}
				echo implode(", ", $search_examples);
				?>
			</p>
		</div>
        <script>
            $('#search-examples p a').click(function(){
                $('#input-search-key').val($(this).html());
                return false;
            });
        </script>
	<?endif;?>
</div>
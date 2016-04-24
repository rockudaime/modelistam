
<noindex>
    <script type="text/javascript">
        var detailComments = {
            init: function() {
                var container = $('#detail__comments');

                if (container.length) {
                    container.css({
                        'height': '0',
                        'position': 'absolute',
                        'left': '-9999em',
                        'top': '-9999em'

                    });
                }
            }
        }

        $(function() {
            detailComments.init();
        })
    </script>
</noindex>

<script>
    var commentObj = {
        init: function() {
            var commentLink = $('.comment-form-link');
            var commentContainer = $('#comment-form-container');
            var cssActiveLink = 'comment-form-link--active';

            /*
            commentLink.on('click', function(e) {
                e.preventDefault();

                if ($(this).hasClass(cssActiveLink)) {
                    $(this).removeClass(cssActiveLink);
                    commentContainer.hide();
                } else {
                    $(this).addClass(cssActiveLink);
                    commentContainer.show();
                }
            })
            */

            if (document.location.toString().match('#comment-form')) {
                $('#comment_form').show();
                $('#showhide-comments-form').text('скрыть');
                $(this).removeClass('arr-grey-down-2').addClass('arr-grey-up-2');
            }
            $('#user_name').val('<?=$USER->GetFullName()?>');

            <?if ($arResult['USER_VOTES'][$arResult['USER_ID']]):?>
            $('#item-ratingback-<?=$arParams['ELEMENT_ID']?>').val(<?=$arResult['USER_VOTES'][$arResult['USER_ID']]?>);
            <?endif;?>

            $('#item-rating-<?=$arParams['ELEMENT_ID']?>').rateit({
                max: 5,
                step: 1,
                backingfld: '#item-ratingback-<?=$arParams['ELEMENT_ID']?>',
                starwidth: 18,
                starheight: 18,
            <?if ($arResult['USER_VOTES'][$arResult['USER_ID']]):?>
                readonly: true,
                <?endif;?>
                resetable: false
            });

            <?if (is_array($arResult['USER_VOTES'])):?>
                <?foreach($arResult['USER_VOTES'] as $user_id=>$score):?>
                $('.comment-ratingback-<?=$user_id?>').val(<?=$score?>);
                $('.comment-rating-<?=$user_id?>').rateit({
                    max: 5,
                    step: 1,
                    backingfld: '.comment-ratingback-<?=$user_id?>',
                    starwidth: 18,
                    starheight: 18,
                    readonly: true,
                    resetable: false
                });
                <?endforeach;?>
            <?endif?>

            $('#send_comment_button').click(function(){
                $('#user_comment').submit(); //ajax_load('#comments_form_errors', '<?=$arResult['AJAX_CALL_ID']?>', $('#user_comment').serializeArray());
            });
        }
    }

    $(function(){
        commentObj.init();
    });

</script>

<?$APPLICATION->IncludeComponent("bexx:iblock.items", "comments_1", array(
    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
    "SECTION_ID" => "",
    "ADDITIONAL_FILTER" => "PROPERTY_linked_item=".$arParams['ELEMENT_ID'],
    "ACTIVE" => "Y",
    "ACTIVE_DATE" => "Y",
    "MANAGED_CACHE_ID" => "comments".$arParams['ELEMENT_ID'],
    "SHOW_PROPERTIES" => array(
        0 => "author",
        1 => "isowner",
        2 => "recommend",
        3 => "helpful",
        4 => "vain",
    ),
    "GET_LINKED_ELEMENTS" => "N",
    "GET_LINKED_SECTIONS" => "N",
    "CHECK_PERMISSIONS" => "N",
    "EXTERNAL_FILTERING" => "N",
    "COUNT" => $arParams['COUNT'],
    "ALLOW_PAGENAV" => "N",
    "ALLOW_USER_PAGENAV" => "N",
    "PAGER_DESC_NUMBERING" => "Комментарии",
    "SORT_FIELD_1" => "id",
    "SORT_DIR_1" => "desc",
    "SORT_FIELD_2" => "",
    "SORT_DIR_2" => "asc",
    "USER_SORTING" => "N",
    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
    "CACHE_TIME" => $arParams['CACHE_TIME'],
    "ONLY_AUTHORIZED" => $arParams['ONLY_AUTHORIZED'],
    "ELEMENT_ID" => $arParams['ELEMENT_ID']
    ),
    $component
);?>

<?/*
<noindex>
    <div id="comments_form_errors">
        <?if ($arResult['ERRORS']) {
            echo ShowError(implode("<br />", $arResult['ERRORS']));
        }?>
        <?if ($arResult['MESSAGES']) {
            echo ShowError(implode("<br />", $arResult['MESSAGES']));
        }?>
    </div>
	<div class="block">
		<div class="content">
            <a href="#" class="comment-form-link">Оставить отзыв</a>
			<div id="comment-form-container">
				<div id="comment_form" style="<?if (isset($arResult['USERS'][$arResult['USER_ID']])):?>display: none;<?endif;?>">
					<form id="user_comment" method="post" action="<?=$APPLICATION->GetCurPageParam("", array_keys($_GET), false)?>#comments">
                        <input type="hidden" name="id" value="<?=$arParams['ELEMENT_ID']?>" />
                        <input type="hidden" name="do" value="comment" />
						
						<div class="comment-title">Ваше имя</div>
						<div class="comment-elem-block">
							<input type="text" name="name" id="user_name" value="" class="ui-grey-input" />
						</div>
						
						<?if (!isset($arResult['USERS'][$arResult['USER_ID']])):?>
						<div class="comment-title">Оценка</div>
						<div class="comment-elem-block">
							<?
							$user_score = intval($arResult['USER_VOTES'][$arResult['USER_ID']]);
							?>
							<input name="rating" type="hidden" id="item-ratingback-<?=$arParams['ELEMENT_ID']?>" value="<?=$user_score?>" />
							<div id="item-rating-<?=$arParams['ELEMENT_ID']?>"></div>
							<div id="item-ratingс-<?=$arParams['ELEMENT_ID']?>"></div>
						</div>
						
						<div class="comment-title recommend-other"><input type="checkbox" name="recommendation" value="1" /> Рекомендуете другим?</div>
						<?endif;?>
						
						<div class="comment-title">Отзыв <span class="orange">*</span></div>
						<div class="comment-elem-block">
							<textarea name="body" class="ui-grey-input" rows="5"></textarea>
						</div>
						
						<?if($arParams["CAPTCHA"] == "Y" OR ($arParams['CAPTCHA']=="A" AND !$USER->IsAuthorized())):?>
							<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
							<div class="comment-elem-block">
								Введите код: <input type="text" name="captcha_word" size="10" maxlength="20" value="" />
							</div>
							<div class="comment-elem-block">
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA" />
							</div>

						<?endif;?>
						
						<?if ($arResult['USER_ID']>0):?>
							<div class="green" id="user_message"></div>
							<div class="comment-submit">
								<div id="send_comment_button" class="ui-button-blue">
									Добавить отзыв
								</div>
							</div>
						<?else:?>
							<div class="need_to_register"> Чтобы оставить комментарий, необходимо <a class="red" href="/personal/">авторизоваться</a> на сайте </div>
						<?endif;?>
					</form>
				</div>
			</div>
		</div>
	</div>
</noindex>

*/?>
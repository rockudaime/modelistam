<?if ($arParams['AJAX_CALL']!="Y"):?>
<script>
function update_comments_list () {
    ajax_block('#comments_list');
    ajax_load('#comments_list', '<?=$arResult['AJAX_CALL_ID']?>');
}
</script>
<a name="comments"></a>
<div id="comments_list">
<?endif;?>

<?if ($arResult['ITEMS']):?>
	<div class="comments_list_inner" id="comments_list_<?=$arParams['ELEMENT_ID']?>">
		<?foreach ($arResult['ITEMS'] as $comment):?>
		<?if (strlen(trim(strip_tags($comment['DETAIL_TEXT'])))):?>
		<div class="comments-container">
            <a name="comment-<?=$comment['ID']?>"></a>
			<div>
				<!-- Votes and dates -->
				<div class="votes-and-date">
					<div class="left-vad">
						<div class="rating-content">
							<input type="hidden" class="comment-ratingback-<?=$comment['CREATED_BY']?>" value="0" />
							<div class="comment-rating-<?=$comment['CREATED_BY']?>"></div>
							<div class="comment-ratingс-<?=$comment['CREATED_BY']?>"></div>
						</div>
					</div>
					<div class="right-vad">
						<?=date("d.m.Y H:i", MakeTimeStamp($comment['DATE_CREATE']))?>
					</div>
				</div>

                <div class="author-name"><?=$comment['PROPERTY_VALUES']['author']['VALUE']?></div>
				
				<!-- Detail comment txt -->
				<div class="comment-detail-text">
					<?=$comment['DETAIL_TEXT']?>
				</div>
				
				<!-- Recommend buy -->
				<?if ($comment['PROPERTY_VALUES']['recommend']['VALUE']):?>
				<div class="recommend-buy">
					<span>Рекомендую покупать!</span>
				</div>
				<?endif;?>
				
				<!-- Helpful comment -->
				<div class="comment-helpful-block">
					<?if (is_array($comment['PROPERTY_VALUES']['helpful']['VALUE'])) {
						$plus_count = count($comment['PROPERTY_VALUES']['helpful']['VALUE']);
					} else {
						$plus_count = 0;
					}
					if (is_array($comment['PROPERTY_VALUES']['vain']['VALUE'])) {
						$minus_count = "-".count($comment['PROPERTY_VALUES']['vain']['VALUE']);
						$minus_count = $minus_count+0;
					} else {
						$minus_count = 0;
					}
					?>
					<span>Отзыв полезен?</span>
					<div class="chb-inner">
						<div class="helpful-yes">
							<a onclick="SendCommentVote(<?=$comment['ID']?>, 1);" href="javascript:void(0);">Да</a> <span id="comment_rate_yes_<?=$comment['ID']?>">(<?=$plus_count?>)</span> /&nbsp; 
						</div>
						<div class="helpful-no">
							<a onclick="SendCommentVote(<?=$comment['ID']?>, 0);" href="javascript:void(0);">Нет</a> <span id="comment_rate_no_<?=$comment['ID']?>"> (<?=$minus_count?>)</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?endif;?>
		<?endforeach;?>
        <?if (count($arResult['ITEMS'])>3):?>
            <a class="comment-list-link" href="#">Все комментарии</a>
        <?endif;?>
	</div>

    <script>
        var commentList = {
            init: function() {
                var comments = $('.comments-container');
                var cssHiddenComment = 'comments-container--hidden';
                var cssActiveLink = 'comment-list-link--active'
                var link = $('.comment-list-link');
                var linkTextShow = 'Все комментарии';
                var linkTextHide = 'Скрыть';
                var $this;

                hideOver3Comments = function() {
                    if (comments.length > 3) {
                        comments.filter(function(index) {
                            return index > 2;
                        }).addClass(cssHiddenComment);
                    }
                };

                hideOver3Comments();

                link.on('click', function(e) {
                    e.preventDefault();
                    $this = $(this);
                    if ($this.hasClass(cssActiveLink)) {
                        $this.text(linkTextShow);
                        $this.removeClass(cssActiveLink);
                        hideOver3Comments();
                    } else {
                        $this.addClass(cssActiveLink);
                        comments.removeClass(cssHiddenComment);
                        $this.text(linkTextHide);
                    }
                })
            }
        }
        $(function() {
            commentList.init();
        })

    </script>
	<? /* Oleg: pageNav работает криво, нужно фиксить
	<div class="comments-nav">
		<?if (strlen($arResult['NAV'])) echo $arResult['NAV'];?>
	</div>
	*/ ?>
	
<?else:?>
<div class="No-comments-yet">
	<noindex>
	К этому товару еще не оставляли отзывов.
	</noindex>
</div>
	
<?endif;?>


<?if ($arParam['AJAX_CALL']!="Y"):?>
</div>
<?endif;?>
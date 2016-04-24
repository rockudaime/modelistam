<?
$arResult['USER_ID'] = CBexxShop::GetRatingUserID($arParams['ONLY_AUTHORIZED']=="Y");
$arResult['AJAX_CALL_ID'] = CBexxShop::ajaxId();
?>
<script>
function SendCommentVote (comment_id, yes) {
    if (comment_id>0) {
        var yes_or_no = 'no';
        if (yes==1) yes_or_no = 'yes';
        ajax_load('#comment_rate_'+yes_or_no+'_'+comment_id, '<?=$arResult['AJAX_CALL_ID']?>', {'do' : 'comment_vote', 'comment_id' : comment_id, 'yes' : yes});
    }
    return false;
}
</script>
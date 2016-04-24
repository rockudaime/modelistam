<?
//PST-9
$frame = $this->createFrame()->begin('загрузка фильтра ...');
//PST-9
?>

    <script>
        function check_items (container) {
            $('#filter-result').hide().html('');
            ajax_load('#filter-result', '<?=$arResult['AJAX_CALL_ID']?>', $('#filter-form').serializeArray());
        }

        function set_filter (val_id) {
            //check_items('#prop-filter-'+val_id);
        }

        var makeFastFilter = function() {
            var values = $('.fastfilter-values-block');
            var props;
            var curPropName;
            var curSelect;
            var curOption;

            if (values.length) {
                values.each(function() {
                    curSelect = $("<select></select>")
                        .attr({
                            dataid: $(this).attr('id'),
                            class: 'fastfilter-select'
                        })
                        .insertAfter($(this));

                    curOption = $('<option>Не выбрано</option>').appendTo(curSelect);

                    props = $(this).find('.prop-filter');

                    if (props.length) {
                        props.each(function() {
                            curPropName = $(this).find('.prop-filter-name').text();
                            curOption = $('<option>'+curPropName+'</option>');
                            curOption
                                .attr({
                                    dataid: $(this).attr('id'),
                                    value: curPropName
                                })
                                .appendTo(curSelect);
                        })
                    }
                })
            }

            $('.fastfilter-select').on('change', function() {
                var activeOption = $(this).find('option:selected');
                var allCheckboxes = $(this).siblings('.fastfilter-values-block').find('.prop-filter-checkbox');
                var curFilter = values.find('#'+activeOption.attr('dataid'));
                var curCheckbox;

                // uncheck all checkboxes before checking one
                allCheckboxes.each(function() {
                    $(this).prop('checked', false);
                });
                curCheckbox = curFilter.find('.prop-filter-checkbox').prop('checked', true);
            })
        }
        $(function() {
            makeFastFilter();
        })

    </script>

    <div class="filter-inner-fastfilter">
        <div class="fastfilter-block">
            <form id="filter-form" method="get" action="/catalog/">

                <?if (!empty($arResult['FILTER_PROPS']) AND is_array($arResult['FILTER_PROPS'])):?>
                    <?foreach ($arResult['FILTER_PROPS'] as $filter_prop):?>

                        <div class="product-fastfilter">
                            <div class="fastfilter-header">
                                <?=GetMessage($filter_prop['CODE'])?>
                            </div>

                            <?if ($filter_prop['PROPERTY_TYPE']=="L" OR $filter_prop['PROPERTY_TYPE']=="E"):?>
                                <div class="fastfilter-values-block a-<? print isset($filter_prop['VALUES'])?>" id="product-filter-values-<?=$filter_prop['ID']?>">
                                    <?foreach ($filter_prop['VALUES'] as $k=>$v):?>
                                        <?if ($filter_prop['COUNT'][$k] OR !isset($filter_prop['COUNT'])):?>
                                            <?if ($filter_prop['COUNT'][$k]):?>
                                                <div class="prop-filter" id="prop-filter-<?=$k?>">
                                                    <input type="checkbox"
                                                           value="<?=$k?>"
                                                           name="<?=$filter_prop['CODE']?>[]"
                                                           id="prop_<?=$k?>"
                                                           class="prop-filter-checkbox"
                                                           onclick="set_filter('<?=$k?>')"
                                                            />
                                                    <span class="prop-filter-name"><?=$v?></span>

                                                </div>
                                            <?endif;?>
                                        <?endif;?>
                                    <?endforeach;?>
                                </div>
                            <?endif;?>
                        </div>
                    <?endforeach;?>
                <?endif;?>

                <div class="fastfilter-submit-block">
                    <input class="submit butt3 butt3--big" type="submit" value="Подобрать" />
                </div>
            </form>
        </div>
        <div id="filter-result"></div>
    </div>
<?
//PST-9
$frame->end();
//PST-9
?>
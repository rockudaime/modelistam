$(function(){
	$('#filter-form').submit(function(){
		if ($('#price-filter .price-min').val()==='') {
			$('#price-filter .price-min').attr('disabled', "disabled");
		}
		if ($('#price-filter .price-max').val()==='') {
			$('#price-filter .price-max').attr('disabled', "disabled");
		}
		$('.numeric-min, .numeric-max').each(function() {
			if ($(this).val() === '') $(this).attr('disabled', "disabled");
		});
	});
    var filterOpener = (function() {
        var mainFilterHeader = $('.filter-main-title'),
            sidebarFilterBlock = $('.filter-inner'),
            sfBlockIsOpen = true;

        mainFilterHeader.on('click', function() {
            if (sfBlockIsOpen) {
                sfBlockIsOpen = false;
                sidebarFilterBlock.slideUp('fast');
            } else {
                sfBlockIsOpen = true;
                sidebarFilterBlock.slideDown('fast');
            }
        });
    })();
});

// Class for creating new Sliders
function classSliderUI(slider, minValue, maxValue, curMin, curMax) {
	var slider = $(slider);
	var parent = slider.siblings('.price-slider-parent');
	var minInput = parent.find('.numeric-min');
	var maxInput = parent.find('.numeric-max');

	var minValue = parseInt(minValue);
	var maxValue = parseInt(maxValue);

	var curMin = parseInt(curMin) || minValue;
	var curMax = parseInt(curMax) || maxValue;


	slider.slider({
	  range: true,
	  min: minValue,
	  max: maxValue,
	  values: [curMin, curMax],
	  slide: function( event, ui ) {
		minInput.val(ui.values[0]);
		maxInput.val(ui.values[1]);
	  }
	});


	minInput.on('change.sliderChangeMin', function() {
		curMin = parseInt($(this).val());
		curMax = parseInt(maxInput.val());

		if ( curMin > curMax) {
			curMin = curMax;
			minInput.val(curMin);
		}
		slider.slider("values", 0, curMin);
	});

	maxInput.on('change.sliderChangeMax', function() {
		curMin = parseInt(minInput.val());
		curMax = parseInt($(this).val());

		if ( curMax > slider.slider("option", "max")) {
			curMax = slider.slider("option", "max");
		}

		if (curMin > curMax) {
			curMax = curMin;
		}

		maxInput.val(curMax);
		slider.slider("values", 1, curMax);
	});

	//default input state
	minInput.attr('placeholder',slider.slider('values', 0));
	maxInput.attr('placeholder',slider.slider('values', 1));

	slider.slider({
		stop: function( event, ui) {
			check_items(parent);
		}
	});
}

function check_items (container) {
	$('#filter-result').hide().html('');
	ajax_load('#filter-result', '74714a3b9d5781d00be4a545e8ef7444', $('#filter-form').serializeArray());
	$('#filter-result').css('top', $(container).offset().top-280);
}

function set_filter (val_id) {
	if ($('#prop_'+val_id).attr('disabled')) { // не активно, стало активно
		$('#prop_'+val_id).removeAttr('disabled');
		$('#prop-filter-'+val_id+' div.checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
	} else { // было неактиво, стало активно
		$('#prop_'+val_id).attr('disabled', "disabled");
		$('#prop-filter-'+val_id+' div.checkbox-black-checked').removeClass('checkbox-black-checked').addClass('checkbox-black');
	}
	check_items('#prop-filter-'+val_id);
}

function set_filter_enum (prop_id, enum_id) {
	if ($('#prop_'+prop_id+'_'+enum_id).attr('disabled')) {
		$('#prop_'+prop_id+'_'+enum_id).removeAttr('disabled');
		$('#product-filter-'+enum_id+' div.checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
	} else {
		$('#prop_'+prop_id+'_'+enum_id).attr('disabled', "disabled");
		$('#product-filter-'+enum_id+' div.checkbox-black-checked').removeClass('checkbox-black-checked').addClass('checkbox-black');
	}
	check_items('#product-filter-'+enum_id);
}
function set_filter_numeric (prop_id, is_max) {
	check_items('#numeric-filter-'+prop_id);
}
function set_filter_price (is_max) {
	check_items('#price-filter');
}

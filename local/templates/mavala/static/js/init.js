// DOM ready event
var submitForm = $.noop;

$(function(){

	// init scripts in .page block
	$('body').ini();

});


// Init scripts in selected jQuery block
$.fn.ini = function(){

	console.log("ini");

	var $root = this,
		$window = $(window);

	/* validate */
	//$root.find('form').validate();
	
	/* slider */
	//$root.find('.slider').scrollable({circular: true,vertical: false, mousewheel: false}).navigator('.slider_bullets').autoscroll({ autoplay: true, interval: 4000, autopause: false });
	
	/* scroll bar */
	//$root.find('.scroll_bar').jScrollPane();
	
	/* scroll to .goto */
	$root.find('.goto').goto();
	
	/* cart ajax */
	$root.find('.cart').each(function(){$(this).cart()});
	//$form.kladr_complite();

	var $form_not_cart = $root.find('form:not(.cart)');
	$form_not_cart.each(function(){
		var $cur_form = $(this),
			$form_autocomplete = $cur_form.find('.autocomplete');
		$cur_form.kladr_complite();
		$form_autocomplete.autocmplt(function(){
			var $city = $root.find('.kladr_city'),
				$ar_city = $form_autocomplete.val().split(',').shift().split(' ');
			$ar_city.pop();
			/*$city.val($ar_city.join(' '));
			$city.kladr('controller').setValueByName($city.val());*/
		});
	});
	//$root.find('form:not(.cart) .autocomplete').autocmplt();
};

$.fn.goto = function(){

	var $root = this,
		$scroller = $([]);
		
	if ($root.length) $scroller = $root.first();
		
	if ($scroller.length) $('html').scrollTo($scroller, 350);

}

$.fn.autocmplt = function(onSelectCallback){
	var $input = this;
		
	$input.each(function(){
		console.log("autocomplete");
		var $value_input = $(this),
			$data_input = $("<input/>", {
				type: "hidden",
				name: $value_input.attr('name'),
				value: $value_input.val()
			}),
			$bg_input = $("<input/>", {
				type: "text",
				tabindex: "-1",
				readonly: "readonly",
				value: $value_input.data('val'),
				autocomplete: "off",
				class: $value_input.attr('class'),
				size: $value_input.attr('size'),
				//placeholder: $value_input.attr('placeholder'),
				style: 'position: absolute; width:'+$value_input.width()+'px; left:'+$value_input.position().left+'px; top:'+$value_input.position().top+'px; z-index: -10;'
			}),
			url = $value_input.data('url'),
			val = $data_input.val(),
			suggs = [];
			
		$data_input.insertAfter($value_input);
		$bg_input.insertAfter($data_input);
		$bg_input.removeClass('autocomplete');
		$bg_input.addClass('autocomplete_bg');
		$value_input.attr('name', $value_input.attr('name') + '_val');
		$value_input.val($value_input.data('val'));
		$value_input.css({'background': 'none repeat scroll 0 0 transparent', 'position': 'relative', 'z-index': '20'})
		$bg_input.css('z-index', '10');
		//$value_input.removeAttr('placeholder');
		
		$value_input.keypress(function(event){
			if(event.which == 13) return false;
		});
		
		$value_input.autocomplete({
			serviceUrl: url,
			paramName: 'search',
			autoSelectFirst: true,
			deferRequestBy: '100',
			containerClass: 'autocomplete-suggestions',
			appendTo: $value_input.parent(),
			noCache: true,
			onSearchComplete: function(query, suggestions){
				var $list = $value_input.parent().find('.autocomplete-suggestions').css({'left':$value_input.position().left+'px'}).children();
				suggs = suggestions;
				if(suggestions.length){
					$bg_input.val(suggestions[0].value);
					$data_input.val(suggestions[0].data);
					//$value_input.val(suggestions[0].value.substr(0, query.length));
					//$value_input.val(suggestions[0].value.substr(0, $value_input.val().length));
					$value_input.val(suggestions[0].value.substr(0, query.length) + $value_input.val().slice(query.length));
				}
				else{
					$bg_input.val('');
					$data_input.val('');
				}
			},
			onActivate: function(item){
				$bg_input.val(suggs[item].value);
				$data_input.val(suggs[item].data);
			},
			onSelect: function(suggestion){
				if(suggestion.data != val)
				{
					$bg_input.val(suggestion.value);
					$data_input.val(suggestion.data);
					if ($.isFunction(onSelectCallback)) {
						onSelectCallback.call();
						return false;
					}
				}
			}
		});
	});

}

$.fn.kladr_complite = function(){

	var $root = this,
		$window = $(window);
		
	var $zip = $root.find('.kladr_zip'),
		$zip_block = $root.find('.kladr_zip_block'),
		$city = $root.find('.kladr_city'),
		$street = $root.find('.kladr_street'),
		$building = $root.find('.kladr_building');



	if($city.length)
	{
		$zip_block.hide();
		$.kladr.setDefault({
			verify: true,
			change: function (obj) {
				if(obj != undefined && obj.contentType == 'city')
					$street.kladr('controller').setValueByName($street.val());
				else if(obj != undefined && obj.contentType == 'street')
					$building.kladr('controller').setValueByName($building.val());
				if(obj != undefined && obj.zip != null)
				{
					$zip.val(obj.zip);
					$zip.attr('value', obj.zip);
				}
			},
			check: function (obj) {
				//console.log(obj);
				$root.find('[data-kladr-error]').each(function(){
					var $input = $(this),
						error_string = $input.data('kladr-error');
					if($input.hasClass('kladr-error'))
					{
						$input.addClass('error');
						$input.after('<label class="error">'+error_string+'</label>');
					}
				});
			},
			checkBefore: function (obj) {
				$root.find('[data-kladr-error]').each(function(){
					var $input = $(this),
						error_string = $input.data('kladr-error');
					$input.removeClass('error');
					$input.siblings('.error').remove();
				});
			}
		});

		$city.kladr({
			type: $.kladr.type.city
		});
		$city.kladr('controller').setValueByName($city.val());

		$street.kladr({
			type: $.kladr.type.street,
			//parentType: $.kladr.type.city,
			parentInput: $city
		});

		$building.kladr({
			type: $.kladr.type.building,
			//parentType: $.kladr.type.street,
			parentInput: $street
		});
	}
}

$.fn.cart = function(){
	console.log("cart");
	var $form = this,
		$window = $(window),
		$spinner = $form.append('<div class="fixed-spinner" />').find('.fixed-spinner'),
		$overlay = $form.append('<div class="block-overlay" />').find('.block-overlay'),
		timer,
		request,
		loading;
	// loading
	var showLoading = function(){
		loading = setTimeout(function(){
			$spinner.add($overlay).show();
		}, 150);
	};
	var hideLoading = function(){
		clearTimeout(loading);
		$spinner.add($overlay).hide();
	};

	submitForm = function(quick_buy){
		console.log("submitForm");
		
		clearTimeout(timer);
		timer = setTimeout(function(){
			if (request!=undefined) request.abort();
			$form.ajaxSubmit({
				data: {
					confirmorder: 'N',
					profile_change: 'N',
					is_ajax_post: 'Y',
					quick_buy: quick_buy ? 'Y' : 'N'
				},
				success: function(data) {
					$form.html(data).run();
					$form.cart();
					$form.find('.active:last').goto();
					hideLoading();
					return false;
				}, beforeSend: function(xhr,s){
					showLoading();
					request = xhr;
				}, error: function(data){
					hideLoading();
					return false;
				}
			});
		},500);
		return true;
		
	};


	$form.kladr_complite();
	$form.find('.autocomplete').autocmplt(submitForm);

	$form.validate();
	$('.quick_buy').click(function() {
		if($form.valid()) submitForm(true);
	});

	//$form.find('.submit').click(submitForm);
	$('.submit').click(function() {
		submitForm();
	});
	$('.submit_step').click(function() {
		if($form.valid() && !$form.find('.kladr-error').length) submitForm();
	});
	$form.find('.checked_submit').change(submitForm);

	$('.cart_zip').each(function(){
		var $input = $(this);
		$input.keyup(function(){
			if($input.val().length == 6)
				submitForm();
		});
	});
	
};

/*jQuery.extend(jQuery.validator.messages, {
        required: "Это поле необходимо заполнить.",
        remote: "Пожалуйста, введите правильное значение.",
        email: "Пожалуйста, введите корретный адрес электронной почты.",
        url: "Пожалуйста, введите корректный URL.",
        date: "Пожалуйста, введите корректную дату.",
        dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
        number: "Пожалуйста, введите число.",
        digits: "Пожалуйста, вводите только цифры.",
        creditcard: "Пожалуйста, введите правильный   кредитной карты.",
        equalTo: "Пожалуйста, введите такое же значение ещё раз.",
        accept: "Пожалуйста, выберите файл с правильным расширением.",
        maxlength: jQuery.validator.format("Пожалуйста, введите не больше {0} символов."),
        minlength: jQuery.validator.format("Пожалуйста, введите не меньше {0} символов."),
        rangelength: jQuery.validator.format("Пожалуйста, введите значение длиной от {0} до {1} символов."),
        range: jQuery.validator.format("Пожалуйста, введите число от {0} до {1}."),
        max: jQuery.validator.format("Пожалуйста, введите число, меньшее или равное {0}."),
        min: jQuery.validator.format("Пожалуйста, введите число, большее или равное {0}.")
});*/
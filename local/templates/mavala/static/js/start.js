$.fn.run = function(){

	var $root = this,
		$window = $(window);

	function equalHeight(group, groupSize) {
		if (!group.length) {
			return;
		}
		groupSize = +(groupSize || 0);
		if (groupSize < 1) {
			groupSize = group.length;
		}
		var start = -groupSize, part;
		while ((part = group.slice(start += groupSize, start + groupSize)) && part.length) {
			part.height(Math.max.apply(null, $.makeArray(part.map(function () {
				return $(this).height();
			}))));
		}
	}

	function attachFancybox(parent) {
		parent = parent || $root.find('body');
		parent.find('.btn-popup').fancybox({
			padding: 0,
			afterShow: function () {
				prepareFancyboxContent(this);
			}
		});

		parent.find('.btn-popup2').fancybox({
			padding: 0,
			fitToView: false,
			afterShow: function () {
				prepareFancyboxContent(this);
			}
		});
	}

	$root.find(".phone_number").mask("+7 (999) 999-99-99");

	$root.find('a.popup_btn').each(function(){
		var $popup = $(this),
			link = $popup.attr('href');
		$popup.fancybox({
			padding: 0,
			ajax:{
				data: {ajax: 'y'}
			},
			afterShow: function () {
				$('.fancybox-inner').run();
			}
		});
	});

	$root.find('a.reload_btn').each(function(){
		var $reload = $(this);
		$reload.click(function(){
			location.reload();
			return false;
		});
	});

	$root.find('form').each(function(){
		var $form = $(this);
		if($form.find('[data-rule-required="true"]').length && !$form.hasClass('cart')){
			$form.validate({
				submitHandler: function (form) {
					if($form.hasClass('popup_form'))
					{
						$.fancybox.showLoading();
						$form.ajaxSubmit({
							data: {ajax: 'y'},
							success: function(data) {
								$.fancybox.open(data);
								$('.fancybox-inner').run();
							}
						});
						return false;
					}
					else //что-то тут глючит)
					{
						$form.submit();
					}
				}
			});
		}
	});

	$root.find('form.addtobasket').each(function(){
		var $form = $(this);
		$form.submit(function(){
			$.fancybox.showLoading();
			$form.ajaxSubmit({
				data: {ajax_basket: 'Y'},
				success: function(data) {
					var request = $form.formSerialize();
					$.ajax({
						type: "GET",
						url: '/catalog/addtobasket.php?'+request,
						data: {
							ajax: 'y',
							action: '',
							//,response: data
						},
						success: function(html){
							$.fancybox.open(html);
							$('.fancybox-inner').run();
						}
					});
				}
			});
			return false;
		});
	});

	$root.find('a.addtobasket').each(function(){
		var $button = $(this),
			link = $button.attr('href');
		$button.click(function(){
			$.fancybox.showLoading();
			$.ajax({
				type: "GET",
				url: link,
				data: {
					ajax_basket: 'Y'
				},
				success: function(html){
					var request = link.slice(link.indexOf('?'));
					$.ajax({
						type: "GET",
						url: '/catalog/addtobasket.php'+request,
						data: {
							ajax: 'y',
							action: ''
						},
						success: function(html){
							$.fancybox.open(html);
							$('.fancybox-inner').run();
						}
					});
				}
			});
			return false;
		});
	});

	$root.find('.just-close').each(function(){
		$(this).click(function(){
			$.fancybox.close();
			return false;
		});
	});

	function prepareFancyboxContent(fancybox) {
		$root.find('#subscribe-two').validate({
			submitHandler: function (form) {
				$.fancybox.open({href: $(form).attr('action'), type: 'ajax', padding: 0,
					afterShow: function () {
						prepareFancyboxContent(this);
					}
				})
			}
		});

		attachFancybox($(fancybox.inner));

		$root.find("#loginform").validate();
		$root.find('#email-repair').validate({
			submitHandler: function (form) {
				$.fancybox.open({href: $(form).attr('action'), type: 'ajax', padding: 0, afterShow: function () {
					prepareFancyboxContent(this);
				}});
			}
		});

		$root.find(".popup .wrap-input input[type=checkbox]").Custom({
			customStyleClass: 'checkbox',
			customHeight: '17',
			enableHover: true
		});

		var slides = $root.find('.deliver-and-pay .right-side .item');
		var navigation = $root.find('.deliver-and-pay nav a').on('click', function (e) {
			$root.find('.deliver-and-pay nav a').removeClass('active');
			var $this = $(this);
			$this.addClass('active');
			e.preventDefault();
			$root.find('.fancybox-overlay').scrollTo((slides.eq($this.index())), 1000);
		});
		var box = $root.find('.deliver-and-pay nav');
		var boxHeight = box.height();
		$root.find('.fancybox-overlay').on('scroll', function () {
			var top = $root.find('.fancybox-overlay').scrollTop();
			slides.each(function () {
				var el = $(this);
				if (el.position().top > top - 350) {
					navigation.removeClass('active').eq(el.index()).addClass('active');
					return false;
				}
			});
			top += 20;
			if (top + boxHeight > $(fancybox.inner).children().height()) {
				top = $(fancybox.inner).children().height() - boxHeight;
			} else {
				if (top < 211) {
					top = 211;
				}
			}
			box.css('top', top);
		});
	}

	prepareFancyboxContent($root);

	$root.find('.amount-block').each(function(){
		var $amount_block = $(this),
		$btns = $amount_block.find('.btn-min,.btn-max');

		$btns.click(function(){
			var $count = $(this).closest('.amount-block').find('input'),
				$prices = $(this).parents('form').find('[data-price]');
			if($(this).hasClass('btn-min') && $count.val() > 1)
			{
				$count.val(parseInt($count.val()) - 1);
			}
			else if($(this).hasClass('btn-max'))
			{
				$count.val(parseInt($count.val()) + 1);
			}
			$prices.each(function(){
				var price_total = ($(this).data('price') * $count.val()).toString();
					slash_pos = price_total.indexOf('.');
				slash_pos = slash_pos > -1 ? slash_pos : price_total.length;
				if(slash_pos > 3)
				{
					price_total = price_total.slice(0,slash_pos-3) + ' ' + price_total.slice(slash_pos-3);
				}

				$(this).html(price_total + " р.");
			});
			return false;
		});
	});

	$root.find('.order-list .remove').each(function(){
		var $remove = $(this),
			$item = $remove.closest('.row'),
			$count = $item.find('.amount-block input');
		$remove.click(function(){
			$count.val(0);
			$item.hide();
			return false;
		});
	});

	$root.find('.head-cling').hide();

	$(window).scroll(function () {
		if ($(this).scrollTop() > 200) {
			$root.find('.head-cling').fadeIn();
		} else {
			$root.find('.head-cling').fadeOut();
		}
	});
	attachFancybox();

	function format(state) {
		if (!state.id) return state.text; // optgroup
		return "<span class='color-row' style='background-color:#" + state.id.toLowerCase() + "'></span>";
	}

	$root.find('select.color').select2({
		dropdownCssClass: 'colorlist',
		formatResult: format,
		formatSelection: format,
		escapeMarkup: function (m) {
			return m;
		}
	});

	$root.find('select.sort').select2({
		dropdownCssClass: 'sortlist'
	});
	$root.find('select.sort.number').select2({
		dropdownCssClass: 'sortlist'
	});

	$root.find('.product-list-top .choose').on('click', function () {
		$root.find('.sort .drop-list').slideUp();
		$(this).closest('.sort').find('.drop-list').slideDown();
	});

	$root.find('.property.volume-block select').select2({
		dropdownCssClass: 'volumelist'
	}).on("select2-open", function () {
		$(document).off('mouseleave.elementhover');
		$(document).off('mouseenter.elementhover');
	}).on("select2-close", function () {
		$(document).on('mouseenter.elementhover', '.slider-catalog ul li', function () {
			$(this).addClass('active');
		}).on('mouseleave.elementhover', '.slider-catalog ul li', function () {
			$(this).removeClass('active');
		});

		$(document).on('mouseenter.elementhover', '.wrap-product', function () {
			$(this).addClass('active');
		}).on('mouseleave.elementhover', '.wrap-product', function () {
			$(this).removeClass('active');
		});
	});

	$root.find('.social-likes').socialLikes({
		counters: true
		//,zeroes: true
		//,forceUpdate: true
	});

	equalHeight($root.find('.product-table .wrap-product'));
	equalHeight($root.find('.slider-catalog ul li'));
//
//	$root.find('.slider-main').removeClass('hide-block');

	$(window).resize(function () {
		$root.find('.slider-main .top-line, .slider-main .bottom-line').width($(window).width() - 10);
		$root.find('.slider-main .right-line,.slider-main .left-line').height($(window).height() - 69);
		$root.find('.slider-action ul[data-type="down"]').width($(window).width() / 2);
	}).resize();

	$root.find(".img-background").each(function () {
		var el = $(this);
		el.closest('li').css('background-image', 'url(' + el.attr('src') + ')');
	});

	$(window).load(function () {

		$root.find('.slider-main ul').carouFredSel({
			items: 1,
			auto: true,
			onCreate: function () {
				$root.find('.slider-main ul').removeClass('slider-hide');

				setTimeout(function () {
					$root.find('.slider-main ul li').eq(0).addClass('active')
				}, 500);
			},
			scroll: {
				timeoutDuration: 8000,
				fx: 'slide',
				onAfter: function (data) {
					$root.find('.slider-main ul li').removeClass('active');
					data.items.visible.addClass('active');
				}
			},
			swipe: {
				onTouch: true
			},
			responsive: true,
			prev: {
				button: ".slider-main  .btn-left",
				key: "left"
			},
			next: {
				button: ".slider-main  .btn-right",
				key: "right"
			},
			pagination: $root.find('.slider-main .control')
		});

		$root.find('.slider-action > ul').each(function () {
			var el = $(this);
			if (el.attr('data-type') == 'up' || el.attr('data-type') == 'down') {
				el.carouFredSel({
					items: 1,
					auto: true,
					direction: el.attr('data-type'),
					scroll: {
						timeoutDuration: 8000,
						fx: 'slide'
					},
					onCreate: function () {
						$root.find('.slider-action ul').removeClass('slider-hide');
					},
					pagination: function () {
						return $(this).closest('.slider-action').find('.control');
					}
				});
			} else {
				el.carouFredSel({
					items: 1,
					auto: true,
					direction: el.attr('data-type'),
					scroll: {
						timeoutDuration: 8000,
						fx: 'slide'
					},
					responsive: true,
					pagination: function () {
						return $(this).closest('.slider-action').find('.control')
					}
				});
			}
		});

		$root.find('.slider-specific > ul').carouFredSel({
			items: 1,
			auto: true,
			scroll: {
				timeoutDuration: 8000,
				fx: 'slide'
			},
			swipe: {
				onTouch: true
			},
			responsive: true,
			onCreate: function () {
				$root.find('.slider-specific ul').removeClass('slider-hide');
			},
			pagination: $root.find('.slider-specific .control-disk'),
			prev: {
				key: 'left',
				button: ".slider-specific .btn-prev"
			},
			next: {
				key: 'right',
				button: ".slider-specific .btn-next"
			}
		});

		$root.find('.promo-banner > ul').carouFredSel({
			items: 1,
			auto: true,
			swipe: {
				onTouch: true
			},
			scroll: {
				fx: 'slide',
				timeoutDuration: 8000
			},
			onAfter: function () {
				return $(this).closest('.promo-banner ul').removeClass('slider-hide');
			},
			pagination: function () {
				return $(this).closest('.promo-banner').find('.control-disk')
			}
		});

		$root.find('.slider-catalog > ul').carouFredSel({
			auto: true,
			items: 'variable',
			scroll: {
				items: 1,
				pauseOnHover: true,
				timeoutDuration: 8000
			},
			swipe: {
				onTouch: true
			},
			prev: {
				button: function () {
					return $(this).closest('.slider-catalog').find('.btn-prev');
				}
			},
			next: {
				button: function () {
					return $(this).closest('.slider-catalog').find('.btn-next');
				}
			},
			onCreate: function () {
				$root.find('.slider-catalog ul').removeClass('slider-hide');
			},
			pagination: function () {
				return $(this).closest('.slider-catalog').find('.control-disk');
			}
		});
	});

	/*rotation carousel size fix*/
	var doit;

	function resizedw() {
		$root.find('.slider-main li').height($(window).height());
		$root.find(".slider-catalog > ul, .slider-main > ul, .slider-action > ul, .slider-specific > ul, .promo-banner > ul").each(function () {
			$(this).trigger('updateSizes').trigger('configuration', ['debug', false, true]);
		});
	}

	$(window).resize(function () {
		clearTimeout(doit);
		doit = setTimeout(function () {
			resizedw();
		}, 500);
	});

	if (window.addEventListener) {
		window.addEventListener("orientationchange", function () {
			clearTimeout(doit);
			doit = setTimeout(function () {
				resizedw();
			}, 500);
		}, false);
	}

	$root.find('.contact-info').each(function(){
		var $block = $(this),
			$city = $block.find('.city'),
			$header = $root.find('header'),
			$instruction = $block.find('.instruction-city'),
			$city_name = $block.find('.city_name'),
			$sub_items = $instruction.find('.sub-item'),
			$question = $sub_items.eq(0),
			$ans_yes = $sub_items.eq(1),
			$ans_no = $sub_items.eq(2),
			$yes_btn = $question.find('.yes'),
			$no_btn = $question.find('.no'),
			$yestono_btn = $sub_items.find('.yestono'),
			$city_select = $instruction.find('.autocomplete'),
			search_open = false;

		var save_city = function() {
			$instruction.stop(true, true).fadeOut();
			$sub_items.hide();
			var $ar_city = $city_select.val().split(',').shift().split(' ');
			$ar_city.pop();
			$city_name.html($ar_city.join(' '));
			$.ajax({
				url: "?USER_CITY_ID="+$instruction.find('[name="USER_CITY_ID"]').val()
			});
			$city_select.val('');
			$city_select.siblings('.autocomplete_bg').val('');
		}

		var yes_open = function() {
			$sub_items.stop(true, true).fadeOut(function () {
				$sub_items.removeClass('active');
				$ans_yes.stop(true, true).fadeIn(function () {
					$(this).addClass('active');
				});
			});
		}

		var no_open = function() {
			$sub_items.stop(true, true).fadeOut(function () {
				$sub_items.removeClass('active');
				$ans_no.stop(true, true).fadeIn(function () {
					$(this).addClass('active');
					if(!search_open)
						$city_select.autocmplt(save_city);
					search_open = true;
				});
			});
		}

		$city.click(function(){
			$header.toggleClass('header-lvl');
			$sub_items.hide();
			$instruction.stop(true, true).fadeToggle(function () {
				$question.stop(true, true).fadeIn();
			});
		});

		$yes_btn.click(function(){
			yes_open();
		});

		$yestono_btn.click(function(){
			no_open();
		});

		$no_btn.click(function(){
			no_open();
		});
	});

	/*$root.find('.contact-info .city').on('click', function (e) {
		e.preventDefault();
		$root.find('header').toggleClass('header-lvl');
		$root.find('.instruction-city .sub-item').css('display', 'none');
		$root.find('.instruction-city').stop(true, true).fadeToggle(function () {
			$root.find('.instruction-city .sub-item:first').stop(true, true).fadeIn();
		});
	});

	$root.find('.instruction-city .no').on('click', function (e) {
		e.preventDefault();
		$root.find('header').removeClass('header-lvl');
		$root.find('.instruction-city').stop(true, true).fadeOut();
		$root.find('.instruction-city .sub-item').removeClass('active');
	});
	$root.find('.instruction-city .yes').on('click', function (e) {
		e.preventDefault();
		$(this).parent().stop(true, true).fadeOut(function () {
			$(this).removeClass('active');
			$root.find('.instruction-city .sub-item:nth-child(2)').stop(true, true).fadeIn(function () {
				$(this).addClass('active');
			});
		});
	});*/
	$root.find('.acc-management .search').on('click', function (e) {
		e.preventDefault();
		$root.find('.header-top .search-block').slideDown();
	});

	$(window).resize(
		function () {
			var heightWindow = $(window).height();
			$root.find('header.main-page').height(heightWindow);
		}
	).resize();


	$root.find('.section2 .btn-more2').on('click', function (e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$root.find('.section2 .drop').slideToggle();

	});
	$root.find('.header-catalog .text-block  .btn-more2').on('click', function (e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$root.find('.header-catalog .text-block .drop').slideToggle();
	});

	$root.find('.filters .filter-title').on('click', function (e) {
		e.preventDefault();
		$(this).closest('.item').toggleClass('active');
		$(this).closest('.item').find('.drop').slideToggle();
	});
	/*$root.find('.remove-filter').on('click', function (e) {
		e.preventDefault();
		$root.find('.menu.filters .item').removeClass('active');
		$root.find('.menu.filters .drop').slideUp();
	});*/

	if ($root.find('.slider-price').length) {

		$root.find('.slider-price').each(function () {
			var el = $(this);
			el.slider({
				min: parseInt(el.attr('data-min')),
				max: parseInt(el.attr('data-max')),
				range: true,
				values: [0 , parseInt(el.attr('data-max'))],
				step: parseInt(el.attr('data-step')),
				stop: function (event, ui) {
					el.closest('.price').find("input.minCost").val(el.slider("values", 0)).change();
					el.closest('.price').find("input.maxCost").val(el.slider("values", 1)).change();
				},
				slide: function (event, ui) {
					el.closest('.price').find("input.minCost").val(el.slider("values", 0));
					el.closest('.price').find("input.maxCost").val(el.slider("values", 1));
				}
			});
		});

		$root.find("input.minCost").change(function () {
			var input1 = $(this).closest('.wrap').find("input.minCost").val();
			var input2 = $(this).closest('.wrap').find("input.maxCost").val();
			/*if (input1 > input2) {
				input1 = input2;
				//input1();
			}*/
			$(this).closest('.price').find('.slider-price').slider("values", 0, input1);
		});

		$root.find("input.maxCost").change(function () {
			var input1 = $(this).closest('.wrap').find('input.minCost').val();
			var input2 = $(this).closest('.wrap').find("input.maxCost").val();
			/*if (input1 > input2) {
				input2 = input1;
				//input2();
			}*/
			$(this).closest('.price').find('.slider-price').slider("values", 1, input2);
		});
	}


	$root.find(".check-input , .user-form input[type=checkbox]").Custom({
		customStyleClass: 'checkbox',
		customHeight: '17',
		enableHover: true
	});

	$root.find(".user-form input[type=radio]").Custom({
		customStyleClass: 'checkbox',
		customHeight: '11',
		enableHover: true
	});

	$(document).on('click', '.popup .btn-close , .popup-product .btn-close, .deliver-and-pay .btn-close', function (e) {
		e.preventDefault();
		$.fancybox.close();
	});

	$root.find('.product-list-top .turn').on('click', function (e) {
		e.preventDefault();
		$(this).closest('.drop-list').slideUp();
	});
	$root.find("body").on("click", function (e) {
		if (!$(e.target).closest('.header-top').length) {
			$root.find('.header-top .search-block').slideUp();
		}
		if (!$(e.target).closest('.contact-info').length) {
			$root.find('header').removeClass('header-lvl');
			$root.find('.instruction-city .sub-item').css('display', 'none');
			$root.find('.instruction-city').stop(true, true).fadeOut(function () {
				$root.find('.instruction-city .sub-item:first').stop(true, true).fadeIn();
			});
		}
	});

	$root.find('.header-top .search-block .btn-close').on('click', function (e) {
		e.preventDefault();
		$(this).closest('.search-block').slideUp();
	});

	$root.find('.about-brand .slider ul').carouFredSel({
		items: 1,
		auto: true,
		timeoutDuration: 8,
		responsive: true,
		scroll: 1,
		swipe: {
			onTouch: true
		},
		prev: {
			key: 'left',
			button: function () {
				return $(this).closest('.slider').find('.btn-left')
			}
		},
		next: {
			key: 'right',
			button: function () {
				return $(this).closest('.slider').find('.btn-right')
			}
		},
		onCreate: function () {
			$root.find('.about-brand .slider ul').removeClass('slider-hide')
		},
		pagination: function () {
			return $(this).closest('.slider').find('.control-disk')
		}
	});

	var zoomItem = $root.find(".product-zoom .zoom").elevateZoom({
		zoomType: "lens",
		lensShape: "round",
		lensBorder: 3,
		lensSize: 150,
		galleryActiveClass: 'active',
		imageCrossfade: true,
		gallery: 'gallery-zoom-product'
	});

	$root.find('.comment-form .close').on('click', function (e) {
		e.preventDefault();
		$(this).closest('.comment-form').slideUp();
	});
	$root.find('.comment-list .btn-beige').on('click', function (e) {
		e.preventDefault();
		$(this).closest('li').find('.comment-form').slideDown().goto();

	});
	$root.find('.user-form .wrap-input').hover(function () {
		var $this = $(this);
		if ($this.attr('data-show') !== '1') {
			console.log();
			$this.attr('data-show', '1');
			$this.closest('.right').find('.hide').addClass('show');
		}
	}, function () {
		var $this = $(this);
		$this.closest('.right').find('.hide').removeClass('show');
	});

	$root.find('.js_tab').each(function(){
		var $tabs_block = $(this),
			$tabs = $tabs_block.find('ul li'),
			$tabs_link = $tabs.find('a'),
			$tabs_content = $root.find('.tab-info > ul > li'),
			open_comments = location.hash == '#comments';

		$tabs_link.click(function(){
			var $tab = $(this).closest('li'),
				$tab_content = $tabs_content.removeClass('active').hide().eq($tab.index()).fadeIn().addClass('active'),
				show = $tab_content.find('.zoom').length > 0;

			$tabs.removeClass('active');
			$tab.addClass('active');
			if (zoomItem.length) {
				zoomItem.data('elevateZoom').changeState(show);
				$root.find('.zoomContainer').toggle(show);
			}
			return false;
		});

		if(open_comments) {
			$tabs_link.filter('.comments').click().goto();
		}
		//alert(location.hash);
	});

	/*$root.find('.js_tab ul li a').on('click', function (e) {
		e.preventDefault();
		$root.find('.js_tab ul li').removeClass('active');
		var el = $(this).closest('li');
		el.addClass('active');
		var tab = $root.find('.tab-info > ul > li').removeClass('active').hide().eq(el.index()).fadeIn().addClass('active');
		var show = tab.find('.zoom').length > 0;
		if (zoomItem.length) {
			zoomItem.data('elevateZoom').changeState(show);
			$root.find('.zoomContainer').toggle(show);
		}
	});*/

	$root.find('.shopping-cart .user-form .item').on('click', function () {
		/*if (!$(this).hasClass('active'))
			$(this).addClass('active');*/
		$(this).find('.drop').slideDown();
	});
	$root.find('.order-table .row').on('click', function () {
		var $this = $(this);
		$this.toggleClass('active');
		$this.find('.drop-list').slideToggle();
	});
	var menuTimeout;
	$root.find('.header-btm .menu li a').mouseenter(function (e) {
		e.preventDefault();
		clearTimeout(menuTimeout);
		if ($(this).hasClass('hover')) {
			return;
		}
		$root.find('.header-btm .menu li a').removeClass('hover');
		$(this).addClass('hover');
		var elPosition = $(this).offset();
		var elEqual = $(this).closest('li');
		$root.find('.sub-menu-list > ul > li.item').removeClass('active').hide().eq(elEqual.index()).show().addClass('active');
		$root.find('.sub-menu-list').css('top', elPosition.top + 28).stop(true, true).slideDown();
	});
	$root.find('.header-btm .menu li a').mouseleave(function () {
		clearTimeout(menuTimeout);
		menuTimeout = setTimeout(function () {
			$root.find('.sub-menu-list').slideUp();
			$root.find('.header-btm .menu li a').removeClass('hover');
		}, 50);
	});
	$root.find('.sub-menu-list').mouseenter(function () {
		clearTimeout(menuTimeout);
	});
	$root.find('.sub-menu-list').mouseleave(function () {
		clearTimeout(menuTimeout);
		var el = $(this);
		menuTimeout = setTimeout(function () {
			el.stop(true, true).slideUp();
			$root.find('.header-btm .menu li a').removeClass('hover');
		}, 50);
	});
	$root.find('.sub-menu-list .btn-close').on('click', function () {
		$root.find('.sub-menu-list').slideUp();
		$root.find('.header-btm .menu li a').removeClass('hover');
	});

	$root.find('.wrap-select select').select2();

	$root.find("#user-form").validate();
	$root.find("#comment-form").validate();
	$root.find("#message-form").validate();
	$root.find("#address-form").validate();
	$root.find("#subscribe-form").validate({
		submitHandler: function (form) {
			$.fancybox.open({
				href: $(form).attr('action'),
				type: 'ajax',
				padding: 0,
				afterShow: function () {
					prepareFancyboxContent(this);
				}
			});
		}
	});

	$(document).on('mouseenter.elementhover', '.slider-catalog ul li', function () {
		$(this).addClass('active');
	}).on('mouseleave.elementhover', '.slider-catalog ul li', function () {
		$(this).removeClass('active');
	});

	$(document).on('mouseenter.elementhover', '.wrap-product', function () {
		$(this).addClass('active');
	}).on('mouseleave.elementhover', '.wrap-product', function () {
		$(this).removeClass('active');
	});

	if ($root.find('.wrap-map').length) {
	//yandex map

		function init() {
			var map = new ymaps.Map("map", {
				center: [55.743650, 37.637192],
				zoom: 13,
				controls: ["zoomControl"],
				behaviors: ["zoomScroll", 'drag']
			});

			var markers = [];

			function clearOverlays() {
				if (markers) {
					for (i in markers) {
						map.geoObjects.remove(markers[i]);
					}
				}
				markers = [];
			}

			$root.find('#city-select').on('change', function () {
				clearOverlays();
				map.setCenter(locations[$(this).val()].center, $(this).val() == 'all' ? 3 : 13);
				clusterer = new ymaps.Clusterer({
					clusterNumbers:[1], 
					zoomMargin: [30],
					clusterIcons: [{
						href: '/bitrix/templates/mavala/static/img/marker.png',
						size: [95, 119],
						offset: [-200, 0],
					}]
				});
				$.each(locations[$(this).val()].list, function (key, el) {
					var marker = new ymaps.Placemark(el.coordinates, el.data, el.icon);
					markers.push(marker);
					clusterer.add(marker);
					//map.geoObjects.add(marker);

					marker.events.add('mouseenter', function (e) {
						e.get('target').options.set('iconImageHref', el.iconactive);
					});
					marker.events.add('mouseleave', function (e) {
						e.get('target').options.set('iconImageHref', el.icon.iconImageHref);
					});
				});
				map.geoObjects.add(clusterer); 
			}).trigger('change');

			if ($root.find('.wrap-map.contacts').length || $root.find('.delivery-map').length) {
				var contactMarker = new ymaps.Placemark(
					contactCoordinates,
					{
						balloonImageOffset: [-200, 0]
					},
					{
						iconLayout: 'default#image',
						iconImageHref: contactIcon,
						iconImageSize: [95, 119]
					}
				);
				map.geoObjects.add(contactMarker);
			}
			map.behaviors.disable('scrollZoom');

		}

		ymaps.ready(init);
	}

	$root.find('.ajax_items:first').each(function(){
		var $items_block = $(this),
			$filter_block = $root.find('.ajax_filter'),
			$hide_btn = $filter_block.find('.ajax_hide'),
			$refresh_btn = $filter_block.find('.ajax_refresh'),
			$sort_block = $root.find('.ajax_sort'),
			request;

		var ajax_update = function()
		{
			var action_url = $filter_block.attr('action');
			$.fancybox.showLoading();
			$sort_block.find('select').each(function(){
				var param_link = $(this).val();
				if(param_link.length) {
					action_url = action_url + (action_url.indexOf('?') > -1 ? '&' : '?') + param_link;
				}
			});
			if (request!=undefined) request.abort();
			$filter_block.ajaxSubmit({
				url: action_url,
				data: {
					ajax: 'y',
					set_filter: 'Y'
				},
				beforeSend: function(xhr,s){
					request = xhr;
				},
				success: function(data) {
					var $data = $(data);
					$items_block.html($data.find('.ajax_items').html()).run();
					equalHeight($root.find('.product-table .wrap-product'));
					if($filter_block.formSerialize().length)
						$refresh_btn.show();
					$.fancybox.hideLoading();
				}
			});
		}

		$hide_btn.hide();
		$sort_block.find('select').removeAttr('onchange').change(ajax_update);
		$filter_block.find('input[type="text"]').change(ajax_update);
		$filter_block.find('input[type="checkbox"]').change(ajax_update);
	});
}



$(function(){

	// init scripts in .page block
	$('body').run();

});




/************/

$(function(){
	$(document).click(function(event) {
		if ($(event.target).closest(".header-top").length) return;

		$(".search-block").hide("slow");
		event.stopPropagation();
	});
});



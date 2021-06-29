(function($){
 "use strict";
//jQuery(window).on('load', function() {
//});
jQuery(document).ready(function($){

	var scroll = 0;

function $_GET(key) {
	var s = window.location.search;
	s = s.match(new RegExp(key + '=([^&=]+)'));
	return s ? s[1] : false;
}

if ($.support.pjax) {
	console.log('support');
	$(document).on('ready pjax:success', function() {
		plugins();
		NProgress.done();
	});
	$(document).on('pjax:start', function() {
		NProgress.start(); 
	});
	$(document).on('pjax:end',   function() { 
		NProgress.done(); 
		$('input[name=pageto]').val(window.location.pathname);
		if(scroll == 0) {
			jQuery('body, html').animate({scrollTop: 0}, 0);
		}
		if ($_GET('page') == 'novostroiki') {
			jQuery("html, body").animate({scrollTop: jQuery('.nov-b').offset().top - 0}, 0);
		} 
		scroll = 0;
	});
	$(document).on('click', 'a[data-pjax]', function() {
		//$('a').removeClass('active'); 
		//$(this).addClass('active');
		var urlen = $(this).attr('href');
		var container = $(this).attr('data-pjax');
		if(urlen == '/ipoteka') {
			document.location.href = "/ipoteka";
			$("#preloader").fadeIn(0);
			return false;
		}

		$.pjax({
			url: urlen, 
			container: '#'+container,
			"push":true,
			"replace":false,
			"timeout":30000,
			"scrollTo": false,
		});
		$(".overlay, .overlay2").click();
		if ($('#h-menu-btn.opened').length > 0) {
			$('#h-menu-btn').click();
		}
		//yaCounter47264181.hit(urlen);
		//ym(48226286, 'hit', urlen);
		document.getElementById('nprogress').parentNode.removeChild(document.getElementById('nprogress'));
		return false;
	});
	$(document).on('submit', 'form[data-pjax]', function(event) {
		var container = jQuery(this).attr('data-pjax');
		event.preventDefault();
		$.pjax.submit(event, '#'+container, {"timeout":30000,});
		return false;
	});
} else {
	plugins();
}

	var ip = $('div[data-ip]').attr('data-ip');
	$.ajax({
		type: "GET",
		url: 'https://pikformy.ru/api/city/sxgeo_sample.php',
		data: 'ip='+ip,
		dataType: 'json',
		beforeSend: function(){
		},
		success: function(response) {
			if(response.result) {
				if(!response.notify) {
					$('.links_list-value.city').addClass('activen');
					$('.set-city').html(response.city_name);
					$('.city .holder .seoxs').html(response.city_name);
				}
			} else {
				if(!response.notify) {
					$('.links_list-value.city').addClass('activen');
				}
			}
			console.log(response.message);
		}
	});

	$('.site-header').on('click', '#h-search-btn', function () {
		if ($(this).hasClass('opened')) {
			$(this).removeClass('opened');
			if ($('#h-search').length > 0) {
				$('#h-search').fadeOut();
			} else if ($('#h-search').length > 0) {
				$('#h-search').fadeOut();
			}
		} else {
			$(this).addClass('opened');
			if ($('#h-search').length > 0) {
				$('#h-search').fadeIn();
			} else if ($('#h-search').length > 0) {
				$('#h-search').fadeIn();
			}
		}
		return false;
	});


    jQuery('a').each(function() {
        if (jQuery(this).attr('href') == window.location.pathname)
        {
            jQuery(this).addClass('active-link');
        }
    });

	// Top Menu
	$('.site-header').on('click', '#h-menu-btn', function () {
		$(this).toggleClass('opened');
		$('.cmm-toggle-wrapper .cmm-toggle').click();

		if ($('#h-menu').length > 0) {
			$('#h-menu').slideToggle();
		}

		return false;
	});

	$('.mainmenu li.menu-item-has-children a').append('<div></div>');

	// Top SubMenu
	$('.mainmenu nav > ul').on('click', '.menu-item-has-children > a > div', function () {
		//$(this).parent().css("border", "1px solid red");
		if ($(window).width() < 751) {
			if ($(this).parent().hasClass('opened')) {
				$(this).parent().removeClass('opened');
				$(this).parent().next('ul').slideUp();
			} else {
				$(this).parent().addClass('opened');
				$(this).parent().next('ul').slideDown();
			}
			return false;
		}
	});

	jQuery("#preloader").delay(200).fadeOut("slow");
	jQuery('.overlay, .result_success, .result_error').fadeOut(0);
	/*if ($.support.pjax) {
		$.pjax.reload('#contents', {
			"replace":false,
			"timeout":10000,
			"scrollTo":false,
		});
	}*/

	$('.menu a').click(function(){
		$('.menu a').removeClass('active-link');
		//$(this).addClass('active-link');
	});
	$('.close-city').click(function(){
		$('.city').removeClass('activen');
		window.location.href = window.location.pathname;
		//$(this).addClass('active-link');
	});
	$('.set-city').click(function(){
		$('.city').addClass('activen');
	});

	$('.nav-linkes a').click(function(){
		$('.nav-linkes a').removeClass('active-link');
		$(this).addClass('active-link');
	});

	$(".hide-menu-add").appendTo(".hide-menu");

	$('.down-menu').click(function(e) {
		$('.hide-menu').toggleClass('active');
		if($('.hide-menu').hasClass('active')) {
			$('.down-menu').addClass('active');
		} else {
			$('.down-menu').removeClass('active');
			$('.down-menu').removeClass('active-link');
		}
		return false;
	});

	$('.close-menu').click(function(e) {
		$(this).parents('.menu').fadeOut(300);
		return false;
	});
	function media_onload(){
		if ($(window).width() < '768'){
			// mobile
			$('.menu a').click(function(){
				$('.menu a').removeClass('active-link');
				$(this).addClass('active-link');
				$('.menu').fadeOut(300);
			});
		} else {
			//desktop

		}
	}
	$(window).on('load resize', media_onload);

	//jQuery static

function initsliders(refresh, parent) {
	console.log()

	var slider_thumbs = '#prod-thumbs';
	var slider_main = '#prod-slider';

	if (refresh) {
		jQuery('#prod-thumbs').removeData("flexslider");
		jQuery('#prod-thumbs .slides').find("li").off();
		jQuery('#prod-slider').removeData("flexslider");
	}

	if (parent) {
		slider_thumbs = parent + ' ' + slider_thumbs;
		slider_main = parent + ' ' + slider_main;
	}

	jQuery(slider_thumbs).flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 97,
		itemMargin: 0,
		minItems: 5,
		maxItems: 5,
		asNavFor: slider_main,
		start: function(slider){
			jQuery(slider_thumbs).resize();
		}
	});
	jQuery(slider_main).flexslider({
		animation: "fade",
		animationSpeed: 500,
		slideshow: false,
		animationLoop: false,
		smoothHeight: false,
		controlNav: false,
		sync: slider_thumbs,
		after: function(slider) {
			jQuery('.prod-slider-count .count-cur').text(slider.currentSlide+1);
		}
	});
}


function plugins(){
	//ajax pages

	var hour = new Date().getHours();
	var greeting;
	if (hour >= 5 && hour < 12)
	    greeting = "Доброе утро";
	else if (hour >= 12 && hour < 18)
	    greeting = "Добрый день";
	else if (hour >= 18 && hour < 24)
	    greeting = "Добрый вечер";
	else if (hour >= 0 && hour < 5)
	    greeting = "Доброй ночи";
	$('#day').html(greeting);

	$(document).on('click', '.ctop', function() {
		jQuery('body, html').animate({scrollTop: 0}, 300);
	});

	$('.result_success, .result_error').fadeOut(0);

    var body = document.body,
        overlay = document.querySelector('.overlay'),
        overlayBtts = document.querySelectorAll('button[class$="open_window"], a[class$="open_window"]');
        
    [].forEach.call(overlayBtts, function(btt) {

      btt.addEventListener('click', function() { 
         
		/* Detect the button class name */
		var overlayOpen = this.className === 'open_window';

		/* Toggle the aria-hidden state on the overlay and the 
		no-scroll class on the body */
		overlay.setAttribute('aria-hidden', !overlayOpen);
		body.classList.toggle('noscroll', overlayOpen);

		/* On some mobile browser when the overlay was previously
		opened and scrolled, if you open it again it doesn't 
		reset its scrollTop property after the fadeout */
		setTimeout(function() {
			overlay.scrollTop = 0;              }, 1000)
		}, false);
	});

	var $this = $(window);
	var window_height = window.innerHeight;
	

	/*var loc = window.location.pathname;
	if (loc == '/leads') {
		setInterval(function(){
			var msg = $('.queon').serialize();
			$.ajax({
				type: "POST",
				url: "/engine/forms.php",
				data: msg,
				dataType: 'json',
				success: function(response) {
				    if(response.result == 'echo') {
						//$('.window').fadeOut(300);
						//$('.que_on').css('display', 'flex');
						$('.queon').find('.result_q').html(response.message);
				    } else {
				    	$('.lsghr').fadeOut(0);
				    	$('.queon').find('.result_q').html(response.message);
				    }
				}
			});
		}, 4870);
	}*/
	
	/*if (loc == '/novostroiki') {
		$(".window-plans").appendTo(".overlay");
	}*/

	$('input[name=todate2018]').click(function(){
		if($(this).prop("checked") == true) {
			console.log('true');
		} else {
			console.log('false');
		}
	});

	$( ".filter select" ).change(function() {
		$('.filter').submit();
	});
	$( ".filter .checkbox" ).change(function() {
		$('.filter').submit();
	});

	function cart_update_header() {
		$.ajax({
			type: "GET",
			url: "/api/index.php",
			data: "cart_update=sdas",
			dataType: 'json',
			beforeSend: function(){
				$('.h-cart-icon').fadeOut(0);$('.h-cart-icon').fadeIn(0);
			},
			success: function(response) {
				document.getElementById("cart_nums").innerHTML = response.nums;
				document.getElementById("cart_summ").innerHTML = response.summ;
				//$('.prod-li-total').html(response.summ);
			}
		});
	}

	/*function ipotekam() {

		var summa = $('#ipoteka-summa').val();
		var vznos = $('#ipoteka-vznos').val();
		var srok = $('#ipoteka-years').val();
		var stavka = 9.7;

		$.ajax({
			type: "GET",
			url: "/engine/ipoteka_calc_json.php",
			data: "summa="+summa+"&vznos="+vznos+"&srok="+srok+"&stavka="+stavka,
			dataType: 'json',
			beforeSend: function(){
				$('#ipoteka-btn').addClass('loading');
			},
			success: function(response) {
				$('#ipoteka-btn').removeClass('loading');
				$('#ipoteka-number-out').html(response.result);
			}
		});
	}

	ipotekam();*/

	/*$('#ipoteka-years').on('input', function(event){
		event.preventDefault();
		ipotekam();
		return false;
	});
	$('#ipoteka-vznos').on('input', function(event){
		event.preventDefault();
		ipotekam();
		return false;
	});*/

	if ($('.section-sb .blog-sb-widget .widgettitle').length > 0) {
		$('.section-sb .blog-sb-widget').on('click', '.widgettitle', function () {
			if ($(window).width() <= 991) {
				if ($(this).hasClass('opened')) {
					$(this).removeClass('opened').next().slideUp();
				} else {
					$(this).addClass('opened').next().slideDown();
				}
			}
			return false;
		});
	}

	$('form.ajax').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		var url_location = location.href;
		//var action = $(this).attr('action');
		if($(this).attr('data-action')) {
			var dataurl = $(this).attr('data-action');
		} else {
			var dataurl = "/api/form-contact.php";
		}

		$.ajax({
			type: "POST",
			url: dataurl,
			data: data + '&url=' + url_location,
			dataType: 'json',
			/*beforeSend: function(){
				$this.find('button[type=submit]').addClass('loading');
				$this.find('input, button, textarea').prop( "disabled", true );
			},
			success: function(response) {
				//$this.find('.result').removeClass('loading');
				$this.find('button[type=submit]').removeClass('loading');
	            if(response.result == 1) {
	            	if($this.find('.result_success').length > 0) {
						$this.find('.result_success').html(response.message);
						$this.find('.result_success').slideDown(300);
						//setTimeout(function() {
						//	$this.find('.result_success').slideUp(300);
						//}, 3000);
						$('.pass-gen').remove();
						$('.g-recaptcha').remove();
					} else {
						$('.overlay').fadeIn(200, function() {
							$('#result').css('display', 'flex');
						});
						//$('#blur').addClass('active');
						$('#result_text').html(response.message);
					}
				} else if (response.result == 'echo') {
		        	$this.find('.result').html(response.message);
		        	$this.find('.result').slideDown(300);
					setTimeout(function() {
						$this.find('.result').slideUp(300);
					}, 20000);
					$this.find('input').prop( "disabled", false );
				} else if (response.result == 'con') {
		        	$this.find('.result_con').html(response.message);
		        } else if (response.result == 'auth') {
		        	$('#code').val(response.message);
			        $('.overlay').fadeIn(200, function() {
			            $('#auth_code').css('display', 'flex');
			        });
		        } else {
		        	$this.find('input').prop( "disabled", false );
		        	if($this.find('.result_error').length > 0) {
			        	$this.find('.result_error').html(response.message);
			        	$this.find('.result_error').slideDown(300);
			        	if($this.find('.result_wait').length > 0) {
							setTimeout(function() {
								$this.find('.result_error').slideUp(300);
								$this.find('input, button, textarea').prop( "disabled", false );
							}, 20000);
						} else {
							setTimeout(function() {
								$this.find('.result_error').slideUp(300);
								$this.find('input, button, textarea').prop( "disabled", false );
							}, 3000);
						}
					} else {
						$('.window').fadeOut(200, function(){
							$('.overlay').fadeIn(200, function() {
								$('#result').css('display', 'flex');
							});
							///$('#blur').addClass('active');
							$('#result_text').html(response.message);
							$this.find('input, button, textarea').prop( "disabled", false );
						});
					}
		        }
			}*/
			beforeSend: function(){
				NProgress.start();
			},
			success: function(response) {
				NProgress.done();
				if(response.result) {
					/*$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});*/
					notify(response.message);
					$('input[type=submit]').remove();
				} else {
					notify(response.message);
				}
				//$this.find('.result').removeClass('loading');
			}
		});
		return false;
	});


	$('#result_close').click(function() {
		$('#result').fadeOut(0);
		$('.overlay').fadeOut(300);
	});

	$('#widget-btn').click(function() {
		$('.widget-eks').addClass('active');
		return false;
	});
	$('.widget-close').click(function() {
		$('.widget-eks').removeClass('active');
		return false;
	});

	$.mask.definitions['9'] = '';
	$.mask.definitions['N'] = '[0-9]';
	$('input[name="phone"]').mask('+7 (9NN) NNN-NN-NN', {autoclear: true});

	$.mask.definitions['S'] = '[0-9]';
	$('input[name="state"]').mask('SS-SS-SS', {autoclear: true});

	//var lazyload = lazyload || {};

    $("#loading-div").hide(0);
    //$('.case-noactive').hide(0);

   /* var page = 0,
        buttonId = "#button-more",
        loadingId = "#loading-div",
        container = "#data-container";

    $('#button-more').click(function() {
        $.ajax({
			url: "engine/forms.php",
			type: "GET", 
			data: {"num": page},
			cache: false,
			beforeSend: function() {
		        $('#button-more').hide();
		        $("#loading-div").show();
			},
            success: function(response) {
                if (!response || response.trim() == "NONE") {
                    $("#button-more").fadeOut();
                    $("#loading-div").html("<p>Список пуст</p>");
                    return;
                }
                appendContests1(response);
            },
            error: function(response) {
                $("#loading-div").html("<p>Ошибка! Пожалуйста, обратитесь в службу поддержки.</p>");
            }
        });
       	return false;
    });

    var appendContests1 = function(response) {
        var id = $(buttonId);

        $(loadingId).fadeOut(0);

        $(response).appendTo($(container));
        $('.case-noactive').hide(0);

		var $target = $('.case-noactive');
		var hold = 200;

		$.each($target,function(i,t){
		     var $this = $(t);
		     setTimeout(function(){ 
		     	$this.show('normal'); 
		     	$this.removeClass('case-noactive'); 
		     },i*hold);
		});

		$(buttonId).fadeIn(300);
		plugins();
        page += 10;
    };*/



	/*var scroll = function(e) {
	    // compute state
	    if (stopScrollX || stopScrollY) {
	        e.preventDefault();              // this one is the key
	        e.stopPropagation();
	        window.scroll(scrollToX, scrollToY);
	    }
	}
	document.addEventListener('mousewheel', scroll, false);*/

    $(window).resize(function() {
          //alert( $(window).height() );
    });

    $('.open_window2').click(function() {
        var name_window = $(this).attr('href');
        if ($('.overlay2').is(':hidden')) {
	        $('.overlay2').fadeIn(300, function() {
	            $(name_window).css('display', 'flex');
	        });
        } else {
        	$(name_window).css('display', 'flex');
        }
    });

	$('.overlay2').click(function(event) {
		if ($(event.target).closest(".window2").length) return;
		$('.window2').fadeOut(300);
		$('.overlay2').fadeOut(300);
		$('body').removeClass('noscroll');
		event.stopPropagation();
	});
    $('.window_close2').click(function() {
        //$('body').css('position','relative');
        var $this = $(this);
        $this.parent('.window2').addClass('noactive');
        setTimeout(function () {
	        if ($('.window2:visible').size() <= 1) {
				$('.overlay2').fadeOut(300,function() {
					$this.parent('.window2').removeClass('noactive');
					$this.parent('.window2').css('display', 'none');
				});
	        } else {
				$this.parent('.window2').removeClass('noactive');
				$this.parent('.window2').css('display', 'none');
	        }
	        $('body').removeClass('noscroll');
        }, 500);
    });


    $('.open_window').click(function() {
        var name_window = $(this).attr('href');
        if ($('.overlay').is(':hidden')) {
	        $('.overlay').fadeIn(300, function() {
	            $(name_window).css('display', 'flex');
	        });
        } else {
        	$(name_window).css('display', 'flex');
        }
        return false;
    });

	$('.overlay').click(function(event) {
		if ($(event.target).closest(".window").length) return;
		$('.window').fadeOut(300);
		$('.overlay').fadeOut(300);
		$('body').removeClass('noscroll');
		event.stopPropagation();
	});
	$('.close_windows').click(function(){
		$('.window').fadeOut(100, function(){
			$('.overlay').fadeOut(100);
		});
	});
    $('.window_close').click(function() {
        //$('body').css('position','relative');
        var $this = $(this);
        $this.parent('.window').addClass('noactive');
        setTimeout(function () {
	        if ($('.window:visible').size() <= 1) {
				$('.overlay').fadeOut(300,function() {
					$this.parent('.window').removeClass('noactive');
					$this.parent('.window').css('display', 'none');
				});
	        } else {
				$this.parent('.window').removeClass('noactive');
				$this.parent('.window').css('display', 'none');
	        }
	        $('body').removeClass('noscroll');
        }, 500);
    });

    $('.win-check').hide(0);

    $('.open-win-info').click(function() {
        var name_window = $(this).attr('href');
        //$(name_window).css('display', 'flex');
        if ($('.win-check').is(':hidden')) {
        	$('.win-info').css('display', 'none');
	        $(name_window).css('display', 'flex');
	        $('.win-check').show(300);
        } else {
        	$('.win-info').css('display', 'none');
        	$(name_window).css('display', 'flex');
        }
    });
    $('.win-close').click(function() {
        var $this = $(this);
        $this.parent('.win-info').addClass('noactive');
        setTimeout(function () {
			$('.win-check').hide(200,function() {
				$this.parent('.win-info').removeClass('noactive');
				$this.parent('.win-info').css('display', 'none');
			});
        }, 0);
    });

	/*$('.check').toggle(
	    function(e){

	    },
	    function(e){

	    }
	);*/
	$('.check').click(function() {
		var $this = $(this);
		if ($this.parent().hasClass('active')) {} else {
			if ($this.hasClass('active')) {
		    	$('.ui').css('display','none');
		    	$this.removeClass('active');
			} else {
				$('.check').removeClass('active');
				$('.ui').css('display','none');
		    	$this.find('.ui').css('display','inline-flex');
		    	$this.addClass('active');
			}
		}
		return false;
	});
	$('.str').click(function() {
		var $this = $(this);
		$(this).toggleClass('selecteds');
	});

	$('.star').click(function(event) {
		var star_id = $(this).attr('data-id');
		var star_type = $(this).attr('data-type');
		$(this).toggleClass('active');
		$.ajax({
			type: "POST",
			url: "/engine/forms.php",
			data: "star="+star_id+"&type="+star_type,
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					notify(response.message);
					if(response.status == 1) {
						$(this).addClass('active');
					} else {
						$(this).removeClass('active');
					}
			    } else {
			    	notify(response.message);
			    }
			}
		});
		return false;
	});

	$('.star-fav').click(function(event) {
		var star_id = $(this).attr('data-id');
		var star_type = $(this).attr('data-type');
		$(this).toggleClass('active');
		$.ajax({
			type: "POST",
			url: "/engine/forms.php",
			data: "star="+star_id+"&type="+star_type,
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					notify(response.message);
					if(response.status == 1) {
						$(this).addClass('active');
					} else {
						$(this).removeClass('active');
					}
			    } else {
			    	notify(response.message);
			    }
			}
		});
		$.pjax.reload('#content', {
			"replace":false,
			"timeout":10000,
			"scrollTo":false,
		});
		return false;
	});

	$('.add_like').click(function(event) {
		var $this = $(this);
		var uidd = $(this).attr('data-id');
		$(this).toggleClass('active');
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: "uidd="+uidd+"&like",
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					//notify(response.message);
					if(response.status == 1) {
						$(this).addClass('active');
						//$(this).attr("data-tooltip", "Вам понравилось");
					} else {
						$(this).removeClass('active');
					}
			    } else {
			    	notify(response.message);
			    }
			}
		});
		return false;
	});

	$('.add_cart').click(function(event) {
		var $this = $(this);
		var uidd = $(this).attr('data-id');
		var mod = $(this).attr('data-mod');
		if (mod) {
			//$('.prod-add .variations select').length > 0
			mod.replace(/[^0-9]/g, '');
			//var chars = $('.select-mod-form').serializeArray();
		} else {
			//var chars = null;
			mod = 0;
		}
		var chars = $('.select-mod-form').serializeArray();
		$(this).toggleClass('active');
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: {
				'uidd': uidd,
				'cart': '',
				'mod': mod,
				'chars': chars,
			},
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					if(response.status == 1) {
						$(this).addClass('active');
						//$(this).children("span").html("Вам понравилось");
					} else {
						$(this).removeClass('active');
					}
					cart_update_header();
			    } else {
			    	notify(response.message);
			    }
			}
		});
		return false;
	});


	$('.del_cart').click(function(event) {
		var $this = $(this);
		var uidd = $(this).attr('data-id');
		$(this).toggleClass('active');
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: "uidd="+uidd+"&cart",
			dataType: 'json',
			success: function(response) {
				notify(response.message);
				cart_update_header();
				$.pjax.reload('#content', {
					"replace":false,
					"timeout":10000,
					"scrollTo":false,
				});
			}
		});
		return false;
	});

    $('.pass-hide').click(function() {
        var $this = $(this);
        if($this.hasClass('active')) {
        	$this.siblings('.pass-control').attr('type', 'password');
        } else {
			$this.siblings('.pass-control').attr('type', 'text');
        }
        $this.toggleClass('active');
    });

    $('.link-programms').click(function() {
    	$("html, body").animate({ scrollTop: $('#programms').offset().top }, 500);
    	return false;
    });

    $('.pass-gen').click(function() {
        var $this = $(this);
		$this.siblings('.pass-control').attr('type', 'text');
		$this.siblings('.pass-control').val(rand_pass());
		$this.siblings('.pass-control').focus();
		$this.siblings('.pass-hide').removeClass('active');
		$this.siblings('.pass-hide').addClass('active');
		notify('Обязательно, запомните или запишите пароль');
    });

	function abc2(n) {
		n += "";
		n = new Array(4 - n.length % 3).join("U") + n;
		return n.replace(/([0-9U]{3})/g, "$1 ").replace(/U/g, "");
	}

	if(location.pathname.split('/')[1] == 'ipoteka') {

	function ipoteka() {
		var s1 = $('#ex1').val();
		var s2 = $('#ex2').val();
		var s3 = $('#ex3').val();
		var summ = $('#out_numb').val();
		//console.log('ipoteka-ajax: '+s1+', '+s2+', '+s3);
		$.ajax({
			type: "POST",
			url: "/engine/ipoteka.php",
			data: "summa="+s1+"&vznos="+s2+"&srok="+s3+"&out_summ="+summ,
			//dataType: 'json',
			beforeSend: function(){
				$(".link-programms").addClass('loading');
			},
			success: function(response) {
				$(".link-programms").removeClass('loading');
				$('#programms').html(response);
			}
		});
		$.ajax({
			type: "POST",
			url: "/engine/ipoteka_json.php",
			data: "summa="+s1+"&vznos="+s2+"&srok="+s3+"&out_summ="+summ,
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(response) {
				if(response.banks == 0) {
					$("#echo_banks").html('Вам не подходят ипотечные программы');
					$('.link-programms').fadeOut(0);
				} else {
					$('.link-programms').fadeOut(0);
					$('.link-programms').fadeIn(0);
					$("#echo_banks").html('Вам подходят <b>'+response.banks+' ипотечные программы</b> в '+response.banks+' банках');
				}
			}
		});
	}

	var s_exs1 = $('#exs1');
	s_exs1.rangeslider({
	    polyfill: false,
	    rangeClass: 'rangeslider',
	    disabledClass: 'rangeslider--disabled',
	    horizontalClass: 'rangeslider--horizontal',
	    verticalClass: 'rangeslider--vertical',
	    fillClass: 'rangeslider__fill',
	    handleClass: 'rangeslider__handle',

	    // Callback function
	    onInit: function() {

	    },
	    // Callback function
	    onSlide: function(position, value) {
	    	document.getElementById("ex1").value = abc2(value);
	    	var summa = value-10000;

			var num_val = document.getElementById('ex2').value;
			var num = num_val.replace(/\s+/g, '');
			var out = value-num;
			
			if(num > value+10000) {
				//console.log('перебор');
				var out = -out;
				document.getElementById("ex2").value = abc2(out);
				$('#exs2').val(summa).change();
			} else {
				//console.log('нет перебора');
				document.getElementById("numb").textContent = abc2(out);
				document.getElementById("out_numb").value = out;
			}

			$('#exs2').attr('max',summa);
	    	$('#exs2info').html(abc2(summa)+' руб.');
	    	s_exs2.rangeslider('update', true);
	    },
	    // Callback function
	    onSlideEnd: function(position, value) {
	    	ipoteka();
	    }
	});
	var s_exs2 = $('#exs2');
	s_exs2.rangeslider({
	    polyfill: false,
	    rangeClass: 'rangeslider',
	    disabledClass: 'rangeslider--disabled',
	    horizontalClass: 'rangeslider--horizontal',
	    verticalClass: 'rangeslider--vertical',
	    fillClass: 'rangeslider__fill',
	    handleClass: 'rangeslider__handle',

	    // Callback function
	    onInit: function() {

	    },
	    // Callback function
	    onSlide: function(position, value) {
	    	document.getElementById("ex2").value = abc2(value);

			var num_val = document.getElementById('ex1').value;
			var num = num_val.replace(/\s+/g, '');
			var out = num-value;
			document.getElementById("numb").textContent = abc2(out);
			document.getElementById("out_numb").value = out;
	    },
	    // Callback function
	    onSlideEnd: function(position, value) {
	    	ipoteka();
	    }
	});
	var s_exs3 = $('#exs3');
	s_exs3.rangeslider({
	    polyfill: false,
	    rangeClass: 'rangeslider',
	    disabledClass: 'rangeslider--disabled',
	    horizontalClass: 'rangeslider--horizontal',
	    verticalClass: 'rangeslider--vertical',
	    fillClass: 'rangeslider__fill',
	    handleClass: 'rangeslider__handle',

	    // Callback function
	    onInit: function() {

	    },
	    // Callback function
	    onSlide: function(position, value) {
	    	document.getElementById("ex3").value = abc2(value);
	    },
	    // Callback function
	    onSlideEnd: function(position, value) {
	    	ipoteka();
	    }
	});

	$('#ex3').on('input', function(e){
		ipoteka();
	});
	$('#ex1').on('input', function(e){
		var num_old = $(this).val();
		var num = num_old.replace(/\s+/g, '');

		var summa = num-10000;
		$('#exs2').attr('max',summa);
    	$('#exs2info').html(abc2(summa)+' руб.');
    	s_exs2.rangeslider('update', true);
    	$('#exs2').val(num).change();
	});
	$('#ex2').on('input', function(e){
		var num_old = $(this).val();
		var num = num_old.replace(/\s+/g, '');
    	document.getElementById("ex2").value = abc2(num);

		var num_val = document.getElementById('ex1').value;
		var num2 = num_val.replace(/\s+/g, '');
		var out = num2-num;
		document.getElementById("numb").textContent = abc2(out);
		document.getElementById("out_numb").value = out;
		if(out < 10000) {
			var max = $('#exs2').attr('max');
			$('#exs2').val(max).change();
			//s_exs2.rangeslider('update', true);
		}
	});

	ipoteka();

	//s_exs1.rangeslider('update', true);
	//s_exs2.rangeslider('update', true);
	//s_exs3.rangeslider('update', true);


	}

	$('#logout').click(function(event) {
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: "logout=1",
			dataType: 'json',
			beforeSend: function(){
				$("#preloader").fadeIn("slow");
			},
			success: function(response) {
			    window.location.href = window.location.pathname;
			}
		});
	});

	function notify(text) {
   		$("<div class='des-not'>"+text+"</div>'")
        .appendTo('#notify')
        .delay(4000)
        .queue(function() {
            $(this).remove();
        });
	}

	$(".input").focus(function() {
		$(this).parent().addClass("is-completed")
	}), $(".input").focusout(function() {
		"" === $(this).val() && $(this).parent().removeClass("is-completed");
	});

	/*$(".f-select").click(function() {
		//$(this).toggleClass('active');
		return false;
	});*/

	$('.search-street').on('input', function(){
		$('.f-select.street').toggleClass('active');
		$('.f-select.street > div').css('display','inline-flex');
		var text = $(this).val();
		//$('.result-street').fadeOut(0);
		if ($('.filter-realty .rw .f-select.street .checkbox:contains("'+text+'")').text().indexOf(text) >= 0) {
			$('.filter-realty .rw .f-select.street .checkbox').fadeOut(0);
			$('.filter-realty .rw .f-select.street .checkbox:contains("'+text+'")').fadeIn(0);
			//console.log('Поиск: '+text+' - найдено: '+id_street);
		} else {
			//console.log('Поиск: '+text+' - не найдено');
			$('.filter-realty .rw .f-select.street .checkbox').fadeOut(0);
			$('.result-street').fadeIn(0);
		}
	});
	$('.result-street').fadeOut(0);

    $(".f-select").click(function() {
    	if(!$(this).hasClass("filter-button")) {
	    	if($(this).hasClass("active")) {
		    	$(".f-select").find('div').css('display', 'none');
		    	$(".f-select").removeClass('active');
	    	} else {
		    	$(".f-select").find('div').css('display', 'none');
		    	$(".f-select").removeClass('active');
		        $(this).find('div').css('display', 'inline-flex');
		        $(this).addClass('active');
	    	}
	    	var checked_count = $(this).find('input:checked').length;
	    	if(checked_count > 0) {
	    		$(this).find('.lab').text('Выбрано: '+checked_count);
	    		$(this).find('.lab').addClass('active');
	    	} else {
	    		$(this).find('.lab').text('Выбрать');
	    		$(this).find('.lab').removeClass('active');
	    	}
	    } else {
	    	//return false;
	    }
    });

    $(".f-select.filter-options").click(function() {
    	$(this).toggleClass('active');
    	$('.hide-filter').toggleClass('active');
    });

    $(".f-select").click();
    $(".f-select > div").fadeOut(0);
    $(".f-select").removeClass('active');

	$('section').click(function(event) {
		if ($(event.target).closest(".f-select").length) {} else{
    		$(".f-select").find('div').css('display', 'none');
    		$(".f-select").removeClass('active');
    	}
	});

	$('.head-top .open-menu').click(function(e) {
		$('.head-top .menu').css('display','flex');
		return false;
	});

	$(".window-add").appendTo(".overlay");

	/*function media(){
		if ($(window).width() < '768'){
			// mobile
			$(".nov-filters").removeAttr("id");
		}
		if ($(window).width() > '768'){
			// desktop
			$(".nov-filters").removeAttr("id");
		}
	}

	$(window).on('load resize', media);*/

	function media(){
		if ($(window).width() < '768'){
			// mobile

		} else {
			// desktop

			/*if($("div").is("#aside1")) {
				(function(){
				var a = document.querySelector('#aside1'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
				window.addEventListener('scroll', Ascroll, false);
				document.body.addEventListener('scroll', Ascroll, false);
				function Ascroll() {
				  if (b == null) {
				    var Sa = getComputedStyle(a, ''), s = '';
				    for (var i = 0; i < Sa.length; i++) {
				      if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
				        s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
				      }
				    }
				    b = document.createElement('div');
				    b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
				    a.insertBefore(b, a.firstChild);
				    var l = a.childNodes.length;
				    for (var i = 1; i < l; i++) {
				      b.appendChild(a.childNodes[1]);
				    }
				    a.style.height = b.getBoundingClientRect().height + 'px';
				    a.style.padding = '0';
				    a.style.border = '0';
				  }
				  var Ra = a.getBoundingClientRect(),
				      R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('footer').getBoundingClientRect().top + 60);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
				  if ((Ra.top - P) <= 0) {
				    if ((Ra.top - P) <= R) {
				      b.className = 'stop';
				      b.style.top = - R +'px';
				    } else {
				      b.className = 'sticky';
				      b.style.top = P + 'px';
				    }
				  } else {
				    b.className = '';
				    b.style.top = '';
				  }
				  window.addEventListener('resize', function() {
				    a.children[0].style.width = getComputedStyle(a, '').width
				  }, false);
				}
				})();
			}*/
		}
	}
	$(window).on('load resize', media);

	/*$('.img-slider').owlCarousel({
	    loop: true, //Зацикливаем слайдер
	    margin: 0, //Отступ от элемента справа в 50px
	    nav: true, //Отключение навигации
	    autoplay: false, //Автозапуск слайдера
	    smartSpeed: 1000, //Время движения слайда
	    autoplayTimeout: 2000, //Время смены слайда
	    items: 1
	});*/

	/*$('.img-slider').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		dots: false,
		autoplay: false,
		items: 1,
		navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	});*/

	if(location.pathname.split('/')[1] == 'reg') {
		$.ajax({
			type: "GET",
			url: "https://www.google.com/recaptcha/api.js",
			dataType: "script",
			cache: true
		});
	}

	$('.bord').find('.btn-default').addClass('btn-yellow');

    /*$(function(){
        var namefile = $("#namefile").serialize();
        var btnUpload = $('#upload, .upload-img');
        var status = $('#status');
        new AjaxUpload(btnUpload, {
        action: 'upload-img-all.php',
        name: 'files[]',
        //dataType: 'JSON',
        dataType: false,
        timeout: 60000,
        multiple: true,
        onSubmit: function(file, ext){
            if (!(ext && /^(JPG|PNG|jpg|png|jpeg|gif)$/.test(ext))) { 
                // extension is not allowed 
                alert('Поддерживаемые форматы JPG, PNG или GIF');
                return false;
            }
            btnUpload.addClass('loading');
        },
        onComplete: function(file, response){
            //console.log('OUT JSON: '+response);
            btnUpload.removeClass('loading');

            if(response===""){
                alert('Ошибка загрузки');
            } else{
            	//console.log(response);
                $.each(JSON.parse(response), function(index, value) {
                    $('#files').append('<div class="add-image"><div class="img" style="background-image: url(/uploads/small/'+value+');"></div><div class="panel"><div class="up"><i class="fa fa-angle-left"></i></div><div class="down"><i class="fa fa-angle-right"></i></div><div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div><input name="'+value+'" class="input-main" type="hidden" value="0"><a target="_blank" href="/uploads/'+value+'"><i class="fa fa-link"></i>Посмотреть</a><div class="del-image"><i class="fa fa-close"></i>Удалить</div></div><input name="image[]" type="hidden" value="'+value+'"/></div>');
                });
            }
        }
        }); 
    });*/

	// Product Slider
	if ($('#prod-slider').length > 0) {
		initsliders(false, '');

		$('#prod-slider').on('click', '.prod-slider-zoom', function () {
			$('#prod-slider .slides .flex-active-slide .fancy-img').click();
			return false;
		});
	}

	// Fancybox Images
	$('.fancy-img').fancybox({
		padding: 0,
		margin: [60, 50, 20, 50],
		helpers: {
			overlay: {
				locked: false
			},
			thumbs: {
				width: 60,
				height: 60
			}
		},
		tpl: {
			closeBtn: '<a title="Close" class="fancybox-item fancybox-close modal-form-close2" href="javascript:;"></a>',
			prev: '<a title="Previous" class="fancybox-nav fancybox-prev modal-prev" href="javascript:;"><span></span></a>',
			next: '<a title="Next" class="fancybox-nav fancybox-next modal-next" href="javascript:;"><span></span></a>',
		}
	});

	// Product Tabs
	//$('body').on('click', '.prod-tabs li a', function () {
	$('.prod-tabs li a').click(function(){
		if ($(this).parent().hasClass('prod-tabs-addreview') || $(this).parent().hasClass('active') || $(this).attr('data-prodtab') == '')
			return false;
		$('.prod-tabs li').removeClass('active');
		$(this).parent().addClass('active');

		// mobile
		$('.prod-tab-mob').removeClass('active');
		$('.prod-tab-mob[data-prodtab-num=' + $(this).parent().data('prodtab-num') + ']').addClass('active');

		$('.prod-tab-cont .prod-tab').hide();
		$($(this).attr('data-prodtab')).fadeIn();

		return false;
	});

	// Show Properties
	//$('.prod-cont').on('click', '#prod-showprops', function () {
	$('#prod-showprops').click(function(){
		if ($('.prod-tabs li.active a').attr('data-prodtab') == '#prod-tab-2') {
			$('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
		} else {
			$('.prod-tabs li').removeClass('active');
			$('#prod-props').addClass('active');
			$('.prod-tab-cont .prod-tab').hide();
			$('#prod-tab-2').fadeIn();
			$('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
		}
		return false;
	});

	// Show Description
	//$('.prod-cont').on('click', '#prod-showdesc', function () {
	$('#prod-showdesc').click(function(){
		if ($('.prod-tabs li.active a').attr('data-prodtab') == '#prod-tab-1') {
			$('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
		} else {
			$('.prod-tabs li').removeClass('active');
			$('#prod-desc').addClass('active');
			$('.prod-tab-cont .prod-tab').hide();
			$('#prod-tab-1').fadeIn();
			$('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
		}
		return false;
	});

	// Product List Show Information
	$('.prod-li-information').click(function(){
		var product_info = $(this).parents('.prod-li').find('.prod-li-informations');
		$(this).toggleClass('opened');
		if (product_info.length) {
			product_info.slideToggle();
		}
		return false;
	});

	function set_cart_count(id, nums) {
		var uuid = $('div[data-uuid]').attr('data-uuid');
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: {
				'product_id': id,
				'nums': nums,
				'uuid': uuid,
			},
			//data: "",
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					$('#product'+id).find('.prod-li-total').html(response.product_summ);
					$('.cart-totals-val').html(response.total_summ);
					cart_update_header();
			    } else {
			    	notify(response.message);
			    }
			}
		});
	}

	var timerId = setTimeout(function(){}, 800);

	$('.qnt-wrap a').click(function(){
		var qnt = $(this).parent().find('input').val();
		var id = $(this).attr('data-id');
		if ($(this).hasClass('qnt-plus')) {
			qnt++;
		} else if ($(this).hasClass('qnt-minus')) {
			qnt--;
		}
		if (qnt > 0) {
			$(this).parent().find('input').val(qnt);
		}
		clearTimeout(timerId);
		timerId = setTimeout(() => set_cart_count(id, qnt), 800);
		return false;
	});

	$('.cart_nums').on('input', function(e){
		var id = $(this).attr('data-id');
		var nums = $(this).val();
		clearTimeout(timerId);
		timerId = setTimeout(() => set_cart_count(id, nums), 500);
		return false;
	});

	function set_balls(code, score) {
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: {
				'getPromoCode': code,
				'getBalls': score,
			},
			dataType: 'json',
			success: function(response) {
			    if(response.result == 1) {
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
			    } else {
			    	notify(response.message);
			    }
			    console.log(code, score);
			}
		});
	}


	$('#scores').on('input', function(e){
		var score = $(this).val();
		var code = $('#promo-text').val();
		clearTimeout(timerId);
		timerId = setTimeout(() => set_balls(code, score), 500);
		return false;
	});

	$('.del-promocode').click(function(){
		$.ajax({
			type: "POST",
			url: "/api/index.php",
			data: "delPromoCode=1",
			dataType: 'json',
			beforeSend: function(){
				NProgress.start(); 
			},
			success: function(response) {
				$.pjax.reload('#content', {
					"replace":false,
					"timeout":10000,
					"scrollTo":false,
				});
			}
		});
	});

	$('.link').click(function(){
		var link = $(this).attr('href');
		$.pjax({
			url: link, 
			container: '#content',
			"push":true,
			"replace":false,
			"timeout":30000,
			"scrollTo": false,
		});
	});

	$('.promo-send').click(function(){
		var code = $('#promo-text').val();
		$.ajax({
			type: "GET",
			url: "/api/index.php",
			data: "getPromoCode="+code,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start(); 
			},
			success: function(response) {
				if(response.result) {
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
				} else {
					NProgress.done(); 
					notify(response.message);
				}
				//document.getElementById("cart_nums").innerHTML = response.nums;
				//document.getElementById("cart_summ").innerHTML = response.summ;
				//$('.prod-li-total').html(response.summ);
			}
		});
	});

	$('.city_set').click(function(){
		var id = $(this).attr('data-id');
		$.ajax({
			type: "GET",
			url: "/api/index.php",
			data: "citySet="+id,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start(); 
			},
			success: function(response) {
				if(response.result) {
					window.location.href = window.location.pathname;
				} else {
					NProgress.done(); 
					notify(response.message);
				}
			}
		});
	});

	$('form.ajax-default').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		var url_location = location.href;
		//var action = $(this).attr('action');
		if($(this).attr('data-action')) {
			var dataurl = $(this).attr('data-action');
		} else {
			var dataurl = "/api/index.php";
		}

		$.ajax({
			type: "POST",
			url: dataurl,
			data: data + '&url=' + url_location,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start();
			},
			success: function(response) {
				NProgress.done();
				if(response.result) {
					/*$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});*/
					window.location.href = window.location.pathname;
				} else {
					notify(response.message);
				}
				//$this.find('.result').removeClass('loading');
			}
		});
		return false;
	});

	$('form.ajax-notice').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		var url_location = location.href;
		//var action = $(this).attr('action');
		if($(this).attr('data-action')) {
			var dataurl = $(this).attr('data-action');
		} else {
			var dataurl = "/api/index.php";
		}

		$.ajax({
			type: "POST",
			url: dataurl,
			data: data + '&url=' + url_location,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start();
			},
			success: function(response) {
				NProgress.done();
				if(response.result) {
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
				}
				notify(response.message);
			}
		});
		return false;
	});

	$('form.checkout').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		var url_location = location.href;
		//var action = $(this).attr('action');
		if($(this).attr('data-action')) {
			var dataurl = $(this).attr('data-action');
		} else {
			var dataurl = "/api/index.php";
		}

		$.ajax({
			type: "GET",
			url: dataurl,
			data: data + '&url=' + url_location,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start();
			},
			success: function(response) {
				if(response.result) {
					$.pjax({
						url: '/order/'+response.order_id, 
						container: '#content',
						"push":true,
						"replace":false,
						"timeout":30000,
						"scrollTo": false,
					});
				} else {
					NProgress.done();
					notify(response.message);
				}
			}
		});
		return false;
	});

	$('form.ajax-reg').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		var url_location = location.href;
		//var action = $(this).attr('action');
		if($(this).attr('data-action')) {
			var dataurl = $(this).attr('data-action');
		} else {
			var dataurl = "/api/index.php";
		}

		$.ajax({
			type: "POST",
			url: dataurl,
			data: data + '&url=' + url_location,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start();
			},
			success: function(response) {
				NProgress.done();
				if(response.result) {
					if(response.code) {
						window.location.href = window.location.pathname;
					} else {
						$('#verify_phone').fadeIn(0);
						$('#reg_button').fadeOut(0);
					}
				} else {
					notify(response.message);
				}
			}
		});
		return false;
	});

	$('#verify_phone').fadeOut(0);

	if ($('.content_carousel').length > 0) {
		$('.content_carousel').each(function () {
			if ($(this).data('slideshow_speed') != '') {
				var slideshow_speed =  $(this).data('slideshow_speed');
			} else {
				var slideshow_speed =  '7000';
			}
			if ($(this).data('animation_speed') != '') {
				var animation_speed =  $(this).data('animation_speed');
			} else {
				var animation_speed =  '600';
			}
			if ($(this).data('navigation') == true) {
				var navigation =  true;
			} else {
				var navigation =  false;
			}
			if ($(this).data('pagination') == true) {
				var pagination =  true;
			} else {
				var pagination =  false;
			}
			if ($(this).data('stop_on_hover') == true) {
				var stop_on_hover =  true;
			} else {
				var stop_on_hover =  false;
			}
			$('.content_carousel').flexslider({
				pauseOnHover: stop_on_hover,
				animationSpeed: animation_speed,
				slideshowSpeed: slideshow_speed,
				useCSS: false,
				directionNav: navigation,
				controlNav: pagination,
				animation: "fade",
				slideshow: false,
				animationLoop: true,
				smoothHeight: true
			});
		});
	}

	jQuery(document).ready(function(){
	 if (jQuery().waypoint) {
	  jQuery('.counter-i').waypoint(function () {
	   jQuery(this).find('.counter-i-val').each(function () {
	    var value = jQuery(this).data('value');
	    jQuery(this).countTo({from: 0, to: value, refreshInterval: 10, speed: 1000});
	   });
	  }, {
	   triggerOnce: true,
	   offset     : 'bottom-in-view'
	  });
	 } else {
	  jQuery(this).find('.counter-i-val').each(function () {
	   var value = jQuery(this).data('value');
	   jQuery(this).countTo({from: 0, to: value, refreshInterval: 10, speed: 1000});
	  });
	 }
	});

	if ($('.prod-add .variations select').length > 0) {
		$('.prod-add .variations select').chosen({
			disable_search_threshold: 10
		});
		$('.select-mod').change(function(e){
			e.preventDefault();
			var data = $('.select-mod-form').serialize();
			$.pjax({
				type: 'POST',
				url: window.location.pathname,
				container: '#content',
				data: data,
				push: true,
				replace: false,
				timeout: 30000,
				scrollTo: $('article').offset().top-50,
				//dataType: 'application/json',
			});
			scroll = 1;
		});
	}
	if ($('.section-top .products-per-page select').length > 0) {
		$('.section-top .products-per-page select').chosen({
			disable_search_threshold: 10
		});
	}
	if ($('.blog-sb-widget:not(.WOOF_Widget) select').length > 0) {
		$('.blog-sb-widget:not(.WOOF_Widget) select').chosen({
			disable_search_threshold: 10
		});
	}
	if ($('.shipping-calculator-form select').length > 0) {
		$('.shipping-calculator-form select').chosen({
			disable_search_threshold: 10
		});
	}

	//new WOW().init();



}
});
})();
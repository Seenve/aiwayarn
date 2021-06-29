(function($){
"use strict";
jQuery(document).ready(function($){

function $_GET(key) {
	var s = window.location.search;
	s = s.match(new RegExp(key + '=([^&=]+)'));
	return s ? s[1] : false;
}

function notify(text, color) {
	if(color == '') {
   		$("<div class='des-not'>"+text+"</div>'")
        .appendTo('#notify')
        .delay(4000)
        .queue(function() {
            $(this).remove();
        });
	} else {
   		$("<div class='des-not' style='background:#"+color+"'>"+text+"</div>'")
        .appendTo('#notify')
        .delay(4000)
        .queue(function() {
            $(this).remove();
        });
	}
}

var plug = 0;
var scroll_page;
var watermark = false;

if ($.support.pjax) {
	console.log('ajax: true');
	$(document).on('ready pjax:success', function() {
		$('a[data-pjax]').removeClass('active');
		jQuery('a').each(function() {
			var seturl = '/ap/'+window.location.search;
			var outurl = '/ap/?page='+$_GET('page');
	        if (jQuery(this).attr('href') == seturl || jQuery(this).attr('href') == outurl) {
	        	jQuery(this).addClass('active');
	        }
	    });
		plugins();
		NProgress.done();
		/*window.location.hash = $('#in-page-nav a').eq(0).attr('href');
		if(window.location.hash) {
			$('html, body').animate({ scrollTop: $('#in-page-nav').offset().top }, 1000);
		}*/
	});
	$(document).on('pjax:start', function() {
		NProgress.start(); 
	});
	$(document).on('pjax:end',   function() { 
		NProgress.done(); 
		$('input[name=pageto]').val(window.location.pathname);

		if(scroll_page == 1) {
		} else if(scroll_page) {
			jQuery('html, body').animate({scrollTop: $(scroll_page).offset().top}, 0);
		} else {
			jQuery('body, html').animate({scrollTop: 0}, 0);
		}
		scroll_page = 0;
		/*if ($_GET('page') == 'novostroiki') {
			jQuery("html, body").animate({scrollTop: jQuery('.nov-b').offset().top - 0}, 0);
		} */
	});
	$(document).on('click', 'a[data-pjax]', function() {
		$('a').removeClass('active');
		$(this).addClass('active');
		var urlen = $(this).attr('href');
		var container = $(this).attr('data-pjax');
		scroll_page = $(this).attr('data-scroll');
		/*if(urlen == '/ipoteka') {
			document.location.href = "/ipoteka";
			$("#preloader").fadeIn(0);
			return false;
		}*/
		$.pjax({
			url: urlen, 
			container: '#'+container,
			"push":true,
			"replace":false,
			"timeout":30000,
			"scrollTo": false,
		});
		document.getElementById('dropdown-toggle').click();
		document.getElementById('nprogress').parentNode.removeChild(document.getElementById('nprogress'));
		$(".overlay, .overlay2").click();
		//yaCounter47264181.hit(urlen);
		return false;
	});
	$(document).on('submit', 'form[data-pjax]', function(event) {
		var container = jQuery(this).attr('data-pjax');
		event.preventDefault();
		$.pjax.submit(event, '#'+container, {"timeout":30000,});
		return false;
	});
} else {
	console.log('ajax: false');
	plugins();
}

	jQuery('a').each(function() {
		var seturl = '/ap/'+window.location.search;
		var outurl = '/ap/?page='+$_GET('page');
        if (jQuery(this).attr('href') == seturl || jQuery(this).attr('href') == outurl) {
            jQuery(this).addClass('active');
        }
    });

	jQuery(".preloader").delay(200).fadeOut("slow");
	jQuery('.overlay, .result_success, .result_error, #add-main, .result').fadeOut(0);

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

	$('.logout').click(function(event) {
		$.ajax({
			type: "POST",
			url: "/ap/ajax-auth.php",
			data: "logout=1",
			dataType: 'json',
			beforeSend: function(){
				$(".preloader").fadeIn("slow");
			},
			success: function(response) {
				console.log(response);
				document.getElementById('dropdown-toggle').click();
				setTimeout(function(){
					window.location.href = '/ap/'+window.location.search;
				}, 1000);
			}
		});
		return false;
	});

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

function plugins() {

	$.mask.definitions['9'] = '';
	$.mask.definitions['N'] = '[0-9]';
	$('input[name="phone"], input[name="phone_messanger"]').mask('+7 (NNN) NNN-NN-NN', {autoclear: true});

    $('.overlay, .result_success, .result_error, .result').fadeOut(0);

	// Product Slider
	if ($('#prod-slider').length > 0) {
		initsliders(false, '');

		$('#prod-slider').on('click', '.prod-slider-zoom', function () {
			$('#prod-slider .slides .flex-active-slide .fancy-img').click();
			return false;
		});
	}

	$('.confirm-form').on("click", function() {
		swal({
			title: "Успешно обновлено",
			type: "success",
			cancel: true,
			html: "html",
			confirmButtonColor: "#4a77a8",
			cancelButtonText: "ыы",
			confirmButtonText: "Продолжить",
		});
	});

	$('.ajax-confirm').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		if($(this).attr('action')) {
			var dataurl = $(this).attr('action');
		} else {
			var dataurl = "/ap/forms.php";
		}

		$this.find('button[type=submit]').addClass('is-loading');

		Swal.fire({
			title: $(this).attr('data-title'),
			text: $(this).attr('data-text'),
			type: $(this).attr('data-type'),
			showCancelButton: true,
			confirmButtonText: $(this).attr('data-text-confirm'),
			cancelButtonText: $(this).attr('data-text-cancel')
		}).then((result) => {
			//console.log(result);
			if (result.value) {
				$.ajax({
					type: "POST",
					url: dataurl,
					data: data,
					dataType: 'json',
					beforeSend: function(){
						NProgress.start();
						$this.find('input, button, textarea').prop("disabled", true);
					},
					success: function(response) {
						console.log(response);
						/*if(response.scroll) {
							scroll_page = response.scroll;
						}*/
						scroll_page = 1;
						NProgress.done();
						$this.find('button[type=submit]').removeClass('is-loading');
						//console.log(response);
						if(response.redirect) {
							$.pjax({
								url: response.redirect, 
								container: '#content',
								"push":true,
								"replace":false,
								"timeout":30000,
								"scrollTo": false,
							});
						} else if(response.reload) {
							$.pjax.reload('#content', {
								"replace":false,
								"timeout":10000,
								"scrollTo":false,
							});
						}
						Swal.fire({
							title: response.title,
							text: response.message,
							type: response.type,
							cancel: true,
							//html: "html",
							confirmButtonColor: "#4a77a8",
							confirmButtonText: "Продолжить",
						});
						$this.find('input, button, textarea').prop("disabled", false);
					}
				});
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				$this.find('button[type=submit]').removeClass('is-loading');
			}
		});
		return false;
	});


	$('.ajax-edit').submit(function() {
		if($("textarea").is("#editor")) {
			CKEDITOR.instances['editor'].updateElement();
		}
		$("textarea.ckeditor").each(function(){
	   		var id = $(this).attr('id'); 
	   		CKEDITOR.instances[id].updateElement();
	   		//CKEDITOR.replace(id, {contentsCss : ['/assets/css/style.css']}); 
	   	});

		//for(var instanceName in CKEDITOR.instances)
		//    CKEDITOR.instances[instanceName].updateElement();

		var data = $(this).serialize();
		var $this = $(this);
		if($(this).attr('action')) {
			var dataurl = $(this).attr('action');
		} else {
			var dataurl = "/ap/forms.php";
		}

		$.ajax({
			type: "POST",
			url: dataurl,
			data: data,
			dataType: 'json',
			beforeSend: function(){
				NProgress.start();
				$this.find('button[type=submit]').addClass('is-loading');
				$this.find('input, button, textarea').prop("disabled", true);
			},
			success: function(response) {
				console.log(response);
				NProgress.done();
				if(response.redirect) {
					$.pjax({
						url: response.redirect, 
						container: '#content',
						"push":true,
						"replace":false,
						"timeout":30000,
						"scrollTo": false,
					});
				} else if(response.reload) {
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
				}
				Swal.fire({
					title: response.title,
					text: response.message,
					type: response.type,
					cancel: true,
					confirmButtonColor: "#4a77a8",
					confirmButtonText: "Продолжить",
				});
				$this.find('button[type=submit]').removeClass('is-loading');
				$this.find('input, button, textarea').prop("disabled", false);
			}
		});
		return false;
	});

	$('form.ajax').submit(function() {
		if($("textarea").is("#editor")) {
			CKEDITOR.instances['editor'].updateElement();
		}
		/*$('textarea.ckeditor').each(function () {
			var $textarea = $(this);
			$textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
		});*/

		$("textarea.ckeditor").each(function(){
	   		var id = $(this).attr('id'); 
	   		CKEDITOR.instances[id].updateElement();
	   		//CKEDITOR.replace(id, {contentsCss : ['/assets/css/style.css']}); 
	   	});


		var data = $(this).serialize();
		var $this = $(this);
		if($(this).attr('action')) {
			var dataurl = $(this).attr('action');
		} else {
			var dataurl = "/ap/forms.php";
		}
		$.ajax({
			type: "POST",
			url: dataurl,
			data: data,
			dataType: 'json',
			beforeSend: function(){
				$this.find('button[type=submit]').addClass('is-loading');
				$this.find('input, button, textarea').prop( "disabled", true );
			},
			success: function(response) {
				if(response.scroll) {
					scroll_page = response.scroll;
				}
				console.log(response);
				$this.find('button[type=submit]').removeClass('is-loading');
	            if(response.result == 1) {
	            	if($this.find('.result_success').length > 0) {
						$this.find('.result_success').html(response.message);
						$this.find('.result_success').slideDown(300);
						//setTimeout(function() {
						//	$this.find('.result_success').slideUp(300);
						//}, 3000);
					} else {
						$('.overlay').fadeIn(200, function() {
							$('#result').css('display', 'flex');
						});
						//$('#blur').addClass('active');
						$('#result_text').html(response.message);
					}
					if(response.notify == false) {} else {
						notify(response.message);
					}
					if(response.reload) {
						//setTimeout(function() {
							//location.reload();
							$.pjax.reload('#content', {
								"replace":false,
								"timeout":10000,
								"scrollTo":false,
							});
						//}, 1000);
					}
					$this.find('input, button, textarea').prop( "disabled", false );
				} else if (response.result == 'echo') {
		        	$this.find('.result').html(response.message);
		        	$this.find('.result').slideDown(300);
					setTimeout(function() {
						$this.find('.result').slideUp(300);
					}, 3000);
					$this.find('input, button, textarea').prop( "disabled", false );
		        } else if (response.result == 'auth') {
		        	$('#code').val(response.message);
			        $('.overlay').fadeIn(200, function() {
			            $('#auth_code').css('display', 'flex');
			        });
		        } else {
		        	$this.find('input, button, textarea').prop( "disabled", false );
		        	if($this.find('.result_success').length > 0) {
		        		//$this.find('.invalid-feedback').slideDown(300);

			        	$this.find('.result_error').html(response.message);
			        	$this.find('.result_error').slideDown(300);
						setTimeout(function() {
							$this.find('.result_error').slideUp(300);
						}, 3000);
					} else {
			        	$('#result').html(response.message);
					}
		        }
			}
		});
		return false;
	});

	$("input, textarea").change(function() {
		$(this).parents('form').addClass('was-validated');
	});

    $('#add-main').fadeOut(0);
	$('#button-main').click(function(){
		if(!$(this).hasClass('active')){
			$('#blocks-main').fadeOut(200, function(){
				$('#add-main').fadeIn(200);
			});
			$(this).addClass('active');
			//open
		} else {
			$('#add-main').fadeOut(200, function(){
				$('#blocks-main').fadeIn(200);
			});
			$(this).removeClass('active');
			//close
		}
	});

	$('.search-form-ajax button').click(function(){
		if($('.search-form-ajax').hasClass('active')) {
			$('.search-results').fadeOut(0, function(){
				$('.pagination').fadeIn(0);
				$('.content-blocks').fadeIn(0);
				$('.search-form-ajax').removeClass('was-validated');
				$('.search-input').val('');
				$('.search-form-ajax').removeClass('active');
			});
		}
		return false;
	});

	$('.search-results').fadeOut(0);
	var timer_search;
    $('.search-input').keyup(function(e) {
        e.preventDefault();
        window.clearTimeout(timer_search);
        var text = $('.search-input').val();
        if(text) {
			timer_search = setTimeout(function () {
				$('.content-blocks').fadeOut(0, function(){
					$('.pagination').fadeOut(0);
					$('.search-results').fadeIn(0);
					$('.search-form-ajax').addClass('active');
					$('.search-form-ajax').removeClass('was-validated');
				});
				var data = $('.search-form-ajax').serialize();
				$.ajax({
					type: "POST",
					url: "forms.php",
					data: data,
					beforeSend: function() {
						NProgress.start();
					},
					success: function(data) {
						NProgress.done();
						$(".search-results").html(data);
					}
				});
		   }, 500);
        } else {
			$('.search-results').fadeOut(0, function(){
				$('.pagination').fadeIn(0);
				$('.content-blocks').fadeIn(0);
				$('.search-form-ajax').removeClass('active');
				$('.search-form-ajax').removeClass('was-validated');
			});
        }
        return false;
    });

   	if(document.getElementById('editor')) {
		CKEDITOR.replace( 'editor',{
			contentsCss : ['/assets/css/style.css']
		}); 
   	}

	$("textarea.ckeditor").each(function(){
   		var id = $(this).attr('id'); 
   		//CKEDITOR.instances[id].updateElement();
   		CKEDITOR.replace(id, {contentsCss : ['/assets/css/app.css']}); 
   	});


	watermark = false;
	$('input[name="watermark"]').each(function(e){
   		if($(this).is(':checked')) {
   			watermark = true;
   		}
   	});

   	if(document.getElementById('upload')) {
		var btnUpload = $('#upload, .upload-img');
	   	new AjaxUpload(btnUpload, {
	        action: 'upload-img-all.php?watermark='+watermark,
	        name: 'files[]',
	        //dataType: 'JSON',
	        dataType: false,
	        timeout: 60000,
	        multiple: true,
	        onSubmit: function(file, ext){
	            if (!(ext && /^(JPG|PNG|jpg|png|jpeg|gif|webp)$/.test(ext))) { 
	                alert('Поддерживаемые форматы JPG, PNG или GIF');
	                return false;
	            }
	            btnUpload.addClass('is-loading');
	            console.log(file);
	            console.log(watermark);
	        },
	        onComplete: function(file, response){
	            console.log('json: '+response);
	            console.log(watermark);
	            btnUpload.removeClass('is-loading');
	            if(response === ""){
	                alert('Ошибка загрузки');
	            } else{
	                $.each(JSON.parse(response), function(index, value) {
	                    $('#files').append('<div class="add-image"><div class="img" style="background-image: url(/uploads/images/jpeg/'+value+'-300x200.jpeg);"></div><div class="panel"><div class="up"><i class="fa fa-angle-left"></i></div><div class="down"><i class="fa fa-angle-right"></i></div><div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div><input name="'+value+'" class="input-main" type="hidden" value="0"><a target="_blank" href="/uploads/images/jpeg/'+value+'-1920x1080.jpeg"><i class="fa fa-link"></i>Посмотреть</a><div class="del-image"><i class="fa fa-close"></i>Удалить</div></div><input name="image[]" type="hidden" value="'+value+'"/></div>');
	                });
	            }
	        }
	    }); 
	}

	var arrUploads = [];
	var i = 0;

   	if(document.getElementById('upload')) {

		$(".upload-custom").each(function(e) {
			var $this = $(this);
			arrUploads[i] = $this;


			
		   	new AjaxUpload(arrUploads[i], {
		        action: 'upload-img-all.php',
		        name: 'files[]',
		        //dataType: 'JSON',
		        dataType: false,
		        timeout: 60000,
		        multiple: true,
		        onSubmit: function(file, ext, e){
		            if (!(ext && /^(JPG|PNG|jpg|png|jpeg|gif|webp)$/.test(ext))) { 
		                alert('Поддерживаемые форматы JPG, PNG или GIF');
		                return false;
		            }
		            console.log(arrUploads[i]);
		            arrUploads[i].addClass('is-loading');
		        },
		        onComplete: function(file, response, e){
		            console.log('json: '+response);
		            arrUploads[i].removeClass('is-loading');
		            console.log(e);
		            if(response === ""){
		                alert('Ошибка загрузки');
		            } else{
		                $.each(JSON.parse(response), function(index, value) {
		                    arrUploads[i].siblings('.files').append('<div class="add-image"><div class="img" style="background-image: url(/uploads/images/jpeg/'+value+'-300x200.jpeg);"></div><div class="panel"><div class="up"><i class="fa fa-angle-left"></i></div><div class="down"><i class="fa fa-angle-right"></i></div><div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div><input name="'+value+'" class="input-main" type="hidden" value="0"><a target="_blank" href="/uploads/images/jpeg/'+value+'-1920x1080.jpeg"><i class="fa fa-link"></i>Посмотреть</a><div class="del-image"><i class="fa fa-close"></i>Удалить</div></div><input name="'+$this.attr('data-name')+'" type="hidden" value="'+value+'"/></div>');
		                });
		            }
		        }
		    }); 
		    i++;
	    });

	}

	$('.add-input > button').click(function(){
		$('#inputs').append('<div class="ainput"><input class="form-control" type="text" name="input[]"><div class="del-input"><i class="fal fa-times"></i></div></div>');
		return false;
	});

	$('.add-character > button').click(function(){

		var num = $('.add-character').attr('data-num');
		var num_ch = num+1;
		$('.add-character').attr('data-num', num_ch);
		$('#characters').append('<div class="ainput acharacter"><input class="form-control" type="text" name="character['+num_ch+'][]" value="" placeholder="Пример: Вес"><input class="form-control" type="text" name="character['+num_ch+'][]" value="" placeholder="Пример: 200 гр"><div class="del-input"><i class="fal fa-times"></i></div></div>');
		return false;
	});

	if(document.getElementById('iqChart')) {
		load_modules_main();
	}

	if(document.getElementById('menu_edit')) {

		$('.close-edit-menu').click(function(){
			$(this).parents('.nestable-handle').eq(0).removeClass('edit');
			return false;
		});

		$('.btn-edit-menu').click(function(){
			$(this).parents('.nestable-handle').eq(0).addClass('edit');
			return false;
		});

		$('.save-edit-menu').click(function(){
			var id = $(this).attr('data-id');
			var name = $('input[data-name='+id+']').val();
			var murl = $('input[data-url='+id+']').val();
			var dataurl = "/ap/forms.php";
			scroll_page = 1;
			$.ajax({
				type: "POST",
				url: dataurl,
				data: {
					'menu_edit': 1,
					'id': id,
					'name': name,
					'url': murl,
				},
				dataType: 'json',
				beforeSend: function(){
					$(this).addClass('is-loading');
				},
				success: function(response) {
					console.log(response);
					$(this).removeClass('is-loading');
		            if(response.result == 1) {

						notify(response.message);
						if(response.reload) {
							//setTimeout(function() {
								//location.reload();
								$.pjax.reload('#content', {
									"replace":false,
									"timeout":10000,
									"scrollTo":false,
								});
							//}, 1000);
						}
					} else {

					}
				}
			});
			return false;
		});
	}

	if(document.getElementById('nestableMenu')) {

		function menu_updatesort(jsonstring) {
	        $.ajax({
	            type: "POST",
	            url: "/ap/forms.php",
	            data: "menu_save=1&jsonstring="+jsonstring+"&rand=" + Math.random()*9999,
	            //dataType: 'json',
	            beforeSend: function(){
	                //console.log('Отправка меню...');
	                scroll_page = 1;
	            },
	            success: function(response) {
	            	console.log(response);
	                //console.log('Меню отправлено.');
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
	                notify('Успешно обновлено');
	            }
	        });
		}

		var tt = 0;
		var updateOutput = function(e)
		{
			var list   = e.length ? e : $(e.target),
				output = list.data('output');
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				if(tt > 0) {
					menu_updatesort(window.JSON.stringify(list.nestable('serialize')));
				}
				tt++;
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};
		
		// activate Nestable for list menu
		$('#nestableMenu').nestable({
	        group: 1,
	        maxDepth: 4,
	        rootClass: "nestable",
	        listNodeName: "ul",
	        listClass: "nestable-list",
	        itemClass: "nestable-item",
	        dragClass: "nestable-drag",
	        handleClass: "nestable-handle",
	        collapsedClass: "nestable-collapsed",
	        placeClass: "nestable-placeholder",
	        emptyClass: "nestable-empty"
		})
		.on('change', updateOutput);

		updateOutput($('#nestableMenu').data('output', $('#nestableMenu-output')));

		$('#nestable-menu').on('click', function(e)
		{
			var target = $(e.target),
				action = target.data('action');
			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
		});

	}

	if(document.getElementById('nestable_products_category')) {

		function menu_updatesort(jsonstring) {
	        $.ajax({
	            type: "POST",
	            url: "/ap/forms.php",
	            data: "category_save=1&jsonstring="+jsonstring+"&rand=" + Math.random()*9999,
	            //dataType: 'json',
	            beforeSend: function(){
	                //console.log('Отправка меню...');
	                scroll_page = 1;
	            },
	            success: function(response) {
	            	console.log(response);
	                //console.log('Меню отправлено.');
					$.pjax.reload('#content', {
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
	                notify('Успешно обновлено');
	            }
	        });
		}

		var tt = 0;
		var updateOutput = function(e)
		{
			var list   = e.length ? e : $(e.target),
				output = list.data('output');
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				if(tt > 0) {
					menu_updatesort(window.JSON.stringify(list.nestable('serialize')));
				}
				tt++;
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};
		
		// activate Nestable for list menu
		$('#nestable_products_category').nestable({
	        group: 1,
	        maxDepth: 2,
	        rootClass: "nestable",
	        listNodeName: "ul",
	        listClass: "nestable-list",
	        itemClass: "nestable-item",
	        dragClass: "nestable-drag",
	        handleClass: "nestable-handle",
	        collapsedClass: "nestable-collapsed",
	        placeClass: "nestable-placeholder",
	        emptyClass: "nestable-empty"
		})
		.on('change', updateOutput);

		updateOutput($('#nestable_products_category').data('output', $('#nestableMenu-output')));

		$('#nestable_products_category').on('click', function(e)
		{
			var target = $(e.target),
				action = target.data('action');
			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
		});

	}


	console.log('plugins: loaded');

}

//prodcuts_category сортировка


   /*if (!window.Clipboard) {
        var pasteCatcher = document.createElement("div");

        pasteCatcher.setAttribute("contenteditable", "");

        pasteCatcher.style.display = "none";
        document.body.appendChild(pasteCatcher);

        pasteCatcher.focus();
        document.addEventListener("click", function() { pasteCatcher.focus(); });
    }*/
    window.addEventListener("paste", pasteHandler);

    function pasteHandler(e) {
        if (e.clipboardData) {
            var items = e.clipboardData.items;
            if (items) {
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") !== -1) {
                        var blob = items[i].getAsFile();
                        var URLObj = window.URL || window.webkitURL;
                        var source = URLObj.createObjectURL(blob);
                        if(document.getElementById('files')) {             
                        	uploadImage(blob);
                   	 	}
                    }
                }
            }
		}
    }

	function uploadImage(source) {
		var btnUpload = $('#upload, .upload-img');
	    var form_data = new FormData();                  
	    form_data.append('files[]', source);
	    //console.log(form_data);                             
	    $.ajax({
	        url: 'upload-img-all.php', 
	        dataType: 'text', 
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: form_data,                         
	        type: 'POST',
	        beforeSend: function(){
	        	btnUpload.addClass('is-loading');
	        },
	        success: function(response){
	        	console.log(response);
	            //console.log('json: '+response);
	            btnUpload.removeClass('is-loading');
	            if(response === ""){
	                alert('Ошибка загрузки');
	            } else{
	                $.each(JSON.parse(response), function(index, value) {
	                    $('#files').append('<div class="add-image"><div class="img" style="background-image: url(/uploads/images/jpeg/'+value+'-300x200.jpeg);"></div><div class="panel"><div class="up"><i class="fa fa-angle-left"></i></div><div class="down"><i class="fa fa-angle-right"></i></div><div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div><input name="'+value+'" class="input-main" type="hidden" value="0"><a target="_blank" href="/uploads/images/jpeg/'+value+'-1920x1080.jpeg"><i class="fa fa-link"></i>Посмотреть</a><div class="del-image"><i class="fa fa-close"></i>Удалить</div></div><input name="image[]" type="hidden" value="'+value+'"/></div>');
	                });
	            }
	        }
	    });
	}

/*

	$('.search-form').submit(function() {
		var data = $(this).serialize();
		var $this = $(this);
		$('.nvs .col').fadeOut(0, function(){
			$('.nvs .col.search').css('display','flex');
		});
		$.ajax({
			type: "POST",
			url: "forms.php",
			data: data,
			beforeSend: function() {
				$this.find('.result').addClass('loading');
			},
			success: function(data) {
				$this.find('.result').removeClass('loading');
				$(".nvs").html(data);
			}
		});
		return false;
	});
	$('.search-form .close-search').click(function(){
		$(this).css('display','none');
		$('.col.search').remove();
	});

	$("#open-map").click(function() {
		$('.map').toggleClass("active");
		if ($('.map').hasClass('active')) {
			$(this).text('Скрыть карту');
		} else {
			$(this).text('Показать карту');
		}
		return false;
	});

	$("#address").on("click",function(e){
		var res = $("#popup-coors").val();
		$.ajax({
			type: "POST",
			url: "forms.php",
			data: "geocode="+res,
			dataType: 'json',
			success: function(response) {
				$('#address').html('&nbsp;&nbsp;'+response.address+'&nbsp;&nbsp;');
				$('#address_i').val(response.address);
				$('#district').val(response.district);
				$('#street').val(response.street);
				$('#city').val(response.city);
			}
		});
	});

	$('.add-platform').fadeOut(0);
	$('#street_select').change(function() {
		var street_select = $('#street_select').val();
		if(street_select == 'add') {
			$('#add_street').fadeIn(300);
		}
    });
    $(".close-add").on("click",function(e){
    	$('#add_street').fadeOut(300);
    });

	$(".add-street").on("click",function(e){
		var res = $("#add_name_street").val();
		$.ajax({
			type: "POST",
			url: "forms.php",
			data: "street_add=1&street="+res,
			//dataType: 'json',
			success: function(data) {
				$('#street_select').html(data);
				$('#add_street').fadeOut(600);
			}
		});
	});
	*/

	$(document).on("click", '.del-input', function(){
		$(this).parents('.ainput').remove();
		return false;
	});

	$(document).on("click", '.del-image', function(){
		$(this).parents('.add-image').remove();
		return false;
	});

	$(document).on("click", '.add-main', function(){
		$('.input-main').val('0');
		$(this).siblings('.input-main').val('1');
		$('.add-image').removeClass('active');
		$(this).parents('.add-image').addClass('active');
		return false;
	});

    $(document).on("click", '.up', function(e){
    	$(this).parent('div').parent('div').removeClass('move');
    	$(this).parent('div').parent('div').addClass('move');
        var pdiv = $(this).parent('div').parent('div');
        pdiv.insertBefore(pdiv.prev());
        return false
    });

    $(document).on("click", '.down', function(e){
    	$(this).parent('div').parent('div').removeClass('move');
    	$(this).parent('div').parent('div').addClass('move');
        var pdiv = $(this).parent('div').parent('div')
        pdiv.insertAfter(pdiv.next());
        return false
    });


});
})();
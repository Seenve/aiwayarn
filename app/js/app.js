/*$(document).ready(function(){

// if(window.location.pathname=='/' && window.width() <= 992 ){
//     setTimeout(function(){
//         if($('.nav__list-item').hasClass('nav__hide')) {
//                $('.nav__list-item').slideToggle();
//                //$('.nav__list .nav__item').first().trigger('click');
//             }
//     }, 200);
// }
// else {
//     alert('dwad');
// } 


    //form
    $('form.ajax').submit(function() {
        var data = $(this).serialize();
        var $this = $(this);
        //var action = $(this).attr('action');
        if($(this).attr('data-action')) {
            var dataurl = $(this).attr('data-action');
        } else {
            var dataurl = "/engine/forms.php";
        }

        var input = $(this).find('input[type=checkbox]');
        if (!input.prop('checked')) {
            alert('Подтвердите политику конфиденциальности');
            $('span.checkbox__checked').css("opacity", "1");
            return false;
        } else {
            $('span.checkbox__checked').css("opacity", "0");
            $.ajax({
                type: "POST",
                url: dataurl,
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $this.find('button[type=submit]').addClass('loading');
                    $this.find('input, button, textarea').prop( "disabled", true);
                },
                success: function(response) {
                    $this.find('button[type=submit]').removeClass('loading');
                    if(response.result == 1) {
                        if($this.find('.modal__success').length > 0) {
                            $this.find('.modal__success').addClass('active');
                            setTimeout(function() {
                                $('.modal').fadeOut(200);
                                $this.find('.modal__success').removeClass('active');
                                $this.find('input, button, textarea').prop( "disabled", false);
                            }, 10000);
                        } else {
                            $this.find('.msg_success').html(response.message);
                            $this.find('.msg_success').fadeIn(200);
                            setTimeout(function() {
                                $this.find('input, button, textarea').prop( "disabled", false);
                            }, 10000);
                        }
                        return false;
                    } else {
                        alert(response.message);
                        $this.find('input, button, textarea').prop( "disabled", false);
                    }
                }
            });
        }
        return false;
    });

    // selector
    $('.selector').on('click', 'div', function(e) {
        var $this = $(this);
        $this.parent().toggleClass('active');
    });
    $('.selector').on('click', 'ul li', function(e) {
        var $this = $(this);
        $this.parents('.selector').find('.selector__value').val($this.attr('data-id'));
        $this.parents('.selector').removeClass('active');
        $this.parents('div').find('span').html($this.html());
        $this.parents('form').submit();
    });

    function $_GET(key) {
        var s = window.location.href;
        s = s.match(new RegExp(key + '=([^&=]+)'));
        return s ? s[1] : false;
    }

    $('.nav__list .nav__item').first().on('click', function(){
        if($('.nav__list-item').hasClass('nav__hide') && $(window).width() <= 992 || window.location.pathname != "/"){
            $(this).find('.nav__list-item.nav__hide').slideToggle();
            // return false;
        } else if ($(window).width() <= 992) {
            $(this).find('.nav__list-item').slideToggle();
        } 
    });

    $('.nav__list .nav__list-item .list-items__link').on('click', function(){
        $('.nav__list-item.nav__hide').slideToggle();
    });

    if(!$('.nav__list-item').hasClass('nav__hide')) {
        $('.nav__list-item').slideToggle();
    }

    
// HEADER MENU START
$(document).on('click', function(e){
    
        if ($(e.target).is($('.top-header .nav-toogle')) || $('.top-header .nav-toogle').has(e.target).length){
          $('.nav-toogle').toggleClass('active');
        
            if ($('.nav-toogle').hasClass('active')) {
                
              $('.sidebar').addClass('is_visible');
              $('body').addClass('not-scroll');
          
            } else {
                $('.sidebar').removeClass('is_visible');
                $('.sidebar_level_2').removeClass('is_visible');
                $('.sidebar_level_3').removeClass('is_visible');
                $('.sidebar_level_4').removeClass('is_visible');
                $('body').removeClass('not-scroll');
            }
        } 

        else {
                var block = $(".sidebar_container");
                    if (!block.is(e.target) && block.has(e.target).length === 0 ) {
                        $('.sidebar').removeClass('is_visible');
                        $('.sidebar_level_2').removeClass('is_visible');
                        $('.sidebar_level_3').removeClass('is_visible');
                        $('.sidebar_level_4').removeClass('is_visible');
                        $('.nav-toogle').removeClass('active');
                        $('body').removeClass('not-scroll');
                    }
            }
      });

    // lvl2
        $('.btn_level_2').on('click', function(){
            $('.sidebar_level_2').addClass('is_visible');
        });
        
        $('.sidebar_level_2 [data-target]').on('click', function(event){
            event.preventDefault();
            var target = $(this).attr('data-target');
            var title = $(this).text();
            $('.sidebar_level_3 .sidebar_header .sidebar_header_title h4').text(title);
            $('.sidebar_level_3 [data-id]').hide();
            $('.sidebar_level_3 [data-id='+target+']').show();
            $('.sidebar_level_3').addClass('is_visible');
         });
            
         $('.btn_level_4').on('click', function(){
             $('.sidebar_level_4').addClass('is_visible');
          });

    // Р·Р°РєСЂС‹С‚РёРµ РїСЂРё РЅР°Р¶Р°С‚РёРё РЅР° Р·Р°РіРѕР»РѕРІРѕРє
    $('.sidebar_level_2 .sidebar_header').on('click', function(e){
        $('.sidebar_level_2').removeClass('is_visible');
    });
    
    $('.sidebar_level_3 .sidebar_header').on('click', function(e){
        $('.sidebar_level_3').removeClass('is_visible');
    });

    $('.sidebar_level_4 .sidebar_header').on('click', function(e){
     $('.sidebar_level_4').removeClass('is_visible');
 }); 
// HEADER MENU END


    $(".hero-slider").owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        autoplay:false,
        margin: 15,
        autoplayTimeout: 4000
    });
    

    $('.hero-slider__navigation .prev').click(function() {
        $('.hero-slider').trigger('prev.owl.carousel');
    });

    $('.hero-slider__navigation .next').click(function() {
        $('.hero-slider').trigger('next.owl.carousel');
    });


    $('.special-navigate .prev').click(function() {
        $('.special-carousel').trigger('prev.owl.carousel');
    });

    $('.special-navigate .next').click(function() {
        $('.special-carousel').trigger('next.owl.carousel');
    });


    setTimeout(function(){
        $('.tabs').each(function(e){
            $(this).find('.js-tab-trigger:first').trigger('click');
        });
    }, 200);

    $('.js-tab-trigger').click(function(e) {
        e.preventDefault();
        var $this = $(this),
            id = $this.attr('data-tab'),
            $tabs = $this.parents('.tabs');

        $tabs.find('.js-tab-trigger.active').removeClass('active');
        $this.addClass('active');

        $tabs.find('.js-tab-content').removeClass('active');
        $tabs.find('.js-tab-content[data-tab='+id+']').addClass('active');

        if ($tabs.find('.js-tab-content').hasClass('active')) {
            console.log('sdasdasdasdsdasdas');
            $tabs.find('.js-tab-content').find('.special-carousel').trigger('destroy.owl.carousel');
            $tabs.find('.js-tab-content.active').find('.special-carousel').owlCarousel({
                items: 4,
                loop: false,
                responsive: {
                    0 : {
                    items:1,
                    margin: 0,
                    },
                    480 : {
                        items:1,
                    },
                    768 : {
                        items:2,
                    },
                    1024: {
                        items:3,
                    },
                    1300: {
                        items:4
                    }
                }    
            });
        } else if ($tabs.find('.js-tab-content').not('active')) {
            $('.special__body').innerHTML('<h5>!!!</h5>');
        }

    });

    if ($(window).width() <= 992) { 
        setTimeout(function(){
            // $('.special__btn').trigger('click');
            //$('.tab-header.index').slideUp(200);
        }, 200);
    
        $('.special__btn').on('click', function(){
            $(this).siblings('.tab-header').stop().slideToggle(200);
        
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                $(this).find('svg').addClass('rotate--90');        
            } else {
                $(this).removeClass('active');
                $(this).find('svg').removeClass('rotate--90');
            }
        });
    }


    if ($(window).width() >= 992) {
        var front = '.main-catalog__descriptions',
            back = ".main-catalog__btn";
            $('.main-catalog__item').hover(
                function(){
                    $(this).find(front).fadeOut(1);
                    $(this).find(back).delay(1).fadeIn(1);
                },
                function(){
                    $(this).find(back).fadeOut(1);
                    $(this).find(front).delay(1).fadeIn(1);
                }
            );
    }

    $('.news-carousel').owlCarousel({
        items: 4,
        nav: false,
        loop: true,
        dots: false,
        autoplay:false,
        margin: 15,
        autoplayTimeout: 4000,
        responsive: {
            0 : {
                items:1,
                margin: 0,
                dots: true
            },
            480 : {
                items:1,
            },
            768 : {
                items:2,
            },
            1024: {
                items:4,
            }
        }  
    });
    
    $('.news-navigate .prev').click(function() {
        $('.news-carousel').trigger('prev.owl.carousel');
    });
    
    $('.news-navigate .next').click(function() {
        $('.news-carousel').trigger('next.owl.carousel');
    });


    $(document).on('click', '.vacancy .vacancy__block .vacancy__toggle', function (e) {
        $(this).parents('.vacancy__block').toggleClass('active');
    });

    $('.vacancy .vacancy__block').each(function( index ) {
        $(this).attr('data-height', $(this).height());
    });




      $('.product-info__link').on('click', function() { 
        var el = $(this);
        var dest = el.attr('href'); 
        if(dest !== undefined && dest !== '') {
            $('html').animate({ 
                scrollTop: $(dest).offset().top 
            }, 400
            );
        }
        return false;
    });


    function visibleNoticModal() {
        // Для тестов $('.notic.modal').show();
        

        if($('.notic.modal').is(':visible')) {
            var count = 5;
            $("span.countdown").html("Это окно закроется через " + count + " секунд");

            countdown = setInterval(function(){
                count--; 
                $("span.countdown").html("Это окно закроется через " + count + " секунд");
                if (count == 0) {
                    clearInterval(countdown)
                    $('.notic.modal').fadeOut();
                } 
            }, 1000);
        }

        $(window).on('mousedown', function(e){
            var container = $(".wrapper");
            if (container.has(e.target).length === 0){
                clearInterval(countdown);
            } else {
                $('.close').click(function(){
                    clearInterval(countdown);
                });
            }
        });
    }

    function callModal(elBtn, elModal) {
        $(elBtn).on('click', function(e){
            e.preventDefault();
            $(elModal).fadeIn(200);
        });
    }


    callModal('.buy', '.buy-product');
    callModal('.list-contact__btn', '.footer-modal.modal');
    callModal('.vis-modal-p', '.political.modal');


    $(window).on('mousedown', function(e){
        var container = $(".wrapper");
        if (container.has(e.target).length === 0){
            
            $(".modal").fadeOut(200);
    
        } else {
            $('.close').click(function(){
                $(this).closest('.modal').fadeOut(200);
            });
        }
    });  

    $('#product_info').val($('.product_info').text());

    $(document).on('click', '.sidebar-parent-list > a', function(e) {
        e.preventDefault();
        $(this).parent('.sidebar-parent-list').toggleClass('active');
    });


});

*/












    /*


      $(document).on('click', function (e) {
        if ($(e.target).is($('.nav-toogle')) || $('.nav-toogle').has(e.target).length) {
            $('.nav-toogle').toggleClass('active');

            if ($('.nav-toogle').hasClass('active')) {
                $('.sidebar').addClass('is_visible');
                $('body').addClass('not-scroll');

            } else {
                $('.sidebar').removeClass('is_visible');
                $('body').removeClass('not-scroll');
            }
        } else {
            var block = $(".sidebar_container");
            var href = $(".sidebar_container .mob_href");
            if (!block.is(e.target) && block.has(e.target).length === 0 || href.click) {
                $('.sidebar').removeClass('is_visible');
                $('.nav-toogle').removeClass('active');
                $('body').removeClass('not-scroll');
            }
        }
    });

    $('.fa-plus, .capabilities-item').on('click', function(){    
        var id = $(this).attr('data-tab'),
            content = $('.item-content[data-tab="'+ id +'"]'); 
    
        if (!$(this).hasClass('active-capabilities')) {
            $(this).addClass('active-capabilities').find('.fa-plus').addClass('rotate');
            content.slideDown(400);
        } else {
            $(this).removeClass('active-capabilities').find('.fa-plus').removeClass('rotate');
            content.slideUp(400);
        }
    });


    $('.view-product__item a').fancybox({
    selector: '.view-product__slider .owl-item:not(.cloned) a',
    backFocus : false,
    hash   : false,
    buttons: [
        'zoom',
        'fullScreen',
        'close'
    ]
});  */
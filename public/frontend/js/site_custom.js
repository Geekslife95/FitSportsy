(function($) {
    "use strict";
    $(window).on('load', function() {
        setTimeout(() => {
            $('.sigma_preloader').addClass('hidden');
        }, 100);
        
    });
    $('.collections-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
    });
    $('.osahan-slider').slick({
        centerMode: true,
        centerPadding: '300px',
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }, {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }]
    });
  $('.event-block-slider').slick({
         autoplay: true,
        autoplaySpeed: 3000,
        dots: false,
        infinite: true,
        speed: 300,
        centerMode: true,
        centerPadding: '0px',
      
        slidesToShow: 3,
        slidesToScroll: 1,

        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,

                }
            },
            {
                breakpoint: 600,

                settings: {
                    slidesToShow: 2,
                      centerMode: false,
                      centerPadding: '0px'
                   
                }
            },
            {
                breakpoint: 480,
                settings: {
                    centerMode: false,
                    centerPadding: '0px',
                    slidesToShow: 1
                }
            }
            
        ]
    });

    $('.product-slider').slick({
        dots: false,
        infinite: true,
        arrows:false,
        slidesToShow: 4,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });


    $(document).on('scroll', function() {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    $(document).on('click', 'a.scroll-to-top', function(e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });

    function addProductQuantityToCart(url,count,price,cnt){
        var tprice = price * count;
        $("#subtotal_"+cnt).text('₹'+tprice);
        $("#loader_parent").css('display','flex');
        $.post(url,{"_token":$("meta[name=csrf-token]").attr('content'),"count":count},function(data){
            if(data.s==1){  
                $("#sub_total").text('₹'+data.sub_total)
                $("#shipping_charge").text('₹'+data.shipping_charge)
                $("#grand_total").text('₹'+data.grand_total)
            }else{  
                window.location.reload();
            }
            $("#loader_parent").css('display','none');
        })
    }

    // Input Plus & Minus Number JS
    $('.input-counter').each(function() {
        var spinner = jQuery(this),
        input = spinner.find('input[type="text"]'),
        btnUp = spinner.find('.plus-btn'),
        btnDown = spinner.find('.minus-btn'),
        min = input.attr('min'),
        max = input.attr('max'),
        ajax_url = spinner.data('id'),
        prod_price = spinner.data('price'),
        cnt = spinner.data('cnt');
        btnUp.on('click', function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
            //callajx
            addProductQuantityToCart(ajax_url,newVal,prod_price,cnt);
        });
        btnDown.on('click', function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
            addProductQuantityToCart(ajax_url,newVal,prod_price,cnt);
        });

    });
})(jQuery);

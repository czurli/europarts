(function ($) {
// imposta la barra di navigazione fissa nello scroll
    var stickyToggle = function (sticky, stickyWrapper, scrollElement) {
        var stickyHeight = sticky.outerHeight();
        var stickyTop = stickyWrapper.offset().top;
        if (scrollElement.scrollTop() >= stickyTop) {
            stickyWrapper.height(stickyHeight);
            sticky.addClass("is-sticky");
        } else {
            sticky.removeClass("is-sticky");
            stickyWrapper.height('auto');
        }
    };

//// Find all data-toggle="sticky-onscroll" elements
    $('[data-toggle="sticky-onscroll"]').each(function () {
        var sticky = $(this);
        var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
        sticky.before(stickyWrapper);
        sticky.addClass('sticky');

        // Scroll & resize events
        $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
            stickyToggle(sticky, stickyWrapper, $(this));
        });

        // On page load
        stickyToggle(sticky, stickyWrapper, $(window));
    });

    // aggiungo slider in home
    let home_slider = $('.home-slider .slides');
    if (home_slider.length && home_slider.length > 0) {
        home_slider.slick({
            slidesToShow: 1,
            fade: true,
            cssEase: 'linear',
            slidesToScroll: 1,
            lazyLoad: 'ondemand',
            autoplay: false,
            prevArrow: "<div class='left'><img src='http://europarts.dev.netshoppe.it/app/themes/europarts/assets/images/prev.png'></div>",
            nextArrow: "<div class='right'><img src='http://europarts.dev.netshoppe.it/app/themes/europarts/assets/images/next.png'></div>",
        });

    }

    let home_featured = $('.home-featured .products');
    if (home_featured.length && home_featured.length > 0) {
        home_featured.slick({
            slidesToShow: 5,
            //centerMode: true,
            slidesToScroll: 2,
            lazyLoad: 'ondemand',
            autoplay: false,
            prevArrow: "<div class='left'><img src='http://europarts.dev.netshoppe.it/app/themes/europarts/assets/images/prev.png'></div>",
            nextArrow: "<div class='right'><img src='http://europarts.dev.netshoppe.it/app/themes/europarts/assets/images/next.png'></div>",
            responsive: [
                {
                    breakpoint: 1380,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    // gestione "onsale"
    $(".attachment-woocommerce_thumbnail").wrap("<div class='product-image-wrapper'></div>");
    $('.woocommerce-loop-product__link').each(function () {
        $(this).children(".product-image-wrapper").append($(this).children('.onsale'));
    })
    $('.woocommerce-product-gallery__wrapper').append($('.onsale'));

    // aggiungo effetti css ai bottoni
    $('.woocommerce .button').addClass('hvr-underline-from-left');
    $('.woocommerce .edit').addClass('hvr-underline-from-left');

    // barra di ricerca //
    if ($(window).width() < 991) {
        $(".mega-toggle-blocks-left").append($(".dgwt-wcas-search-wrapp"));
        $(".mega-toggle-blocks-center").remove();
    } else {
        $("#ricerca").append($(".dgwt-wcas-search-wrapp"));
    }

    // quantità e aggiunta al carrello
    $(".add_to_cart_button, .single_add_to_cart_button").wrap("<div class='cart-wrapper'></div>");
    $('.woocommerce .product .shadow-int, .product .summary .cart').each(function () {
        $(this).children(".cart-wrapper").prepend($(this).children('.quantity'));
    })

    qtyFunc();

    var sidebar = $('#sidebar-bar');
    if ((sidebar.length) > 0){
        var sidebarPos = 0;
        $(window).scroll(function(){
            sidebarPos = header.offset().top
            console.log('header: '+sidebarPos + ' scroll: ' + $(window).scrollTop());
        })
    }

    //filtra categorie
    if ($(window).width() < 991) {
        $("#sidebar-button").click(function () {
            $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).text('Chiudi');
                    $('html, body').animate({
                        scrollTop: $('#sidebar-bar').offset().top - $('#header').height() - 10 + 'px'
                    }, 700);
                    $('body, html').css('overflowY','hidden');
                } else {
                    $(this).text('Apri');
                    $('body, html').css('overflowY','auto');
                }
            $("#sidebar-content").slideToggle(300, function () {

            });
        });
    }

})(jQuery);

function qtyFunc() {
    $(".woocommerce .quantity").on("click", ".plus", function (e) {
        e.preventDefault();
        var add_to_cart_button = $(this).parents(".product").find(".add_to_cart_button");
        var val_add_to_cart_button = parseInt(add_to_cart_button.attr('data-quantity'));
        var val_input = parseInt($(this).prev('input').val());
        $(this).prev('input').val(val_input + 1).change();
        add_to_cart_button.attr("data-quantity", val_add_to_cart_button + 1);
        add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + (val_add_to_cart_button + 1));
    });
    $(".woocommerce .quantity").on("click", ".minus", function (e) {
        e.preventDefault();
        var add_to_cart_button = $(this).parents(".product").find(".add_to_cart_button");
        var val_add_to_cart_button = parseInt(add_to_cart_button.attr('data-quantity'));
        var val_input = parseInt($(this).nextAll('input').val());
        if (val_input > 1) {
            $(this).nextAll('input').val(val_input - 1).change();
        }
        if (val_add_to_cart_button > 1) {
            add_to_cart_button.attr("data-quantity", val_add_to_cart_button - 1);
            add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + (val_add_to_cart_button - 1));
        }
    });
}

jQuery(document.body).on('removed_from_cart updated_cart_totals', function () {
    qtyFunc();
});




(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-73280214-1', 'auto');

jQuery(function() {
	
	$('.menu-main-container').css('display', 'block');
	$('.main-menu-container ').css('display', 'block');
	$('#primary-navigation #primary-menu-toggle').css('opacity', '1');
	
    $('#primary-nav').attr({
        'class': 'dropdown menu',
        'data-dropdown-menu': true
    }).find('ul').attr({
        'class': 'submenu menu vertical',
        'data-submenu': true
    });

    $('#primary-mobile-nav').attr({
        'class': 'vertical menu hide-for-medium',
        'data-accordion-menu': true
    }).find('ul').attr({
        'class': 'menu vertical nested',
        'data-submenu': true
    });

    jQuery(document).foundation();

    jQuery(document).ready(function(){
        jQuery('.slick').slick({
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });

        jQuery('.slick-blog-slider').slick({
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });

        jQuery('.slick-ambassador-section').slick({
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 1,
                  }
                },
            ]
        });
    });

    jQuery('.stars .star').hover(function() {
        jQuery(this).children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).prevAll('.star').children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).nextAll('.star').children('i.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    jQuery('.stars').mouseleave(function(){
        var rating = jQuery('#comments input[type=radio]:checked').val();
        if(!rating) {
            $(this).find('.fa.fa-star').removeClass('fa-star').addClass('fa-star-o');
        } else {
            $(this).find('.fa.fa-star').removeClass('fa-star').addClass('fa-star-o');
            $(this).find('.star:lt(' + rating + ') .fa').removeClass('fa-star-o').addClass('fa-star');
        }
    });

    jQuery('.stars .star').on('click', function() {
        jQuery(this).children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).prevAll('.star').children('i.fa').removeClass('fa-star-o').addClass('fa-star');
        jQuery(this).nextAll('.star').children('i.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    jQuery(window).scroll(function (event) {
        var scroll = jQuery(window).scrollTop();
        var sticky_container = jQuery('#top-bar-container');
        if(scroll > 0) {
            sticky_container.addClass('shrink');
        } else {
            sticky_container.removeClass('shrink');
        }
    });

    jQuery('p:empty, ul.tabs > p').remove();

    jQuery('#recipe-instructions .switch-input').on('change', function(){
        jQuery(this).parent('div').parent('div').next('div').children('.switch-text').toggleClass('strike');
    });

    // Recipe Lightbox
    jQuery('.lightbox-trigger').click( function(){
        var slideIndex = parseInt($(this).attr('data-slick-index'));
        jQuery('.lightbox-wrapper').addClass('lightbox-open');
        if (!jQuery('.slick-lightbox').hasClass('slick-initialized')){
            jQuery('.slick-lightbox').slick({
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',

            });
        }
        $( '.slick-lightbox' ).slick( 'slickGoTo', parseInt(slideIndex) );
    });

    function closeLightbox(){
        jQuery('.lightbox-wrapper').removeClass('lightbox-open');
    }

    jQuery('.close-lightbox').click(closeLightbox);
    jQuery('.lightbox-wrapper').click(closeLightbox);
    jQuery('.positioner').click(function(e){
        e.stopPropagation();
    });
    $(document).keyup(function(e) {
      if (e.keyCode === 27) closeLightbox();   // esc
    })

    // End Recipe Lightbox

    var sponsored_ad = jQuery(".hide-for-small-only #sponsored-ad");
    //if(!sponsored_ad.find('iframe').length){
        if(sponsored_ad.children().length > 0) {
        console.log("should be sticky");
        sponsored_ad.stick_in_parent({
            offset_top: 64,
            recalc_every: 1
        });
    }
});

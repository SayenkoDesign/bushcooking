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
    
    /**
  stickybits - Stickybits is a lightweight alternative to `position: sticky` polyfills
  @version v3.7.4
  @link https://github.com/dollarshaveclub/stickybits#readme
  @author Jeff Wainwright <yowainwright@gmail.com> (https://jeffry.in)
  @license MIT
**/
!function(t){"function"==typeof define&&define.amd?define(t):t()}(function(){"use strict";function x(){return(x=Object.assign||function(t){for(var s=1;s<arguments.length;s++){var e=arguments[s];for(var i in e)Object.prototype.hasOwnProperty.call(e,i)&&(t[i]=e[i])}return t}).apply(this,arguments)}var s=function(){function t(t,s){var e=this,i=void 0!==s?s:{};this.version="3.7.4",this.userAgent=window.navigator.userAgent||"no `userAgent` provided by the browser",this.props={customStickyChangeNumber:i.customStickyChangeNumber||null,noStyles:i.noStyles||!1,stickyBitStickyOffset:i.stickyBitStickyOffset||0,parentClass:i.parentClass||"js-stickybit-parent",scrollEl:"string"==typeof i.scrollEl?document.querySelector(i.scrollEl):i.scrollEl||window,stickyClass:i.stickyClass||"js-is-sticky",stuckClass:i.stuckClass||"js-is-stuck",stickyChangeClass:i.stickyChangeClass||"js-is-sticky--change",useStickyClasses:i.useStickyClasses||!1,useFixed:i.useFixed||!1,useGetBoundingClientRect:i.useGetBoundingClientRect||!1,verticalPosition:i.verticalPosition||"top",applyStyle:i.applyStyle||function(t,s){return e.applyStyle(t,s)}},this.props.positionVal=this.definePosition()||"fixed",this.instances=[];var n=this.props,o=n.positionVal,a=n.verticalPosition,l=n.noStyles,r=n.stickyBitStickyOffset,c="top"!==a||l?"":r+"px",p="fixed"!==o?o:"";this.els="string"==typeof t?document.querySelectorAll(t):t,"length"in this.els||(this.els=[this.els]);for(var f=0;f<this.els.length;f++){var u,y=this.els[f],h=this.addInstance(y,this.props);this.props.applyStyle({styles:(u={},u[a]=c,u.position=p,u),classes:{}},h),this.manageState(h),this.instances.push(h)}}var s=t.prototype;return s.definePosition=function(){var t;if(this.props.useFixed)t="fixed";else{for(var s=["","-o-","-webkit-","-moz-","-ms-"],e=document.head.style,i=0;i<s.length;i+=1)e.position=s[i]+"sticky";t=e.position?e.position:"fixed",e.position=""}return t},s.addInstance=function(t,s){var e=this,i={el:t,parent:t.parentNode,props:s};if("fixed"===s.positionVal||s.useStickyClasses){this.isWin=this.props.scrollEl===window;var n=this.isWin?window:this.getClosestParent(i.el,i.props.scrollEl);this.computeScrollOffsets(i),this.toggleClasses(i.parent,"",s.parentClass),i.state="default",i.stateChange="default",i.stateContainer=function(){return e.manageState(i)},n.addEventListener("scroll",i.stateContainer)}return i},s.getClosestParent=function(t,s){var e=s,i=t;if(i.parentElement===e)return e;for(;i.parentElement!==e;)i=i.parentElement;return e},s.getTopPosition=function(t){if(this.props.useGetBoundingClientRect)return t.getBoundingClientRect().top+(this.props.scrollEl.pageYOffset||document.documentElement.scrollTop);for(var s=0;s=t.offsetTop+s,t=t.offsetParent;);return s},s.computeScrollOffsets=function(t){var s=t,e=s.props,i=s.el,n=s.parent,o=!this.isWin&&"fixed"===e.positionVal,a="bottom"!==e.verticalPosition,l=o?this.getTopPosition(e.scrollEl):0,r=o?this.getTopPosition(n)-l:this.getTopPosition(n),c=null!==e.customStickyChangeNumber?e.customStickyChangeNumber:i.offsetHeight,p=r+n.offsetHeight;s.offset=o?0:l+e.stickyBitStickyOffset,s.stickyStart=a?r-s.offset:0,s.stickyChange=s.stickyStart+c,s.stickyStop=a?p-(i.offsetHeight+s.offset):p-window.innerHeight},s.toggleClasses=function(t,s,e){var i=t,n=i.className.split(" ");e&&-1===n.indexOf(e)&&n.push(e);var o=n.indexOf(s);-1!==o&&n.splice(o,1),i.className=n.join(" ")},s.manageState=function(r){var c=this,p=r,f=p.props,t=p.state,s=p.stateChange,e=p.stickyStart,i=p.stickyChange,n=p.stickyStop,u=f.positionVal,o=f.scrollEl,y=f.stickyClass,h=f.stickyChangeClass,d=f.stuckClass,g=f.verticalPosition,a="bottom"!==g,k=f.applyStyle,m=f.noStyles,l=function(t){t()},v=this.isWin&&(window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame)||l,C=this.isWin?window.scrollY||window.pageYOffset:o.scrollTop,S=a&&C<=e&&("sticky"===t||"stuck"===t),w=n<=C&&"sticky"===t;e<C&&C<n&&("default"===t||"stuck"===t)?p.state="sticky":S?p.state="default":w&&(p.state="stuck");var b=i<=C&&C<=n;C<i/2||n<C?p.stateChange="default":b&&(p.stateChange="sticky"),t===p.state&&s===p.stateChange||v(function(){var t,s,e,i,n,o,a={sticky:{styles:(t={position:u,top:"",bottom:""},t[g]=f.stickyBitStickyOffset+"px",t),classes:(s={},s[y]=!0,s)},default:{styles:(e={},e[g]="",e),classes:{}},stuck:{styles:x((i={},i[g]="",i),"fixed"===u&&!m||!c.isWin?{position:"absolute",top:"",bottom:"0"}:{}),classes:(n={},n[d]=!0,n)}};"fixed"===u&&(a.default.styles.position="");var l=a[p.state];l.classes=((o={})[d]=!!l.classes[d],o[y]=!!l.classes[y],o[h]=b,o),k(l,r)})},s.applyStyle=function(t,s){var e=t.styles,i=t.classes,n=s,o=n.el,a=n.props,l=o.style,r=a.noStyles,c=o.className.split(" ");for(var p in i){if(i[p])-1===c.indexOf(p)&&c.push(p);else{var f=c.indexOf(p);-1!==f&&c.splice(f,1)}}if(o.className=c.join(" "),e.position&&(l.position=e.position),!r)for(var u in e)l[u]=e[u]},s.update=function(e){var i=this;return void 0===e&&(e=null),this.instances.forEach(function(t){if(i.computeScrollOffsets(t),e)for(var s in e)t.props[s]=e[s]}),this},s.removeInstance=function(t){var s,e,i=t.el,n=t.props;this.applyStyle({styles:(s={position:""},s[n.verticalPosition]="",s),classes:(e={},e[n.stickyClass]="",e[n.stuckClass]="",e)},t),this.toggleClasses(i.parentNode,n.parentClass)},s.cleanup=function(){for(var t=0;t<this.instances.length;t+=1){var s=this.instances[t];s.stateContainer&&s.props.scrollEl.removeEventListener("scroll",s.stateContainer),this.removeInstance(s)}this.manageState=!1,this.instances=[]},t}();if("undefined"!=typeof window){var t=window.$||window.jQuery||window.Zepto;t&&(t.fn.stickybits=function(t){return new s(this,t)})}});

    var sponsored_ad = jQuery(".hide-for-small-only #sponsored-ad");
    /*if(sponsored_ad.children().length){
        console.log("should be sticky");
        sponsored_ad.stick_in_parent({
            offset_top: 64,
            recalc_every: 0
        });
    }*/
    
    if(sponsored_ad.children().length){
        sponsored_ad.stickybits({stickyBitStickyOffset: 64});
    }
    
    var pinterest_photos = jQuery(".show-for-medium.pinterest-photos");
    if(pinterest_photos.length){
        var offset = 64;
        
        if(sponsored_ad.children().length){
            offset += sponsored_ad.height();
        }
        
        pinterest_photos.stickybits({stickyBitStickyOffset: offset});
    }
    
});

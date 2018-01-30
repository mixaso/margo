require(['jquery'], function($) {
    jQuery('img.svg-js').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Check if the viewport is set, else we gonna set it if we can.
            if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });

    jQuery("ol.product-items.widget-product-grid").addClass('owl-carousel');
    jQuery("ol.product-items.widget-product-grid").owlCarousel({
        loop: true,
        responsiveClass: true,
        autoplay: true,
        autoplayHoverPause: true,
        nav: true,
        navText: [],
        dots: true,
        margin: 10,
        responsive:{
            0:{
                items: 1,
                nav: false
            },
            425:{
                items: 2,
                nav: false
            },
            768:{
                items: 3,
                nav: false
            },
            1000:{
                items: 4,
                dots: false,
                stagePadding: 10
            }
        }
    });

    jQuery(function () {
        // var logOutLink = jQuery('.authorization-link a').attr('href').indexOf('logout') + 1;

        if (jQuery('.authorization-link a').attr('href').indexOf('logout') + 1) {
            jQuery('.authorization-link').removeAttr('data-label').css('padding-right','20px');
        }

        if (jQuery.trim(jQuery('.greet.welcome span').text()) !== "") {
            jQuery('.content__links .header.links').css('width','auto');
        }
    });
});
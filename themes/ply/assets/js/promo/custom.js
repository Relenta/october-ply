// When DOM is fully loaded
jQuery(document).ready(function ($) {

    /* FlexSlider
     --------------------------------------------------*/

    $('.flexslider').flexslider({
        namespace           : "flex-",           //{NEW} String: Prefix string attached to the class of every element generated by the plugin
        selector            : ".slides > li",    //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
        animation           : "fade",            //String: Select your animation type, "fade" or "slide"
        easing              : "swing",           //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
        direction           : "horizontal",      //String: Select the sliding direction, "horizontal" or "vertical"
        reverse             : false,             //{NEW} Boolean: Reverse the animation direction
        animationLoop       : true,              //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
        smoothHeight        : false,             //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
        startAt             : 0,                 //Integer: The slide that the slider should start on. Array notation (0 = first slide)
        slideshow           : true,              //Boolean: Animate slider automatically
        slideshowSpeed      : 7000,              //Integer: Set the speed of the slideshow cycling, in milliseconds
        animationSpeed      : 600,               //Integer: Set the speed of animations, in milliseconds
        initDelay           : 0,                 //{NEW} Integer: Set an initialization delay, in milliseconds
        randomize           : false,             //Boolean: Randomize slide order

        // Usability features
        pauseOnAction       : true,              //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
        pauseOnHover        : false,             //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
        useCSS              : true,              //{NEW} Boolean: Slider will use CSS3 transitions if available
        touch               : true,              //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
        video               : false,             //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

        // Primary Controls
        controlNav          : true,              //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav        : true,              //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText            : "Previous",        //String: Set the text for the "previous" directionNav item
        nextText            : "Next",            //String: Set the text for the "next" directionNav item

        // Secondary Navigation
        keyboard            : true,              //Boolean: Allow slider navigating via keyboard left/right keys
        multipleKeyboard    : false,             //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
        mousewheel          : false,             //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
        pausePlay           : false,             //Boolean: Create pause/play dynamic element
        pauseText           : 'Pause',           //String: Set the text for the "pause" pausePlay item
        playText            : 'Play',            //String: Set the text for the "play" pausePlay item

        // Special properties
        controlsContainer   : "",                //{UPDATED} Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
        manualControls      : "",                //Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
        sync                : "",                //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
        asNavFor            : "",                //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider
    });

    /* Quotes Rotator
     --------------------------------------------------*/

    $("ul.quotes").quote_rotator();

    /* Sticky Navigation
     --------------------------------------------------*/

    $("#header-background-nav").sticky({topSpacing:0});

    /* FancyBox (Lightbox)
     --------------------------------------------------*/

    $(".fancybox").fancybox({
        helpers: {
            overlay: {
                locked: false
            }
        }
    });

    /* FitVids Responsive Video
     --------------------------------------------------*/

    $(".container").fitVids();

    /* Smooth Page Scroll
     --------------------------------------------------*/

    $("#navigation li a").click(function () {
        var full_url = this.href;
        var parts = full_url.split("#");
        var trgt = parts[1];
        var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top;
        $('html, body').animate({
            scrollTop: target_top
        }, 400);
        return false;
    });

    /* Isotope (http://isotope.metafizzy.co)
     --------------------------------------------------*/

    $(window).load(function () {
        var $container = $('#portfolio-items');
        var $filter = $('#filter');
        // Initialize isotope
        $container.isotope({
            filter: '*',
            layoutMode: 'fitRows',
            animationOptions: {
                duration: 750,
                easing: 'linear'
            }
        });
        // Filter items when filter link is clicked
        $filter.find('a').click(function () {
            var selector = $(this).attr('data-filter');
            $filter.find('a').removeClass('current');
            $(this).addClass('current');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    animationDuration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });
    });

    /* Accordion
     --------------------------------------------------*/

    //Add Inactive Class To All Accordion Headers
    $('.accordion-header').toggleClass('inactive-header');
    //Set The Accordion Content Width
    var contentwidth = $('.accordion-header').width();
    $('.accordion-content').css({
        'width': contentwidth
    });
    //Open The First Accordion Section When Page Loads
    $('.accordion-header').first().toggleClass('active-header').toggleClass('inactive-header');
    $('.accordion-content').first().slideDown().toggleClass('open-content');
    // The Accordion Effect
    $('.accordion-header').click(function () {
        if ($(this).is('.inactive-header')) {
            $('.active-header').toggleClass('active-header').toggleClass('inactive-header').next().slideToggle().toggleClass('open-content');
            $(this).toggleClass('active-header').toggleClass('inactive-header');
            $(this).next().slideToggle().toggleClass('open-content');
        } else {
            $(this).toggleClass('active-header').toggleClass('inactive-header');
            $(this).next().slideToggle().toggleClass('open-content');
        }
    });

    /* Tabbed Content
     --------------------------------------------------*/

    var tabs = $('ul.tabs');
    tabs.each(function (i) {
        //Get all tabs
        var tab = $(this).find('> li > a');
        $("ul.tabs li:first").addClass("active").fadeIn('fast'); //Activate first tab
        $("ul.tabs li:first a").addClass("active").fadeIn('fast'); //Activate first tab
        $("ul.tabs-content li:first").addClass("active").fadeIn('fast'); //Activate first tab
        tab.click(function (e) {
            //Get Location of tab's content
            var contentLocation = $(this).attr('href') + "Tab";
            //Let go if not a hashed one
            if (contentLocation.charAt(0) == "#") {
                e.preventDefault();
                //Make Tab Active
                tab.removeClass('active');
                $(this).addClass('active');
                //Show Tab Content & add active class
                $(contentLocation).show().addClass('active').siblings().hide().removeClass('active');
            }
        });
    });

    /* Toggles
     --------------------------------------------------*/

    $(function () { // run after page loads
        $(".toggle_container").hide();
        //Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
        $("p.trigger").click(function () {
            $(this).toggleClass("active").next().slideToggle("normal");
            return false; //Prevent the browser jump to the link anchor
        });
    });
    // valid XHTML method of target_blank
    $(function () { // run after page loads
        $('a[rel*=external]').click(function () {
            window.open(this.href);
            return false;
        });
    });

    /* Overlay Vertical Alignment
     --------------------------------------------------*/

    $.fn.extend({
        verticalAlign: function () {
            //Iterate over the current set of matched elements
            return this.each(function () {
                var obj = $(this);
                // calculate the new padding and height
                var childHeight = obj.height();
                var parentHeight = obj.parent().height();
                var diff = Math.round(((parentHeight - childHeight) / 2));
                // apply new values
                obj.css({
                    "display": "block",
                    "margin-top": diff
                });
            });
        }
    });
    var callback = function () {
        $(".project-item .overlay .details").verticalAlign();
    };
    $(document).ready(callback);
    $(window).resize(callback);
    $(window).load(callback);

    /* Column clearing
     --------------------------------------------------*/

    $('.service.one-third.column').eq(3).addClass('clearcol');
    $('.article.one-third.column').eq(3).addClass('clearcol');
    $('.team-member.one-third.column').eq(3).addClass('clearcol');

    /* Element Fade on Scroll
     --------------------------------------------------*/

    $(window).scroll(function () {
        var $uberFade = $('#uber-statement');
        //Get scroll position of window
        var windowScroll = $(this).scrollTop();
        //Slow scroll of uber statement and fade it out
        $uberFade.css({
            'margin-top': -(windowScroll / 0) + "px",
            'opacity': 1 - (windowScroll / 700)
        });
    });

    /* Form Placeholder Functionality for IE8/IE9
     --------------------------------------------------*/

    if (!Modernizr.input.placeholder) {
        $(document).on('focus', '[placeholder]', function () {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        })
        $(document).on('blur', '[placeholder]', function () {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        })
        $('[placeholder]').blur();
        $(document).on('submit', 'form', function () {
            $(this).find('[placeholder]').each(function () {
                var input = $(this);
                if (input.hasClass('placeholder') && input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }

    /* Sticky Footer
     --------------------------------------------------*/

    function setMinHeight() {
        $('#main')
            .css('min-height',
                $(window)
                    .outerHeight(true) - ($('body')
                    .outerHeight(true) - $('body')
                    .height()) - $('#header-global')
                    .outerHeight(true) - ($('#main')
                    .outerHeight(true) - $('#main')
                    .height()) - $('#footer-global')
                    .outerHeight(true));
    }
    // Init
    setMinHeight();
    // Window resize
    $(window)
        .on('resize', function () {
            var timer = window.setTimeout(function () {
                window.clearTimeout(timer);
                setMinHeight();
            }, 30);
        });

    /* End all Custom Functions */

});

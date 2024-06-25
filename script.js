jQuery(document).ready(function(){
    // Initialize Slick sliders
    jQuery('#slider1').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '#slider2',
        autoplay: true,
        autoplaySpeed: 2000, // Set autoplay speed to 2 seconds
        draggable: false, // Make slider non-draggable
        responsive: [
            {
                breakpoint: 881,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    jQuery('#slider2').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '#slider1',
        autoplay: true,
        autoplaySpeed: 2000, // Set autoplay speed to 2 seconds
        draggable: false // Make slider non-draggable
    });

    // Custom navigation
    jQuery('#custom-prev').on('click', function(){
        var currentSlide1 = jQuery('#slider1').slick('slickCurrentSlide');
        var currentSlide2 = jQuery('#slider2').slick('slickCurrentSlide');

        if (currentSlide1 > 0 && currentSlide2 > 0) {
            jQuery('#slider1').slick('slickPrev');
            jQuery('#slider2').slick('slickPrev');
            updateProgressBar();
        }
    });

    jQuery('#custom-next').on('click', function(){
        var slider1 = jQuery('#slider1');
        var slider2 = jQuery('#slider2');
        var currentSlide1 = slider1.slick('slickCurrentSlide');
        var currentSlide2 = slider2.slick('slickCurrentSlide');
        var slideCount1 = slider1.slick('getSlick').slideCount;
        var slideCount2 = slider2.slick('getSlick').slideCount;

        if (currentSlide1 < slideCount1 - 1 && currentSlide2 < slideCount2 - 1) {
            slider1.slick('slickNext');
            slider2.slick('slickNext');
            updateProgressBar();
        }
    });

    // Update progress bar
    function updateProgressBar(currentSlide) {
        var slider1 = jQuery('#slider1');
        var slideCount = slider1.slick('getSlick').slideCount;

        var progressBar = jQuery('.progress-bar .progress');
        var progressBarWidth = (currentSlide / (slideCount - 1)) * 100;

        progressBar.css('width', progressBarWidth + '%');
    }

    // Update progress bar initially
    updateProgressBar(jQuery('#slider1').slick('slickCurrentSlide'));

    // Update progress bar on slider slide
    jQuery('#slider1').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        updateProgressBar(nextSlide);
    });

    // Stop autoplay when the last slide is the current and active slide and the first slide is active after the slider completes
    function stopAutoplayIfNeeded() {
        var slider1 = jQuery('#slider1');
        var slider2 = jQuery('#slider2');
        var currentSlide1 = slider1.slick('slickCurrentSlide');
        var slideCount1 = slider1.slick('getSlick').slideCount;
        var currentSlide2 = slider2.slick('slickCurrentSlide');
        var slideCount2 = slider2.slick('getSlick').slideCount;

        if ((currentSlide1 === slideCount1 - 1) && (currentSlide2 === slideCount2 - 1)) {
            slider1.slick('slickPause');
            slider2.slick('slickPause');
        }
    }

    jQuery('#slider1').on('afterChange', function(event, slick, currentSlide) {
        stopAutoplayIfNeeded();
    });

    jQuery('#slider2').on('afterChange', function(event, slick, currentSlide) {
        stopAutoplayIfNeeded();
    });
});
$(document).ready(function () {


    if ($('.bbb_viewed_slider').length) {
        var viewedSlider = $('.bbb_viewed_slider');

        viewedSlider.owlCarousel(
            {
                loop: false,
                margin: 30,
                autoplay: false,
                autoplayTimeout: 6000,
                nav: false,
                dots: false,
                responsive:
                    {
                        0: {items: 1},
                        575: {items: 2},
                        768: {items: 3},
                        991: {items: 4},
                        1199: {items: 6}
                    }
            });

        if ($('.bbb_viewed_prev').length) {
            var prev = $('.bbb_viewed_prev');
            prev.on('click', function () {
                viewedSlider.trigger('prev.owl.carousel');
            });
        }

        if ($('.bbb_viewed_next').length) {
            var next = $('.bbb_viewed_next');
            next.on('click', function () {
                viewedSlider.trigger('next.owl.carousel');
            });
        }
    }




    if ($('.bbb_viewed_slider_v').length) {
        var viewedSliderV = $('.bbb_viewed_slider_v');

        viewedSliderV.owlCarousel(
            {
                loop: false,
                margin: 30,
                autoplay: false,
                autoplayTimeout: 6000,
                nav: false,
                dots: false,
                responsive:
                    {
                        0: {items: 1},
                        575: {items: 2},
                        768: {items: 3},
                        991: {items: 4},
                        1199: {items: 6}
                    }
            });

        if ($('.bbb_viewed_prev_v').length) {
            var prev = $('.bbb_viewed_prev_v');
            prev.on('click', function () {
                viewedSliderV.trigger('prev.owl.carousel');
            });
        }

        if ($('.bbb_viewed_next_v').length) {
            var next = $('.bbb_viewed_next_v');
            next.on('click', function () {
                viewedSliderV.trigger('next.owl.carousel');
            });
        }
    }


});
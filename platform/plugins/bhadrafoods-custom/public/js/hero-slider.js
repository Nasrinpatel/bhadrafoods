(function ($) {
    'use strict';

    function initializeHeroSliders() {
        if (typeof window.Swiper === 'undefined') {
            return;
        }

        $('.bf-fullscreen-hero-slider .swiper').each(function () {
            if (this.swiper) {
                return;
            }

            var slider = $(this).closest('.bf-fullscreen-hero-slider');
            var speed = parseInt(slider.data('autoplay-speed'), 10) || 4500;

            new window.Swiper(this, {
                loop: slider.find('.swiper-slide').length > 1,
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: {
                    delay: speed,
                    disableOnInteraction: false,
                },
                speed: 900,
            });
        });
    }

    $(initializeHeroSliders);
    document.addEventListener('shortcode.loaded', initializeHeroSliders);
})(window.jQuery);

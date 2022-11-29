import $ from 'jQuery';
import Swiper, { Navigation, Pagination, Autoplay, EffectFade } from 'swiper';
$(() => {

    if ($('#homeslider').length) {
        new Swiper('#homeslider .swiper', {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            speed: 1000,
            effect: 'fade',
            loop: true,
            allowTouchMove: false,
            autoplay:{
                delay: 5000
            },
            navigation: {
                nextEl: '#homeslider .swiper-next',
                prevEl: '#homeslider .swiper-prev',
            },
            pagination: {
                el: "#homeslider .swiper-pagination",
                type: "fraction",
            },
        });
    }

});
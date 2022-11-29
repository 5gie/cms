import $ from 'jQuery';
import Swiper, { Navigation, Autoplay } from 'swiper';
$(() => {

    if ($('#realisations').length) {
        new Swiper('#realisations .swiper', {
            modules: [Navigation, Autoplay],
            speed: 1200,
            autoplay:{
                delay: 5000
            },
            loop: true,
            navigation: {
                nextEl: '#realisations .swiper-next',
                prevEl: '#realisations .swiper-prev',
            },
        });
    }

});
import './bootstrap';

// Import Swiper and modules
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', () => {
    const heroSwiper = new Swiper('.hero-swiper', {
        modules: [Navigation, Pagination, Autoplay],
        loop: false,
        spaceBetween: 100,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.hero-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.hero-next',
            prevEl: '.hero-prev',
        },
    });

    const bentoSwiper = new Swiper('.bento-swiper', {
        modules: [Pagination, Autoplay],
        loop: false,
        autoplay: {
            delay: 4000,
        },
        pagination: {
            el: '.bento-swiper .swiper-pagination',
            clickable: true,
        },
    });
});

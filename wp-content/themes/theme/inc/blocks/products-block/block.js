jQuery(document).ready(function ($) {

    const productsSwiper = new Swiper('#products-block .swiper', {
        spaceBetween: 30,
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            498: {
                slidesPerView: 2,
            },
            769: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 4,
            },
            1300: {
                slidesPerView: 5,
            },
            1600: {
                slidesPerView: 6,
            }

        },
        navigation:{
          prevEl: '#products-block .swiper-btn-prev',
          nextEl: '#products-block .swiper-btn-next',
        },
        pagination:{
            el: '#products-block .swiper-pagination',
            clickable: true,
        },
    })

});
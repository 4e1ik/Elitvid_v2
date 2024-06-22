const swiper = new Swiper('.swiper',{
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    speed: 2000,
    simulateTouch: false,

    autoplay: {
        delay:2000,
    },

    effect: 'fade',
    fadeEffect: {
        crossFade: true,
    }
});
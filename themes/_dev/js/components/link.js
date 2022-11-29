import $ from 'jQuery';
// import gsap, { Power2, Power3, Power1 } from 'gsap';

// const tl = gsap.timeline();

// $(window).on('load', function () {

//     tl.to('.preloader', 0.6, {
//         ease: Power1.easeInOut,
//         y: '-100%'
//     })

// });
// $(() => {

//     $('body').on('click', 'a', function(e){

//         e.preventDefault();

//         if($('.nav').hasClass('active')){
//             $('.menu__link span').each(function (k, v) {
//                 tl.to(this, 0.4, {
//                     y: '-100%',
//                     delay: -0.25,
//                     ease: Power2.easeInOut
//                 })
//             })
//             tl.to('.menu__link span', 0, {
//                 y: '100%'
//             })
//         }

//         tl.to('.preloader', 0.6, {
//             delay: $('.nav').hasClass('active') ? -0.2 : 0.2,
//             ease: Power1.easeInOut,
//             y: 0
//         }).then(() => {

//             window.location.href = $(this).attr('href');

//         });

//     });

// });
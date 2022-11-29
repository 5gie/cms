import $ from 'jQuery'
import gsap, { Power1, Power2 } from 'gsap'

const tl = gsap.timeline();

$(() => {
    
    bindClick();

});

const bindClick = () => {
    $('body').one('click', '#menu-toggler', function () {

        if(!$(this).hasClass('active')){

            tl.to('.menu', 0.4, {
                y:0,
                ease: Power1.easeInOut
            }).then(() => {
                $('.menu__link span').each(function (k,v) {
                    tl.to(v, 0.9, {
                        y: 0,
                        delay: k !== 0 ? -0.75 : -0.3,
                        ease: Power2.easeInOut
                    })
                })
            }).then(() => {

                bindClick();

            });

        } else {

            $('.menu__link span').each(function (k, v) {
                tl.to(this, 0.4, {
                    y: '-100%',
                    delay: -0.25,
                    ease: Power2.easeInOut
                })
            })
            tl.to('.menu', 0.4, {
                y: '100%',
                delay: -0.1,
                ease: Power1.easeInOut
            }).to('.menu__link span', 0, {
                y: '100%'
            }).to('.menu', 0, {
                y: '-100%'
            }).then(() => {
                bindClick();
            })
        }

        $(this).toggleClass('active');
        $('.nav').toggleClass('active');
        $('body').toggleClass('locked');


    });
}

const allItems = gsap.utils.toArray(".menu__link");
const menuImageWrapper = document.querySelector(".menu__image-wrapper");
const menuImage = document.querySelector(".menu__image");

function initItems() {
    allItems.forEach((link) => {
        link.addEventListener("mouseenter", itemHover);
        link.addEventListener("mouseleave", itemHover);
        link.addEventListener("mousemove", movemenuImage);
    });
}

function movemenuImage(e) {
    let xpos = e.clientX;
    let ypos = e.clientY;
    const tl = gsap.timeline();
    tl.to(menuImageWrapper, {
        x: xpos,
        y: ypos
    });
}

function itemHover(e) {
    if($(window).width() > 991){
        if (e.type === "mouseenter") {
            const targetImage = e.target.dataset.image;
    
            const t1 = gsap.timeline();
            t1.set(menuImage, {
                backgroundImage: `url(${targetImage})`,
                width: e.target.dataset.width,
                height: e.target.dataset.height
            }).to(menuImageWrapper, {
                duration: 0.5,
                autoAlpha: 1
            });
        } else if (e.type === "mouseleave") {
            const tl = gsap.timeline();
            tl.to(menuImageWrapper, {
                duration: 0.5,
                autoAlpha: 0
            });
        }
    }
}

function init() {
    initItems();
}

$(() => {
    init();
})
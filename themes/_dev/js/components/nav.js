import $ from 'jQuery'

$(() => {
    
    $(document).on('scroll', function () {

        // let nav_opacity;
        
        if ($(document).scrollTop() > 10){
            $('.nav').addClass('nav--scrolled');
            //     nav_opacity = parseFloat((100 - $(document).scrollTop()) / 100);
            //     $('.nav').css('opacity', nav_opacity);
        } else {
            $('.nav').removeClass('nav--scrolled');
        }
    
        $('.main > section[data-bg]').each(function () {
            if ($(this).position().top - $('.nav').outerHeight() <= $(document).scrollTop() && ($(this).position().top + $(this).outerHeight()) > $(document).scrollTop()) {
                if($(this).data('bg') == 'bright'){
                    if(!$('.nav').hasClass('nav--dark')){
                        $('.nav').addClass('nav--dark');
                        $('.nav').removeClass('nav--bright');
                    }
                } else {
                    if (!$('.nav').hasClass('nav--bright')) {
                        $('.nav').addClass('nav--bright');
                        $('.nav').removeClass('nav--dark');
                    }
                }
            }
        });
    });

});
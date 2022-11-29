import $ from 'jQuery';
import gsap, { Power2 } from 'gsap';

$(() => {
    $('.input-effect').on('change', function () {
        if($(this).val() != ''){
            $(this).addClass('has-content');
        } else {
            $(this).removeClass('has-content');
        }
        if($(this).hasClass('has-errors')){
            $(this).removeClass('has-errors');
            $(this).closest('.form-group').find('.input-errors').remove();
        }
    });

    if($('.notifications .alert').length){

        const tl = gsap.timeline();

        setTimeout(() => {
            
            $('.notifications .alert').each(function(){

                tl.to(this, 0.3, {
                    y: '-30px',
                    opacity: 0,
                    delay: 0.5
                }).then(() => {

                    $('.notifications .alert').remove();

                });

            });

        }, 4000);
    }
})
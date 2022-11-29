import $ from 'jQuery'
import Masonry from 'masonry-layout';
import SimpleLightbox from "simplelightbox";

$(() => {
    if ($('.page-gallery__item').length) {
        new Masonry('.page-gallery__items', {
            itemSelector: '.page-gallery__item',
            fitWidth: true,
        });
    }

    if($('a[data-lightbox]').length){
        new SimpleLightbox('a[data-lightbox]', {
            captions: false,
            scrollZoom: false,
            overlayOpacity: 0.9
        });
    }

});
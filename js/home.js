$(function(){

    // Initializing the filtering library
    var $container = $('.view-products .product-wrapper');
    $container.isotope();

    // filter when clicking a category based on it
    $('.view-products ul.categories li').on('click', function(){
        $('.view-products  ul.categories .current').removeClass('current');
        $(this).addClass('current');

        $container.isotope({ filter: $(this).attr('data-filter') });
    });

    // add-to-cart alerts
    $('div.alert').fadeOut(4000, function(){
        $('div.alert').remove();
    });

});
$(function(){

    // if the cart is empty
    if ($('.cart-wrapper').children().length == 0) {
        $('#empty-cart').show();
        $('#make-order').hide();
    }

    // make order
    $('#make-order').on('click', function(){
        $('.overlay').fadeIn();

        // if first time to show set visibility to visible else show it
        if ($('.make-order-box').css('visibility') == 'hidden'){
            $('.make-order-box').css('visibility', 'visible');
        } else {
            $('.make-order-box').fadeIn();
        }
    });

    // cancel button
    $('#cancel-btn').on('click', function(){
        $('.overlay').fadeOut();
        $('.make-order-box').fadeOut();
    });

    // make order alert success
    $('div.alert').fadeOut(4000, function(){
        $('div.alert').remove();
    });
});
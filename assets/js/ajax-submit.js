jQuery(document).ready(function(){

    // add to cart buttom submit 
    $('.add_cart_handler').on('submit', function(e){
        e.preventDefault();

        var get_this = $(this);
        var formData = get_this.serialize();
        get_this.find('.spinner').addClass('is_active');
        get_this.find('.cart_text').css('opacity', '0');
        $.ajax({
            type: 'POST',
            url: ecomAjax.ajaxurl,
            data: {
                action: 'add_cart_handle',
                form_data: formData,
            },
            success: function (response) {
                console.log(response);

                get_this.find('.spinner').removeClass('is_active');
                get_this.find('.cart_text').css('opacity', '1');
                get_this.find('.cart_text').html(`<a href="${ecomAjax.cart_url}" class="d-block">VIEW CART</a>`);
            },
            error: function (error) {
                console.error('Error occurred:', error);
            }
        });
    });

});
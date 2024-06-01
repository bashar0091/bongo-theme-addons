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
                get_this.find('.spinner').removeClass('is_active');
                get_this.find('.cart_text').css('opacity', '1');
                get_this.find('.cart_text').html(`<a href="${ecomAjax.cart_url}" class="d-block">VIEW CART</a>`);
            },
            error: function (error) {
                console.error('Error occurred:', error);
            }
        });
    });


    // single page add to cart buttom submit 
    $('.single_add_to_cart').on('submit', function(e){
        e.preventDefault();

        var get_this = $(this);
        var formData = get_this.serialize();

        get_this.find('.spinner').addClass('is_active');

        $.ajax({
            type: 'POST',
            url: ecomAjax.ajaxurl,
            data: {
                action: 'single_add_cart_handle',
                form_data: formData,
            },
            success: function (response) {
                get_this.find('.spinner').removeClass('is_active');
                get_this.find('.btn').html(`<a href="${ecomAjax.cart_url}" class="d-block text-white">VIEW CART</a>`);
            },
            error: function (error) {
                console.error('Error occurred:', error);
            }
        });
    });


    // fixed checkout submit 
    $('.fixed_checkout_submit').on('submit', function(e){
        e.preventDefault();

        var get_this = $(this);
        var formData = get_this.serialize();
        get_this.find('.spinner').addClass('is_active');
        $.ajax({
            type: 'POST',
            url: ecomAjax.ajaxurl,
            data: {
                action: 'fixed_checkout_handle',
                form_data: formData,
            },
            success: function (response) {
                get_this.find('.spinner').removeClass('is_active');
                $('.sucessfull_msg').html(`<h2 style="font-size: 20px; text-align: center;">Order Place Successfully, We will contact you soon</h2>
                `);
            },
            error: function (error) {
                console.error('Error occurred:', error);
            }
        });
    });
      

});
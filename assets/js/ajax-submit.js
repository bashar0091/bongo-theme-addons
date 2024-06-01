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
      

    // wishlist add 
    $('.add_wishlist').on('submit', function(e){
        e.preventDefault();

        var get_this = $(this);

        var is_user_id = get_this.find('input[name="user_id"]').val();

        if(is_user_id > 0) {
            var formData = get_this.serialize();
            get_this.find('.spinner').addClass('is_active');
            $.ajax({
                type: 'POST',
                url: ecomAjax.ajaxurl,
                data: {
                    action: 'add_wishlist_handle',
                    form_data: formData,
                },
                success: function (response) {
                    get_this.find('.spinner').removeClass('is_active');
                    get_this.addClass('d-none');
                    get_this.parent().find('.remove_wishlist').removeClass('d-none');
                    get_this.parent().find('input[name="wishlist_id"]').val(response.new_wishlist_id);
                },
                error: function (error) {
                    console.error('Error occurred:', error);
                }
            });
        } else {
            alert('Please login to Add Wishlist');
        }
        
    });

    // wishlist remove 
    $('.remove_wishlist').on('submit', function(e){
        e.preventDefault();
        
        var get_this = $(this);
        var formData = get_this.serialize();
        get_this.find('.spinner').addClass('is_active');
        $.ajax({
            type: 'POST',
            url: ecomAjax.ajaxurl,
            data: {
                action: 'remove_wishlist_handle',
                form_data: formData,
            },
            success: function (response) {
                get_this.find('.spinner').removeClass('is_active');
                get_this.addClass('d-none');
                get_this.parent().find('.add_wishlist').removeClass('d-none');
                get_this.find('input[name="wishlist_id"]').val('');
            },
            error: function (error) {
                console.error('Error occurred:', error);
            }
        });
    });

});
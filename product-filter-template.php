<?php

$attribute_name = $filter_tax;
$attribute_value = $filter_data;
$product_args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => $attribute_name,
            'field' => 'slug',
            'terms' => $attribute_value,
        ),
    ),
);
$product_query = new WP_Query($product_args);
if ( $product_query->have_posts() ) {
?>
<span class="spinner spinner3" style="z-index:999;"></span>
<div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
    <?php 
    while ( $product_query->have_posts() ) {
        $product_query->the_post();

        $product_id = get_the_id();
        $product = wc_get_product( $product_id );

        $gallery_image_id = $product->get_gallery_image_ids()[0];
        $gallery_image_url = wp_get_attachment_url($gallery_image_id);
    ?>
    <div class="product-card-wrapper">
        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
            <div class="pc__img-wrapper">
                <a href="<?= get_the_permalink();?>">
                    <img loading="lazy" src="<?= get_the_post_thumbnail_url();?>" alt="product_img" class="pc__img" style="height:100%;">
                    <img loading="lazy" src="<?= $gallery_image_url;?>" alt="product_img" class="pc__img pc__img-second" style="height:100%;">
                </a>
                
                <form action="" method="post" class="add_cart_handler">
                    <input type="hidden" name="product_id" value="<?= $product_id;?>">
                    <input type="number" name="quantity" value="1">
                    <button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" title="Add To Cart">
                        <span class="cart_text">Add To Cart</span>
                        <span class="spinner"></span>
                    </button>
                </form>
            </div>

            <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="<?= get_the_permalink();?>"><?= get_the_title();?></a></h6>
                <div class="product-card__price d-flex">
                    <span class="money price price-sale"><?= wc_price($product->get_price());?></span>
                </div>

                <div class="wishlist_wrapper">
                    <?php 
                    $user_id = '';
                    $wishlist_id = '';
                    $has_wishlisted = false;
                    if(is_user_logged_in()) {
                        $user_id = get_current_user_id();
                        $wishlist_args = array(
                            'post_type' => 'wishlists',
                            'posts_per_page' => -1,
                            'author' => $user_id,
                        );
                        $wishlist_query = new WP_Query($wishlist_args);
                        if ($wishlist_query->have_posts()) {
                            while ($wishlist_query->have_posts()) {
                                $wishlist_query->the_post();
                                $wishlisted_product_id = get_field('product_id');
                                if($wishlisted_product_id == $product_id) {
                                    $has_wishlisted = true;
                                    $wishlist_id = get_the_id();
                                }
                            }
                        }
                        wp_reset_postdata();
                    }
                    ?>
                    <form action="" class="add_wishlist <?= $has_wishlisted ? 'd-none' : '' ?>">
                        <input type="hidden" name="w_product_id" value="<?= $product_id;?>">
                        <input type="hidden" name="user_id" value="<?= $user_id;?>">
                        <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                        </button>
                        <span class="spinner spinner2"></span>
                    </form>
                    <form action="" class="remove_wishlist <?= $has_wishlisted ? '' : 'd-none' ?>">
                        <input type="hidden" name="wishlist_id" value="<?= $wishlist_id;?>">
                        <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 active">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                        </button>
                        <span class="spinner spinner2"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<?php
} else {
?>
<p>No Products found.</p>
<?php
}
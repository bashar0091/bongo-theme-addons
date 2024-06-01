<?php
$wishlist_product_ids = array();
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
        $wishlist_product_id = get_field('product_id');
        $wishlist_product_ids[] = $wishlist_product_id;

        // Store wishlist ID associated with each product ID
        $wishlist_id = get_the_ID();
        $wishlist_ids[$wishlist_product_id] = $wishlist_id;
    }
}

$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'post__in' => $wishlist_product_ids,
);
$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
    <div class="row">
        <?php
        while ($query->have_posts()) {
            $query->the_post();

            $product_id = get_the_id();
            // Get the wishlist ID associated with the current product
            $product_wishlist_id = $wishlist_ids[$product_id];
            $product = wc_get_product($product_id);
            $sale_price = $product->get_regular_price();
            ?>
            <div class="col-6 col-md-4">
                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                    <div class="pc__img-wrapper">
                        <a href="<?= get_the_permalink();?>">
                            <img loading="lazy" src="<?= get_the_post_thumbnail_url();?>" alt="Cropped Faux leather Jacket" class="pc__img" style="height:100%;">
                        </a>

                        <!-- Output the wishlist ID associated with the current product -->
                        <a href="<?= home_url("/etheme/my-account/wishlist/?wishlist_id=$product_wishlist_id")?>" class="btn-remove-from-wishlist">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_close"></use></svg>
                        </a>
                    </div>

                    <div class="pc__info position-relative">
                        <h6 class="pc__title"><a href="<?= get_the_permalink();?>"><?= get_the_title();   ?></a></h6>
                        <div class="product-card__price d-flex">
                            <span class="money price"><?= wc_price($sale_price);?></span>
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
    echo "No wishlist Added";
}
?>

<?php

class Theme_Product_Tab_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'Theme_Product_Tab_Widget';
    }

    public function get_title() {
        return esc_html__( 'Product Tab', 'core_field' );
    }

    public function get_icon() {
        return 'eicon-elementor';
    }

    public function get_categories() {
        return [ 'theme-widget-category' ];
    }

    public function get_keywords() {
        return [ 'Theme', 'Product Tab' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'product_tab_content',
            [
                'label' => esc_html__( 'Product Tab Content', 'core_field' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'product_tab_title',
            [
                'label' => esc_html__('Title', 'core_field'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'OUR TRENDY PRODUCTS',
            ]
        );

        $repeater = new \Elementor\Repeater();
        $product_categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);
        $options = [];
        if (!is_wp_error($product_categories)) {
            foreach ($product_categories as $category) {
                $options[$category->term_id] = $category->name;
            }
        }
        $repeater->add_control(
            'product_category',
            [
                'label' => esc_html__('Select Category', 'core_field'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'options' => $options,
            ]
        );
        $this->add_control(
			'product_category_s',
			[
				'label' => esc_html__( 'Product Category', 'core_field' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'product_category' => '',
					],
				],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $product_tab_title = $settings['product_tab_title'];
        $product_category_s = $settings['product_category_s'];
        ?>
        
        <section class="products-grid container">
            <h2 class="section-title text-uppercase text-center mb-1 mb-md-3 pb-xl-2 mb-xl-4"><?= $product_tab_title;?></h2>

            <ul class="nav nav-tabs mb-3 text-uppercase justify-content-center" id="collections-tab" role="tablist">
                <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="collections-tab-1-trigger" data-bs-toggle="tab" href="#collections-tab-1" role="tab" aria-controls="collections-tab-1" aria-selected="true">All</a>
                </li>

                <?php 
                if( $product_category_s ) {
                    $i = 1;
                    foreach($product_category_s as $category ) {
                        $category_id = $category['product_category'];
                        $category = get_term($category_id, 'product_cat');
                        $category_name = $category->name;

                        $i++;
                        ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link nav-link_underscore" id="collections-tab-<?= $i;?>-trigger" data-bs-toggle="tab" href="#collections-tab-<?= $i;?>" role="tab" aria-controls="collections-tab-<?= $i;?>" aria-selected="true"><?= $category_name;?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>

            <div class="tab-content pt-2" id="collections-tab-content">

                <div class="tab-pane fade show active" id="collections-tab-1" role="tabpanel" aria-labelledby="collections-tab-1-trigger">
                    <div class="row">
                        <?php 
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 8
                        );

                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();

                                $product_id = get_the_id();
                                $product = wc_get_product($product_id);
                                $sale_price = $product->get_regular_price();

                                $gallery_image_id = $product->get_gallery_image_ids()[0];
                                $gallery_image_url = wp_get_attachment_url($gallery_image_id);
                            ?>
                            <div class="col-6 col-md-4 col-lg-3">
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
                                        <h6 class="pc__title"><a href="<?= get_the_permalink();?>"><?= get_the_title();   ?></a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price"><?= wc_price($sale_price);?></span>
                                        </div>

                                        <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }

                            wp_reset_postdata();
                        }
                        ?>
                    </div><!-- /.row -->
                    
                    <div class="text-center mt-2">
                        <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="<?= home_url('/shop');?>">Discover More</a>
                    </div>
                </div><!-- /.tab-pane fade show-->

                <?php 
                if( $product_category_s ) {
                    $i = 1;
                    foreach($product_category_s as $category ) {
                        $category_id = $category['product_category'];
                        $category = get_term($category_id, 'product_cat');
                        $category_link = get_category_link($category_id, 'product_cat');
                        $category_name = $category->name;

                        $i++;
                        ?>
                        <div class="tab-pane fade show" id="collections-tab-<?= $i;?>" role="tabpanel" aria-labelledby="collections-tab-<?= $i;?>-trigger">
                            <div class="row">
                                <?php 
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 8,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'term_id',
                                            'terms'    => $category_id,
                                        ),
                                    ),
                                );

                                $query = new WP_Query($args);
                                if ($query->have_posts()) {
                                    while ($query->have_posts()) {
                                        $query->the_post();

                                        $product_id = get_the_id();
                                        $product = wc_get_product($product_id);
                                        $sale_price = $product->get_regular_price();
                                    ?>
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                            <div class="pc__img-wrapper">
                                            <a href="<?= get_the_permalink();?>">
                                                <img loading="lazy" src="<?= get_the_post_thumbnail_url();?>" alt="Cropped Faux leather Jacket" class="pc__img" style="height:100%;">
                                                <img loading="lazy" src="<?= get_the_post_thumbnail_url();?>" alt="Cropped Faux leather Jacket" class="pc__img pc__img-second" style="height:100%;">
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
                                            <h6 class="pc__title"><a href="<?= get_the_permalink();?>"><?= get_the_title();   ?></a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price"><?= wc_price($sale_price);?></span>
                                            </div>

                                            <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }

                                    wp_reset_postdata();
                                }
                                ?>
                            </div><!-- /.row -->
                            
                            <div class="text-center mt-2">
                                <a class="btn-link btn-link_lg default-underline default-underline text-uppercase fw-medium" href="<?= $category_link;?>">See All Products</a>
                            </div>
                        </div><!-- /.tab-pane fade show-->
                        <?php
                    }
                }
                ?>
                
            </div><!-- /.tab-content pt-2 -->
        </section><!-- /.products-grid -->

        <div class="mb-3 mb-xl-5 pb-1 pb-xl-5"></div>

        <?php

    }
}
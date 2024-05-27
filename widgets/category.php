<?php

class Theme_Category_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'Theme_Category_Widget';
    }

    public function get_title() {
        return esc_html__( 'Category Section', 'core_field' );
    }

    public function get_icon() {
        return 'eicon-elementor';
    }

    public function get_categories() {
        return [ 'theme-widget-category' ];
    }

    public function get_keywords() {
        return [ 'Theme', 'Category Section' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'cat_content',
            [
                'label' => esc_html__( 'Category Section Content', 'core_field' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                $options[$category->slug] = $category->name;
            }
        }
        $repeater->add_control(
            'product_category',
            [
                'label' => esc_html__('Select Category', 'textdomain'),
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

        $product_category_s = $settings['product_category_s'];
        ?>

        <section class="collections-grid collections-grid_masonry" id="section-collections-grid_masonry">
            <div class="container h-md-100">
                <div class="row h-md-100">
                    <div class="col-lg-6 h-md-100">
                        <?php 
                        $i = 0;
                        if( $product_category_s ) {
                            foreach($product_category_s as $category ) {
                                $i++;

                                if($i == 1) {
                                    echo $category['product_category'];
                                }
                            }
                        }
                        ?>
                        <div class="collection-grid__item position-relative h-md-100">
                            <div class="background-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/collection_grid_1.jpg');"></div>
                            <div class="content_abs content_bottom content_left content_bottom-md content_left-md">
                                <p class="text-uppercase mb-1">Hot List</p>
                                <h3 class="text-uppercase"><strong>Women</strong> Collection</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                            <!-- /.content_abs content_bottom content_left content_bottom-md content_left-md -->
                        </div>
                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-lg-6 d-flex flex-column">
                        <?php 
                        $i = 0;
                        if( $product_category_s ) {
                            foreach($product_category_s as $category ) {
                                $i++;

                                if($i == 2) {
                                    echo $category['product_category'];
                                }
                            }
                        }
                        ?>
                        <div class="collection-grid__item position-relative flex-grow-1 mb-lg-4">
                            <div class="background-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/collection_grid_2.jpg');"></div>
                            <div class="content_abs content_bottom content_left content_bottom-md content_left-md">
                                <p class="text-uppercase mb-1">Hot List</p>
                                <h3 class="text-uppercase"><strong>Men</strong> Collection</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                            <!-- /.content_abs content_bottom content_left content_bottom-md content_left-md -->
                        </div>
                        <div class="position-relative flex-grow-1 mt-lg-1">
                            <div class="row h-md-100">
                                <?php 
                                $i = 0;
                                if( $product_category_s ) {
                                    foreach($product_category_s as $category ) {
                                        $i++;

                                        if($i == 3) {
                                            echo $category['product_category'];
                                        }
                                    }
                                }
                                ?>
                                <div class="col-md-6 h-md-100">
                                    <div class="collection-grid__item h-md-100 position-relative">
                                        <div class="background-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/collection_grid_3.jpg');"></div>
                                        <div class="content_abs content_bottom content_left content_bottom-md content_left-md">
                                            <p class="text-uppercase mb-1">Hot List</p>
                                            <h3 class="text-uppercase"><strong>Kids</strong> Collection</h3>
                                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                                        </div>
                                        <!-- /.content_abs content_bottom content_left content_bottom-md content_left-md -->
                                    </div>
                                    <!-- /.collection-grid__item -->
                                </div>

                                <?php 
                                $i = 0;
                                if( $product_category_s ) {
                                    foreach($product_category_s as $category ) {
                                        $i++;

                                        if($i == 4) {
                                            echo $category['product_category'];
                                        }
                                    }
                                }
                                ?>
                                <div class="col-md-6 h-md-100">
                                    <div class="collection-grid__item h-md-100 position-relative">
                                        <div class="background-img" style="background-color: #f5e6e0;"></div>
                                        <div class="content_abs content_bottom content_left content_bottom-md content_left-md">
                                            <h3 class="text-uppercase"><strong>E-Gift</strong> Cards</h3>
                                            <p class="mb-1">
                                                Surprise someone with the gift they<br />
                                                really want.
                                            </p>
                                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                                        </div>
                                        <!-- /.content_abs content_bottom content_left content_bottom-md content_left-md -->
                                    </div>
                                    <!-- /.collection-grid__item -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>
        <!-- /.collections-grid collections-grid_masonry -->

        <?php

    }
}
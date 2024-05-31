<?php

class Theme_Fixed_Checkout_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'Theme_Fixed_Checkout_Widget';
    }

    public function get_title() {
        return esc_html__( 'Fixed Checkout', 'core_field' );
    }

    public function get_icon() {
        return 'eicon-elementor';
    }

    public function get_categories() {
        return [ 'theme-widget-category' ];
    }

    public function get_keywords() {
        return [ 'Theme', 'Fixed Checkout' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'fixed_checkout_content',
            [
                'label' => esc_html__( 'Checkout Content', 'core_field' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $repeater = new \Elementor\Repeater();
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );
        $products = get_posts( $args );
        $product_options = array();
        foreach ( $products as $product ) {
            $product_options[ $product->ID ] = $product->post_title;
        }
        $repeater->add_control(
            'product_list',
            [
                'label' => esc_html__( 'Products', 'core_field' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $product_options,
            ]
        );
        $this->add_control(
			'product_list_s',
			[
				'label' => esc_html__( 'Product List', 'core_field' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'product_list' => '',
					],
				],
			]
		);
    
        $this->end_controls_section();
    }    

    protected function render() {
        $settings = $this->get_settings_for_display();

        $product_list_s = $settings['product_list_s'];
        ?>
        <script src="https://cdn.tailwindcss.com"></script>
        <section class="container">
            <div class="max-w-[1000px] mx-auto">
                <form action="" method="post" class="fixed_checkout_submit">
                    <div class="grid xl:grid-cols-2 gap-[30px] p-[15px] xl:p-[40px] bg-[#fafafa]">
                        <div>
                            <h2 class="text-[20px] font-[600] mb-[20px]">Billing details</h2>

                            <div>
                                <div class="mb-[15px]">
                                    <label class="block w-full m-0">
                                        <span class="block m-0 pb-[5px]">আপনার নাম *</span>
                                        <input class="border m-0 p-[10px] border-solid border-[#0000001A] rounded-[2px] block w-full" type="text" name="fixed_name" id="" required>
                                    </label>
                                </div>
                                <div class="mb-[15px]">
                                    <label class="block w-full m-0">
                                        <span class="block m-0 pb-[5px]">আপনার মোবাইল নাম্বার *</span>
                                        <input class="border m-0 p-[10px] border-solid border-[#0000001A] rounded-[2px] block w-full" type="tel" name="fixed_mobile" id="" required>
                                    </label>
                                </div>
                                <div class="mb-[15px]">
                                    <label class="block w-full m-0">
                                        <span class="block m-0 pb-[5px]">আপনার সম্পূর্ণ ঠিকানা *</span>
                                        <input class="border m-0 p-[10px] border-solid border-[#0000001A] rounded-[2px] block w-full" type="tel" name="fixed_address" id="" placeholder="বাসা নং, রোড নং, উপজেলা, জেলা" required>
                                    </label>
                                </div>
                                <div>
                                    <span class="block m-0 pb-[5px]">Country / Region *</span>
                                    <span class="font-bold">Bangladesh</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-[20px] font-[600] mb-[20px]">Your order</h2>

                            <div>
                                <table class="w-full">
                                    <tr>
                                        <th class="p-[10px] border-b border-dashed border-[#ccc]">Product</th>
                                        <th class="p-[10px] border-b border-dashed border-[#ccc]">Subtotal</th>
                                    </tr>

                                    <?php 
                                    $total_price = 0;
                                    if(!empty($product_list_s)) {
                                        foreach($product_list_s as $product) {

                                            $product_id = $product['product_list'];
                                            $products = wc_get_product($product_id);
                                            $product_title = $products->get_title();
                                            $product_price = $products->get_price();
                                            $featured_image_url = get_the_post_thumbnail_url($product_id, 'full');

                                            $total_price += $product_price;
                                            ?>
                                            <tr>
                                                <td class="p-[10px]">
                                                    <input type="hidden" name="product_id[]" value="<?= $product_id;?>">
                                                    <div class="flex items-center gap-[10px]">
                                                        <img src="<?= $featured_image_url;?>" class="w-[45px] h-[45px] rounded-[4px] object-cover" alt="product_img">
                                                        <span><?= $product_title;?></span>
                                                        <span>× 1</span>
                                                    </div>
                                                </td>
                                                <td class="p-[10px]">৳ <?= $product_price;?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    <tr>
                                        <td class="p-[10px]  border-t border-dashed border-[#ccc]">
                                            Subtotal
                                        </td>
                                        <td class="p-[10px]  border-t border-dashed border-[#ccc]">৳ <?= $total_price;?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-[10px]">
                                            Shipping
                                        </td>
                                        <td class="p-[10px]">Free shipping</td>
                                    </tr>
                                    <tr>
                                        <td class="p-[10px]  border-t border-dashed border-[#ccc]">
                                            <b>Total</b>
                                        </td>
                                        <td class="p-[10px]  border-t border-dashed border-[#ccc]"><b>৳ <?= $total_price;?></b></td>
                                    </tr>
                                </table>

                                <div class="bg-[#f4f8fa] rounded-[3px] p-[20px]">
                                    <span class="block m-0 pb-[10px]">Cash on delivery</span>
                                    <span class="block m-0 bg-[#fff] p-[10px]">Pay with cash upon delivery.</span>
                                </div>

                                <p class="my-[20px]">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>

                                <button type="submit" class="bg-[#1D1D1D] text-[#fff] px-[15px] py-[8px]">Place Order  ৳ <?= $total_price;?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pb-1 pb-xl-5"></div>

        <?php

    }
}
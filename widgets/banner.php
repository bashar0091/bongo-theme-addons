<?php

class Theme_Banner_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'Theme_Banner_Widget';
    }

    public function get_title() {
        return esc_html__( 'Banner Section', 'core_field' );
    }

    public function get_icon() {
        return 'eicon-elementor';
    }

    public function get_categories() {
        return [ 'theme-widget-category' ];
    }

    public function get_keywords() {
        return [ 'Theme', 'Banner Section' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'banner_content',
            [
                'label' => esc_html__( 'Banner Section Content', 'core_field' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'title1',
			[
				'label' => esc_html__( 'Title 1', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'title2',
			[
				'label' => esc_html__( 'Title 2', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'title3',
			[
				'label' => esc_html__( 'Title 3', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'title4',
			[
				'label' => esc_html__( 'Title 4', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Text', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Button Link', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'bg_img',
			[
				'label' => esc_html__( 'Background Image', 'core_field' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			],
		);
        $repeater->add_control(
			'slider_img',
			[
				'label' => esc_html__( 'Slider Image', 'core_field' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			],
		);
        $this->add_control(
			'banner_slider',
			[
				'label' => esc_html__( 'Slider', 'core_field' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title1' => 'New Trend',
						'title2' => 'Summer Sale Stylish',
						'title3' => 'Womens',
						'title4' => 'Summer',
						'btn_text' => 'Discover More',
						'btn_link' => '#!',
					],
				],
				'title_field' => '{{{ title2 }}}',
			]
		);

        $this->end_controls_section();


        // social content 
        $this->start_controls_section(
            'social_content',
            [
                'label' => esc_html__( 'Social Section Content', 'core_field' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'social_icon',
			[
				'label' => esc_html__( 'Icon', 'core_field' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
			],
		);
        $repeater->add_control(
			'social_link',
			[
				'label' => esc_html__( 'Social Link', 'core_field' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			],
		);
        $this->add_control(
			'social_icon_s',
			[
				'label' => esc_html__( 'Social Icons', 'core_field' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => '',
						'social_link' => '#!',
					],
				],
			]
		);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $banner_slider = $settings['banner_slider'];
        $social_icon_s = $settings['social_icon_s'];
        ?>

        <main>
            <section
                class="swiper-container js-swiper-slider slideshow full-width_padding"
                data-settings='{
                "autoplay": {
                "delay": 5000
                },
                "slidesPerView": 1,
                "effect": "fade",
                "loop": true,
                "pagination": {
                "el": ".slideshow-pagination",
                "type": "bullets",
                "clickable": true
                }
            }'
            >
                <div class="swiper-wrapper">
                    <?php 
                    if( $banner_slider ) {
                        foreach($banner_slider as $data ) {
                            $title1 = $data['title1'];
                            $title2 = $data['title2'];
                            $title3 = $data['title3'];
                            $title4 = $data['title4'];
                            $btn_text = $data['btn_text'];
                            $btn_link = $data['btn_link'];
                            $bg_img = esc_url($data['bg_img']['url']);
                            $slider_img = esc_url($data['slider_img']['url']);
                            ?>
                            <div class="swiper-slide full-width_border border-1" style="border-color: #f5e6e0;">
                                <div class="overflow-hidden position-relative h-100">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="<?= $bg_img;?>" width="1761" height="778" alt="Pattern" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                    
                                    <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                                        <img
                                            loading="lazy"
                                            src="<?= $slider_img;?>"
                                            width="400"
                                            height="733"
                                            alt="Woman Fashion 1"
                                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 h-auto w-auto"
                                        />
                                        <div class="character_markup">
                                            <p class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10"><?= $title4;?></p>
                                        </div>
                                    </div>
                                    <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                                        <h6 class="text_dash text-uppercase text-red fs-base fw-medium animate animate_fade animate_btt animate_delay-3"><?= $title1;?></h6>
                                        <h2 class="text-uppercase h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5"><?= $title2;?></h2>
                                        <h2 class="text-uppercase h1 fw-bold animate animate_fade animate_btt animate_delay-5"><?= $title3;?></h2>
                                        <a href="<?= $btn_link;?>" class="btn-link btn-link_lg default-underline text-uppercase fw-medium animate animate_fade animate_btt animate_delay-7"><?= $btn_text;?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- /.slideshow-wrapper js-swiper-slider -->

                <div class="container">
                    <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-5"></div>
                    <!-- /.products-pagination -->
                </div>
                <!-- /.container -->

                <div class="slideshow-social-follow d-none d-xxl-block position-absolute top-50 start-0 translate-middle-y text-center">
                    <ul class="social-links list-unstyled mb-0 text-secondary">
                        <?php 
                        if( $social_icon_s ) {
                            foreach($social_icon_s as $icon ) {
                                $social_link = $icon['social_link'];
                                ?>
                                <li>
                                    <a href="<?= $social_link;?>" class="footer__social-link d-block">
                                        <?php \Elementor\Icons_Manager::render_icon( $icon['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <!-- /.social-links list-unstyled mb-0 text-secondary -->
                    <span class="slideshow-social-follow__title d-block mt-5 text-uppercase fw-medium text-secondary">Follow Us</span>
                </div>
                <!-- /.slideshow-social-follow -->
                <a href="#section-collections-grid_masonry" class="slideshow-scroll d-none d-xxl-block position-absolute end-0 bottom-0 text_dash text-uppercase fw-medium">Scroll</a>
            </section>
            <!-- /.slideshow -->

            <div class="mb-5 pb-5"></div>
            <div class="pb-1"></div>

        </main>


        <?php

    }
}
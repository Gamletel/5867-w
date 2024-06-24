<?php

class WooThemeFunctions
{
    /*
     * WC GLOBAL
     */
    public function error_fade_out(){
        // если находимся не на странице оформления заказа, то ничего не делаем
        if( ! is_checkout() ) {
            return;
        }

        wc_enqueue_js( "
		$( document.body ).on( 'checkout_error', function(){
			setTimeout( function(){
				$('.woocommerce-error').fadeOut( 300 );
			}, 2000);
		})
	" );
    }
    public function wc_refresh_mini_cart_count($fragments)
    {
        ob_start();
        $products_count = WC()->cart->get_cart_contents_count();
        if ($products_count > 99){
            $products_count = '99+';
        }
        ?>
        <div id="cart-count">
            <?php echo $products_count; ?>
        </div>
        <?php
        $fragments['#cart-count'] = ob_get_clean();
        return $fragments;
    }

    function custom_sale_price($price, $product)
    {

//        if ($product->is_on_sale()) {
//
//            return '<span class="red-dot"></span>' . $price;
//        }

        $price = '<div class="product-price">' . $price . '/шт.</div>';

        return $price;
    }


    function custom_variable_product_price($price, $product)
    {
        $prices = $product->get_variation_prices('min', true);
        $maxprices = $product->get_variation_price('max', true);
        $min_price = current($prices['price']);
        //$max_price = current( $maxprices['price'] );
        $minPrice = sprintf(__('От %1$s <br>', 'woocommerce'), wc_price($min_price));
        $maxPrice = sprintf(__('до %1$s', 'woocommerce'), wc_price($maxprices));
        return $minPrice . ' ' . $maxPrice;
    }

    public function custom_breadcrumbs()
    {
        ?>
        <div class="container">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php if (function_exists('bcn_display')) {
                    bcn_display();
                } ?>
            </div>
        </div>
    <?php }

    public function register_my_widgets()
    {
        register_sidebar(
            array(
                'name' => 'Фильтр товаров',
                'id' => "sidebar-shop",
                'description' => '',
                'class' => '',
                'before_sidebar' => '',
                'after_sidebar' => '',
            )
        );
    }

    /*
     * CATEGORY-CARD
     */

    public function remove_count()
    {
        $html = '';
        return $html;
    }

    public function category_image_wrapper($category)
    {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_image_src($thumbnail_id, 'full');
        $image = $image[0];
        $image = str_replace(' ', '%20', $image);
        ?>
        <div class="image-wrapper">
            <img src="<?= esc_url($image); ?>" alt="">
        </div>
        <?php
    }

    public function open_category_content_wrapper()
    {
        ?>
        <div class="category-content">
    <?php }

    public function category_link($category)
    {
        $link = get_category_link($category);
        $terms = get_terms('product_cat', [
            'hide_empty' => false,
            'parent' => $category->term_id,
        ]);
        ?>

        <?php if (!$terms && !is_product_category()) { ?>
        <a href="<?= $link; ?>" class="link">
            Подробнее

            <?= inline('assets/images/arrow.svg'); ?>
        </a>
    <?php } else if (is_product_category()) { ?>
        <div class="link">
            Подробнее

            <?= inline('assets/images/arrow.svg'); ?>
        </div>

        <div class="subcats">
            <div class="container">
                <div class="close-subcats">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <g clip-path="url(#clip0_528_41776)">
                            <path d="M11.0518 0L7 4.05177L2.94823 0L0 2.94823L4.0518 7L0 11.0518L2.9482 14L7 9.9482L11.0518 14L14 11.0518L9.9482 6.99997L14 2.9482L11.0518 0Z"
                                  fill="#C9CCCE"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_528_41776">
                                <rect width="14" height="14" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>

                <div class="subcats__wrapper">
                    <?php foreach ($terms as $item) {
                        $link = get_term_link($item);
                        $title = $item->name;
                        $thumbnail_id = get_term_meta($item->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_image_src($thumbnail_id, 'full');
                        $image = $image[0];
                        $image = str_replace(' ', '%20', $image);
                        ?>
                        <a href="<?= $link; ?>" class="subcat">
                            <?php if ($image) { ?>
                                <img src="<?= esc_url($image); ?>" alt="" class="subcat__thumbnail">
                            <?php } ?>

                            <?php if ($title) { ?>
                                <span class="p2 subcat__title">
                                    <?= $title; ?>
                                </span>
                            <?php } ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <a href="<?= $link; ?>" class="link">
            Подробнее

            <?= inline('assets/images/arrow.svg'); ?>
        </a>
    <?php }
    }

    public function close_category_content_wrapper()
    {
        ?>
        </div>
    <?php }

    public function custom_category_top_part($category)
    {
        $shortDescription = get_field('s-description', $category);
        ?>
        <div class="category-top">
            <h4 class="woocommerce-loop-category__title">
                <?php
                echo esc_html($category->name);
                if ($category->count > 0) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo apply_filters('woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html($category->count) . ')</mark>', $category);
                }
                ?>
            </h4>

            <div class="btn-main disabled-color">
                Подробнее
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5L16 12L9 19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <?php
            if ($shortDescription) { ?>
                <div class="short-descr">
                    <?php echo $shortDescription; ?>
                </div>
                <?php
            } ?>
        </div>
        <?php
    }

    /*
     * ARCHIVE-PRODUCT
     */
    public function products_per_page($cols)
    {
        return 9;
    }

    public function archive_category_banner()
    {
        if (!is_shop()) {
            $query_id = get_queried_object_id();
            $term = get_term($query_id);
            $title = $term->name;
            $description = $term->description;
            $archive_image = wp_get_attachment_image_url(get_field('archive_image', $term), 'full');
            $archive_banner_img_1 = wp_get_attachment_image_url(theme('archive_banner_img_1'), 'full');
            $archive_banner_img_2 = wp_get_attachment_image_url(theme('archive_banner_img_2'), 'full');
            ?>
            <div class="header__main-banner">
                <?php if ($archive_banner_img_1) { ?>
                    <img src="<?= $archive_banner_img_1; ?>" alt="" class="main-banner__img-1">
                <?php } ?>

                <?php if ($archive_banner_img_2) { ?>
                    <img src="<?= $archive_banner_img_2; ?>" alt="" class="main-banner__img-2">
                <?php } ?>

                <div class="main-banner__text">
                    <h1 class="main-banner__title">
                        <?= $title; ?>
                    </h1>

                    <?php if ($description) { ?>
                        <div class="p2 main-banner__description">
                            <?= $description; ?>
                        </div>
                    <?php } ?>
                </div>

                <?php if ($archive_image) { ?>
                    <img src="<?= $archive_image; ?>" class="main-banner__image" alt="">
                <?php } ?>
            </div>
            <?php
        }
    }

    public function archive_advantages()
    {
        if (!is_shop()) {
            $archive_advantages = theme('archive_advantages');

            get_template_part('inc/blocks/advantages-block/render',
                null,
                array('hasBG' => $archive_advantages['hasBG'],
                    'advantages' => $archive_advantages['advantages'],
                ));
            wp_enqueue_style('advantages-block', get_template_directory_uri() . '/inc/blocks/advantages-block/block.css', array(), 2);
            wp_enqueue_script('advantages-block', get_template_directory_uri() . '/inc/blocks/advantages-block/block.js', array(), 2);
        }
    }

    public function archive_subcategories()
    {
        if (!is_shop()) {
            $query_id = get_queried_object_id();
            $term = get_term($query_id);
            $terms = get_terms(array(
                'taxonomy' => 'product_cat',
                'parent' => $query_id,
                'hide_empty' => false,
            ));

            get_template_part('inc/blocks/categories-block/render',
                null,
                array('terms' => $terms,
                ));
            wp_enqueue_style('categories-block', get_template_directory_uri() . '/inc/blocks/categories-block/block.css', array(), 2);
            wp_enqueue_script('categories-block', get_template_directory_uri() . '/inc/blocks/categories-block/block.js', array(), 2);
        }
    }

    public function archive_products_title()
    {
        echo '<div class="container">
                <h1 class="page-title">
                    Каталог
                </h1>
              </div>';
    }

    public function archive_products_advantages()
    {
        $archive_products_advantages = theme('archive_products_advantages');
        if (is_product_category()) {
            ?>

            <div class="container">
                <?php get_template_part('inc/blocks/advantages-v2-block/render',
                    null,
                    array('advantages' => $archive_products_advantages['advantages'],
                        'image_1' => $archive_products_advantages['image_1'],
                        'image_2' => $archive_products_advantages['image_2'],
                    ));
                wp_enqueue_style('advantages-v2-block', get_template_directory_uri() . '/inc/blocks/advantages-v2-block/block.css', array(), 2);
                wp_enqueue_script('advantages-v2-block', get_template_directory_uri() . '/inc/blocks/advantages-v2-block/block.js', array(), 2);
                ?>
            </div>
            <?php
        }
    }

    public function archive_products_additional_blocks()
    {
        ?>
        <div class="catalog__additional-blocks">
            <div class="container">
                <?php
                if (is_product_category() || is_product()) {
                    $footer_slider = theme('footer_slider');
                    get_template_part('inc/blocks/slider-block/render',
                        null,
                        array(
                            'block_title' => $footer_slider['block_title'],
                            'slides' => $footer_slider['slides'],
                        ));
                    wp_enqueue_style('slider-block', get_template_directory_uri() . '/inc/blocks/slider-block/block.css', array(), 2);
                    wp_enqueue_script('slider-block', get_template_directory_uri() . '/inc/blocks/slider-block/block.js', array(), 2);

                    if (is_product_category()) {
                        $footer_brands = theme('footer_brands');
                        get_template_part('inc/blocks/brands-block/render',
                            null,
                            array(
                                'block_title' => $footer_brands['block_title'],
                                'show_all' => $footer_brands['show_all'],
                            ));
                        wp_enqueue_style('brands-block', get_template_directory_uri() . '/inc/blocks/brands-block/block.css', array(), 2);
                        wp_enqueue_script('brands-block', get_template_directory_uri() . '/inc/blocks/brands-block/block.js', array(), 2);

                        $footer_text_block = theme('footer_text_block');
                        get_template_part('inc/blocks/text-block/render',
                            null,
                            array(
                                'block_title' => $footer_text_block['block_title'],
                                'text' => $footer_text_block['text'],
                                'image' => $footer_text_block['image'],
                            ));
                        wp_enqueue_style('text-block', get_template_directory_uri() . '/inc/blocks/text-block/block.css', array(), 2);
                        wp_enqueue_script('text-block', get_template_directory_uri() . '/inc/blocks/text-block/block.js', array(), 2);
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

    /*
     * PRODUCT-CARD
     */
    public function open_product_card_top_part()
    { ?>
        <div class="product-card__top">
    <?php }

    public function product_card_tags()
    {
        global $product;
        $terms = get_terms([
            'taxonomy' => 'product_tag',
            'include' => $product->get_tag_ids()
        ]);
        ?>
        <?php if ($terms) { ?>
        <div class="product-card__tags tags">
            <?php foreach ($terms as $term) {
                $name = $term->name;
                ?>
                <div class="tag"><?= $name; ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php }

    public function close_product_card_top_part()
    { ?>
        </div>
    <?php }

    public function product_card_bottom_part()
    {
        global $product;
        $product_link = $product->get_permalink();
        ?>
        <div class="product-card__bottom">
            <?php woocommerce_template_loop_product_title(); ?>

            <?php if ($additional_attributes) { ?>
                <div class="additional-attributes">
                    <div class="additional-attributes__top">
                        <?php foreach ($additional_attributes as $key => $item) {
                            $icon = wp_get_attachment_image_url($item['icon'], 'full');
                            $value = $item['value'];
                            ?>
                            <?php if ($key < 3) { ?>
                                <div class="additional-attribute">
                                    <?php if ($icon) { ?>
                                        <img src="<?= $icon; ?>" alt="" class="style-svg">
                                    <?php } ?>

                                    <?php if ($value) { ?>
                                        <div class="additional-attribute__value p3">
                                            <?= $value; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="product-card__price">
                <div class="price">
                    <?= $product->get_price(); ?>

                    <?= get_woocommerce_currency_symbol(); ?>
                </div>

                <?= woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
    <?php }

    public function product_card_additional_blocks(){
        global $product;
        $related_products = wc_get_related_products($product->get_id(), 10);

        get_template_part('inc/blocks/products-block/render',
            null,
            array('block_title' => 'Похожие товары',
                'products'=>$related_products,
            ));
        wp_enqueue_style('products-block', get_template_directory_uri() . '/inc/blocks/products-block/block.css', array(), 2);
        wp_enqueue_script('products-block', get_template_directory_uri() . '/inc/blocks/products-block/block.js', array(), 2);


        $block_title = isset($args['block_title']) ? $args['block_title'] : get_field('block_title');
    }

    public function show_additional_blocks()
    {
        $footer_sales_block = theme('footer_sales_block');
        get_template_part('inc/blocks/sales-block/render',
            null,
            array('block_additional' => $footer_sales_block['block_additional'],
                'block_title' => $footer_sales_block['block_title'],
                'btn_text' => $footer_sales_block['btn_text'],
                'sales' => $footer_sales_block['sales'],
                'image' => $footer_sales_block['image'],
            ));
        wp_enqueue_style('sales-block', get_template_directory_uri() . '/inc/blocks/sales-block/block.css', array(), 2);
        wp_enqueue_script('sales-block', get_template_directory_uri() . '/inc/blocks/sales-block/block.js', array(), 2);


        $footer_employees_block = theme('footer_employees_block');
        get_template_part('inc/blocks/employees-block/render',
            null,
            array('block_title' => $footer_employees_block['block_title'],
                'show_all' => $footer_employees_block['show_all'],
                'employees' => $footer_employees_block['employees'],
            ));
        wp_enqueue_style('employees-block', get_template_directory_uri() . '/inc/blocks/employees-block/block.css', array(), 2);
        wp_enqueue_script('employees-block', get_template_directory_uri() . '/inc/blocks/employees-block/block.js', array(), 2);


        $footer_form_block = theme('footer_form_block');
        get_template_part('inc/blocks/form-block/render',
            null,
            array('block_title' => $footer_form_block['block_title'],
                'image' => $footer_form_block['image'],
            ));
        wp_enqueue_style('form-block', get_template_directory_uri() . '/inc/blocks/form-block/block.css', array(), 2);
        wp_enqueue_script('form-block', get_template_directory_uri() . '/inc/blocks/form-block/block.js', array(), 2);


        $footer_advantages_block = theme('footer_advantages_block');
        get_template_part('inc/blocks/advantages-block/render',
            null,
            array('block_title' => $footer_advantages_block['block_title'],
                'advantages' => $footer_advantages_block['advantages'],
            ));
        wp_enqueue_style('advantages-block', get_template_directory_uri() . '/inc/blocks/advantages-block/block.css', array(), 2);
        wp_enqueue_script('advantages-block', get_template_directory_uri() . '/inc/blocks/advantages-block/block.js', array(), 2);


        $footer_certificates_block = theme('footer_certificates_block');
        get_template_part('inc/blocks/certificates-block/render',
            null,
            array('block_title' => $footer_certificates_block['block_title'],
                'show_all' => $footer_certificates_block['show_all'],
                'numberposts' => $footer_certificates_block['numberposts'],
                'certificates' => $footer_certificates_block['certificates'],
            ));
        wp_enqueue_style('certificates-block', get_template_directory_uri() . '/inc/blocks/certificates-block/block.css', array(), 2);
        wp_enqueue_script('certificates-block', get_template_directory_uri() . '/inc/blocks/certificates-block/block.js', array(), 2);

    }

    /*
     * PRODUCT-PAGE
     */
    public function show_custom_title()
    {
        global $product;
        echo '<h1 class="product_title">' . get_the_title($product->get_id()) . '</h1>';
    }

    public function custom_product_swiper()
    {
        global $product;

        $video = get_field('video', $product->get_id());
        $thumbnail = wp_get_attachment_image($product->get_image(), 'full');
        $images = $product->get_gallery_image_ids();
        ?>

        <div class="product__gallery">
            <?php if ($video) {
                $image = wp_get_attachment_image_url($video['image'], 'full');
                $link = $video['link'];
                ?>
                <div class="video" data-fancybox data-src='http://www.youtube.com/embed/<?= $link; ?>'>
                    <img src="<?= $image; ?>" alt="">

                    <div class="play">
                        <?= inline('assets/images/play.svg'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($thumbnail) { ?>
                <img src="<?= $thumbnail; ?>" class="thumbnail" data-fancybox='gallery' data-src='<?= $thumbnail; ?>'
                     alt="">
            <?php } ?>

            <?php foreach ($images as $item) {
                $image = wp_get_attachment_image_url($item, 'full');
                ?>
                <div class="image" data-fancybox='gallery' data-src='<?= $image; ?>'>
                    <img src="<?= $image; ?>" alt="">
                </div>
            <?php } ?>
        </div>
        <?php
    }

    public function open_product_main_info()
    { ?>
        <div class="product__main-info">
    <?php }

    public function close_product_main_info()
    {
        ?>
        </div>
    <?php }

    public function product_info()
    {
        global $product;

        $description = $product->get_description();
        $attributes = $product->get_attributes();
        ?>
        <div class="product__info">
            <?php if ($description) { ?>
                <div class="product__description">
                    <h5 class="description__title">
                        Описание
                    </h5>

                    <div class="text-block">
                        <?= $description; ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($attributes) { ?>
                <div class="product__attributes">
                    <h5 class="attributes__title">
                        Характеристики
                    </h5>

                    <div class="attributes">
                        <?= wc_display_product_attributes($product); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    public function product_btns()
    {
        global $product;
        $in_favorites = WCFAVORITES()->check_item($product->get_id());
        $text = get_option('favorites_category_product_text', 'В избранные');
        ?>
        <div class="product__btns">
            <button type="button" data-product_id="<?= $product->get_id() ?>"
                    class="favorites ajax_add_to_favorites <?php if ($in_favorites) {
                        echo 'added';
                    } ?>" aria-label="<?= $text ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.2373 6.2372C20.7839 7.78384 20.8432 10.2726 19.3718 11.891L11.9997 20L4.62812 11.891C3.1568 10.2726 3.21604 7.78386 4.76268 6.23722C6.4896 4.5103 9.33371 4.6679 10.8594 6.57496L12 8.00004L13.1396 6.57491C14.6653 4.66785 17.5104 4.51028 19.2373 6.2372Z"
                          stroke="#F44027" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                Добавить в избранное
            </button>

            <div class="btns__bottom">
                <?php woocommerce_template_single_price(); ?>

                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>
        </div>
        <?php
    }

    public function top_row()
    {
        global $product;
        $terms = get_terms([
            'taxonomy' => 'product_tag',
            'include' => $product->get_tag_ids()
        ]);
        ?>
        <div class="top-row">
            <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
                <span class="sku_wrapper p3"><?php esc_html_e('SKU:', 'woocommerce'); ?> <span
                            class="sku p3"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span></span>
            <?php endif; ?>

            <?php if ($terms) { ?>
                <div class="tags">
                    <?php foreach ($terms as $term) {
                        $name = $term->name;
                        ?>
                        <div class="tag"><?= $name; ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php }

    public function additional_attributes()
    {
        global $product;
        $additional_attributes = get_field('additional_attributes', $product->get_id());
        if ($additional_attributes) { ?>
            <div class="additional-attributes">
                <?php foreach ($additional_attributes as $item) {
                    $icon = wp_get_attachment_image_url($item['icon'], 'full');
                    $value = $item['value'];
                    ?>
                    <div class="additional-attribute">
                        <?php if ($icon) { ?>
                            <img src="<?= $icon; ?>" alt="" class="style-svg">
                        <?php } ?>

                        <?php if ($value) { ?>
                            <div class="p2"><?= $value; ?></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php }
    }

    public function file_for_download()
    {
        global $product;
        $document = get_field('document', $product->get_id()); ?>
        <?php if ($document) {
        $name = $document['name'];
        $file = $document['file'];
        ?>
        <a href="<?= $file; ?>" class="link link-accent product__file" download="">
            <?= $name; ?>

            <?= inline('assets/images/arrow.svg'); ?>
        </a>
    <?php } ?>
    <?php }

    public function show_additional_options()
    {
        global $product;
        $additional_options = get_field('additional_options', $product->get_id());
        if ($additional_options) { ?>
            <div class="additional-options">
                <div class="p2 additional-options__title">Дополнительные опции</div>

                <div class="additional-options__wrapper">
                    <?php foreach ($additional_options as $key => $option) {
                        $name = $option['name'];
                        ?>
                        <div class="additional-option">
                            <input type="checkbox" name="additional-option" id="additional-option-<?= $key; ?>"
                                   class="additional-option__checkbox">

                            <label class="p2 additional-option__title"
                                   for="additional-option-<?= $key; ?>">
                                <div class="additional-option__checkbox-custom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="7" viewBox="0 0 9 7"
                                         fill="none">
                                        <path d="M1 3.50002L3.33348 6L8 1" stroke="#34A0E1" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>

                                <?= $name; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php }

    public function show_variation_title()
    {
        echo '<div class="p2 variation-price-title">Стоимость</div>';
    }

    public function woocommerce_custom_single_add_to_cart_text()
    {
        return __('Добавить в корзину', 'woocommerce');
    }

    public function add_to_favorite_btn()
    {
        global $product;
        $in_favorites = WCFAVORITES()->check_item($product->get_id());
        $text = get_option('favorites_category_product_text', 'В избранные');
        ?>

        <button type="button" data-product_id="<?= $product->get_id() ?>"
                class="favorites ajax_add_to_favorites <?php if ($in_favorites) {
                    echo 'added';
                } ?>" aria-label="<?= $text ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 8.19444C10 3.5 3 4 3 10C3 16.0001 12 21 12 21C12 21 21 16.0001 21 10C21 4 14 3.5 12 8.19444Z"
                      stroke="#262D31" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    <?php }

    public function product_bottom_block()
    {
        global $product;
        $characteristics = get_field('characteristics', $product->get_id());
        $description = $product->get_description();
        $delivery = get_field('delivery', $product->get_id());
        ?>
        <?php if ($characteristics || $description || $delivery) { ?>

    <?php } ?>
        <div class="product__bottom-block">
            <div class="tabs">
                <?php if ($characteristics) { ?>
                    <div class="btn disabled tab" data-tab="characteristics">Характеристики</div>
                <?php } ?>

                <?php if ($description) { ?>
                    <div class="btn disabled tab" data-tab="description">Описание</div>
                <?php } ?>

                <?php if ($delivery) { ?>
                    <div class="btn disabled tab" data-tab="delivery">Доставка</div>
                <?php } ?>
            </div>

            <?php if ($characteristics) { ?>
                <div class="characteristics tab-block" data-tab="characteristics">
                    <?php foreach ($characteristics as $item) {
                        $name = $item['name'];
                        $value = $item['value'];
                        ?>
                        <div class="characteristic">
                            <?php if ($name) { ?>
                                <div class="p2 characteristic__name"><?= $name; ?></div>
                            <?php } ?>

                            <?php if ($value) { ?>
                                <div class="characteristic__value"><?= $value; ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($description) { ?>
                <div class="description tab-block" data-tab="description">
                    <div class="p2 text-block"><?= $description; ?></div>
                </div>
            <?php } ?>

            <?php if ($delivery) { ?>
                <div class="delivery tab-block" data-tab="delivery">
                    <div class="p2 text-block"><?= $delivery; ?></div>
                </div>
            <?php } ?>
        </div>
    <?php }

    public function product_additional_blocks()
    {
        global $product;
        $related_products = wc_get_related_products($product->get_id(), 7);
        ?>
        <div class="product__additional-blocks">
            <?php
            get_template_part('inc/blocks/products-block/render',
                null,
                array('block_title' => 'Похожие товары',
                    'products' => $related_products,
                ));
            wp_enqueue_style('products-block', get_template_directory_uri() . '/inc/blocks/products-block/block.css', array(), 2);
            wp_enqueue_script('products-block', get_template_directory_uri() . '/inc/blocks/products-block/block.js', array(), 2);
            ?>
        </div>
    <?php }

    public function if_product_not_stock()
    {
        global $product;

        if ($product->get_price() == '') {
            echo '<p class="stock out-of-stock">Товар отсутсвует</p>';
        }
    }

    public function jk_related_products_args($args)
    {
        $args['posts_per_page'] = 5; // количество "Похожих товаров"
        return $args;
    }

    /*
     * PAGE-CART
     */
    public function custom_cart_item_price( $price, $values, $cart_item_key ) {

        $is_on_sale = $values['data']->is_on_sale();

        if ( $is_on_sale ) {

            $_product = $values['data'];
            $regular_price = $_product->get_regular_price();
            $price = '<span class="regular_price">' . wc_price( $regular_price ) . '</span>' . $price;

        }

        return $price;

    }

    public function cart_products_amount(){
        ?>
        <div class="cart-products-count">
            <div class="p2 count__title">Товаров в корзине</div>

            <h6 class="count__number"><?= WC()->cart->get_cart_contents_count() ?></h6>
        </div>
            <?php
    }

    public function custom_woocommerce_empty_cart_action()
    {
        if (isset($_GET['empty_cart']) && 'yes' === esc_html($_GET['empty_cart'])) {
            WC()->cart->empty_cart();

            $referer = wp_get_referer() ? esc_url(remove_query_arg('empty_cart')) : wc_get_cart_url();
            wp_safe_redirect($referer);
        }
    }

    public function custom_woocommerce_empty_cart_button()
    {
        echo '<a href="' . esc_url(add_query_arg('empty_cart', 'yes')) . '" class="p3 clear-cart" title="' . esc_attr('Empty Cart', 'woocommerce') . '"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
  <g clip-path="url(#clip0_172_20054)">
    <path d="M7.89414 0L5 2.89412L2.10588 0L0 2.10588L2.89414 5L0 7.89412L2.10586 9.99998L5 7.10586L7.89414 10L10 7.89412L7.10586 4.99998L10 2.10586L7.89414 0Z" fill="#545454"/>
  </g>
  <defs>
    <clipPath id="clip0_172_20054">
      <rect width="10" height="10" fill="white"/>
    </clipPath>
  </defs>
</svg>
Очистить корзину
</a>';
    }

    /*
     * PAGE-CHECKOUT
     */

    public function custom_checkout_order_review()
    {
        ?>
        <div class="cart-products-count">
            <div class="p2 count__title">Товаров в корзине</div>

            <h6 class="count__number"><?= WC()->cart->get_cart_contents_count() ?></h6>
        </div>
        <?php
    }

    public function open_additional_field_block()
    {
        ?>
        <div class="additional-section__wrapper">
        <h3>Адрес доставки</h3>
        <div class="additional-section__fields">

        <?php
    }

    public function close_additional_field_block()
    {
        ?>
        </div>
        </div>
        <?php
    }

    public function show_shipping_methods()
    {
        ?>
        <div class="shipping-methods-wrapper">
            <h3>Способ получения</h3>

            <?php wc_cart_totals_shipping_html(); ?>
        </div>
        <?php
    }

    public function change_cart_shipping_method_full_label($label, $method)
    {
        $price = $method->cost > 0 ? '(+' . $method->cost . ' руб.)' : '(Бесплатно)';
        $label = '<div class="method__text">
<div class="method__name">' . $method->get_label() . '</div>
<div class="method__price p3">' . $price . '</div>
</div>';

        return $label;
    }

    public function open_payment_methods_block()
    { ?>
        <div class="payment-methods-wrapper">
        <h3>Способы оплаты</h3>
    <?php }

    public function close_payment_methods_block()
    { ?>
        </div>
        <?php
    }

    public function second_place_order_button()
    {
        $order_button_text = apply_filters('woocommerce_order_button_text', __("Place order", "woocommerce"));
        echo '<button type="submit" class="button btn alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>';

        wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce');
    }

    /*
     * PAGE-FAVORITES
     * */

    public function updateFavorites()
    {
        if (WCFAVORITES()->count_items() > 99) {
            echo '99+';
        } else {
            echo WCFAVORITES()->count_items();
        }
        wp_die();
    }

    public function wc_clear_favorite_url()
    {
        if (isset($_REQUEST['clear-fav'])) {
            unset($_COOKIE['WC_FAVORITES']);
        }
    }
}
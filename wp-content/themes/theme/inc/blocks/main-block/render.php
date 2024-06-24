<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align = (isset($block['align']) && !empty($block['align'])) ? 'align' . $block['align'] : '';

$showed_posts = get_field('showed_posts');
?>
<div id="main-block" class="block-margin <?= $classes; ?> <?= $align; ?>">
    <div class="container-wide">
        <div class="products-categories">
            <div class="products-wrapper most-popular">
                <div class="products-wrapper__title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M2.33496 10.3368C2.02171 10.0471 2.19187 9.52337 2.61557 9.47314L8.61914 8.76134C8.79182 8.74086 8.94181 8.63206 9.01465 8.47416L11.5469 2.9843C11.7256 2.59686 12.2764 2.59681 12.4551 2.98425L14.9873 8.47424C15.0601 8.63214 15.2092 8.74087 15.3818 8.76135L21.3857 9.47314C21.8094 9.52337 21.9795 10.0471 21.6662 10.3368L17.2279 14.4415C17.1002 14.5596 17.0433 14.7356 17.0771 14.9061L18.2551 20.8359C18.3383 21.2544 17.8929 21.578 17.5206 21.3696L12.2453 18.4167C12.0935 18.3318 11.9087 18.3317 11.757 18.4166L6.48109 21.3697C6.10878 21.5781 5.66294 21.2545 5.74609 20.836L6.92437 14.9061C6.95826 14.7355 6.90134 14.5596 6.77367 14.4416L2.33496 10.3368Z"
                              stroke="var(--Primary)" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    Популярные продукты
                </div>

                <?php $query_args = array(
                    'showposts' => $showed_posts,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'order' => 'DESC',
                );
                $r = new WP_Query($query_args);
                if ($r->have_posts()) {
                    woocommerce_product_loop_start();

                    while ($r->have_posts()) {
                        $r->the_post();
                        $title = get_the_title();

                        wc_get_template_part('content', 'product');
                    }

                    woocommerce_product_loop_end();
                }
                wp_reset_postdata(); ?>
            </div>

            <div class="products-wrapper last-purchased">
                <div class="products-wrapper__title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11.2308 15.1648C10.2962 15.1648 9.53849 14.4564 9.53849 13.5824C9.53849 12.7085 10.2962 12 11.2308 12M21.9487 7.99116V16.0087C21.9487 17.1904 21.949 17.7813 21.7031 18.2326C21.4867 18.6297 21.1411 18.9523 20.7165 19.1546C20.2338 19.3846 19.6024 19.3846 18.3387 19.3846H5.25153C3.98782 19.3846 3.3555 19.3846 2.87282 19.1546C2.44825 18.9523 2.10332 18.6297 1.88699 18.2326C1.64105 17.7813 1.64105 17.1904 1.64105 16.0087V7.99116C1.64105 6.80951 1.64105 6.21876 1.88699 5.76743C2.10332 5.37043 2.44825 5.04763 2.87282 4.84535C3.3555 4.61539 3.98782 4.61539 5.25153 4.61539H18.3387C19.6024 4.61539 20.2338 4.61539 20.7165 4.84535C21.1411 5.04763 21.4867 5.37043 21.7031 5.76743C21.949 6.21876 21.9487 6.80951 21.9487 7.99116ZM17.4359 13.5824C17.4359 14.4564 16.6783 15.1648 15.7436 15.1648C14.809 15.1648 14.0513 14.4564 14.0513 13.5824C14.0513 12.7085 14.809 12 15.7436 12C16.6783 12 17.4359 12.7085 17.4359 13.5824Z"
                              stroke="var(--Primary)" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    Купили прямо сейчас
                </div>

                <?php
                // Get latest 3 orders.
                $args = array(
                    'limit' => 3,
                );
                $orders = wc_get_orders($args);

                wc_get_template('loop/loop-start.php');

                foreach ($orders as $order) {
                    foreach ($order->get_items() as $item_id => $item) {

                        $product = wc_get_product($item->get_product_id());

                        $post_object = get_post( $product->get_id() );

                        setup_postdata( $GLOBALS['post'] =& $post_object );

                        wc_get_template_part( 'content', 'product' );
                    }
                }

                wc_get_template('loop/loop-end.php');
                ?>
            </div>

            <div class="products-wrapper last-added">
                <div class="products-wrapper__title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path d="M12.4443 7V12H17.4443M12.4443 21C7.47377 21 3.44434 16.9706 3.44434 12C3.44434 7.02944 7.47377 3 12.4443 3C17.4149 3 21.4443 7.02944 21.4443 12C21.4443 16.9706 17.4149 21 12.4443 21Z"
                              stroke="var(--Primary)" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    Уже в продаже
                </div>

                <?php $query_args = array(
                    'showposts' => $showed_posts,
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $r = new WP_Query($query_args);
                if ($r->have_posts()) {
                    woocommerce_product_loop_start();

                    while ($r->have_posts()) {
                        $r->the_post();
                        $title = get_the_title();

                        wc_get_template_part('content', 'product');
                    }

                    woocommerce_product_loop_end();
                }
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</div>
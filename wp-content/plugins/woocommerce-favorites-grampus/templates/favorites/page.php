<?php
global $wp_query;

get_header();

$products = WCFAVORITES()->get_products();

$totalPrices = 0;
$totalOldPrices = 0;
?>
    <div class="favorites-page woocommerce">
        <div class="container">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php if (function_exists('bcn_display')) {
                    bcn_display();
                } ?>
            </div>
            <h1 class="page-title">
                <?php the_title(); ?>
            </h1>
            <?php if ($products) { ?>
                <div class="favorites-wrapper">
                    <div class="items-wrapper">
                        <?php foreach ($products as $item) {
                            $product = wc_get_product($item);
                            $thumbnail = get_the_post_thumbnail_url($item, 'full');
                            $minOrder = 1;
                            if ($product->is_type('simple')) {
                                $totalPrices += $product->get_price() * $minOrder;
                            }
                            if ($product->is_type('simple')) {
                                if ($product->is_on_sale()) {
                                    $totalOldPrices += $product->get_regular_price() * $minOrder;
                                } else {
                                    $totalOldPrices += $product->get_price() * $minOrder;
                                }
                            }
                            ?>
                            <div class="item-product <?php if ($product->is_on_sale()) { ?> on-sale<?php } else { ?> no-sale <?php } ?>">
                                <?php
                                $in_favorites = WCFAVORITES()->check_item($product->get_id());
                                $text = get_option('favorites_single_product_text', 'В избранные');
                                ?>

                                <?php if ($product->is_type('simple')) { ?>
                                    <?php if ($thumbnail) { ?>
                                        <a href="<?= get_permalink($item); ?>" class="product-thumbnail">
                                            <img src="<?= $thumbnail; ?>" alt="">
                                        </a>
                                    <?php } ?>

                                    <a href="<?= get_permalink($item); ?>" class="product-title">
                                        <h5>
                                            <?= $product->get_title(); ?>
                                        </h5>
                                    </a>

                                    <span class="product-price">
                                                <?php
                                                global $product;

                                                echo $product->get_price_html();
                                                ?>
                                        </span>

                                    <form action="<?= get_permalink(get_the_ID()); ?>" class="cart" method="post"
                                          enctype="multipart/form-data">
                                        <?php if ($product->get_price()) {
                                            do_action('woocommerce_before_add_to_cart_quantity');

                                            // woocommerce_quantity_input(
                                            //     array(
                                            //         'min_value' => $minOrder,
                                            //         'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                            //         'input_value' => $minOrder,
                                            //     )
                                            // );

                                            do_action('woocommerce_after_add_to_cart_quantity');
                                        }
                                        ?>
                                        <div class="product-btns">
                                            <button type="submit" name="add-to-cart"
                                                    value="<?php echo esc_attr($product->get_id()); ?>"
                                                    class="single_add_to_cart_button ajax_add_to_cart_button button alt">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 3H3.26835C3.74213 3 3.97922 3 4.17246 3.08548C4.34283 3.16084 4.48871 3.2823 4.59375 3.43616C4.71289 3.61066 4.75578 3.84366 4.8418 4.30957L7.00004 16L17.4195 16C17.8739 16 18.1016 16 18.2896 15.9198C18.4554 15.8491 18.5989 15.7348 18.7051 15.5891C18.8255 15.424 18.8763 15.2025 18.9785 14.7597L20.5477 7.95972C20.7022 7.29025 20.7796 6.95561 20.6946 6.69263C20.6201 6.46207 20.4639 6.26634 20.256 6.14192C20.0189 6 19.6758 6 18.9887 6H5.5M18 21C17.4477 21 17 20.5523 17 20C17 19.4477 17.4477 19 18 19C18.5523 19 19 19.4477 19 20C19 20.5523 18.5523 21 18 21ZM8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20C9 20.5523 8.55228 21 8 21Z"
                                                          stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>

                                            <button type="button" data-product_id="<?= $product->get_id() ?>"
                                                    class="favorites single_add_to_favorites_button ajax_add_to_favorites button alt <?php if ($in_favorites) {
                                                        echo 'added';
                                                    } ?>" aria-label="<?= $text ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M19.2373 6.2372C20.7839 7.78384 20.8432 10.2726 19.3718 11.891L11.9997 20L4.62812 11.891C3.1568 10.2726 3.21604 7.78386 4.76268 6.23722C6.4896 4.5103 9.33371 4.6679 10.8594 6.57496L12 8.00004L13.1396 6.57491C14.6653 4.66785 17.5104 4.51028 19.2373 6.2372Z"
                                                          fill="var(--Primary)" stroke="var(--Primary)"
                                                          stroke-width="1.5"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="info-wrapper">
                        <div class="info-holder">
                            <div class="info-counter count">
                                <div class="p2 info-title">
                                    Товаров в избранном
                                </div>

                                <h6 class="info-value">
                                    <?= WCFAVORITES()->count_items(); ?>
                                </h6>
                            </div>

                            <form action="<?= get_permalink(get_the_ID()); ?>">
                                <button type="submit" class="p3 clear-fav" name="clear-fav">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                                         fill="none">
                                        <g clip-path="url(#clip0_172_20054)">
                                            <path d="M7.89414 0L5 2.89412L2.10588 0L0 2.10588L2.89414 5L0 7.89412L2.10586 9.99998L5 7.10586L7.89414 10L10 7.89412L7.10586 4.99998L10 2.10586L7.89414 0Z"
                                                  fill="#545454"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_172_20054">
                                                <rect width="10" height="10" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    Очистить избранное
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="not-founded">
                    Товаров в избранном нет!
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        jQuery(function ($) {
            $('body').on('removed_from_favorites', function () {
                location.reload();
            });
        });
    </script>
<?php
get_footer();
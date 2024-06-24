<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.0.0
 */

defined('ABSPATH') || exit;

global $product;

$reg_price = '';
$price = '';

if ($product instanceof WC_Product) {
    $reg_price = $product->get_regular_price();
    $price = $product->get_price();
}

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty"
               name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>" />
    </div>
    <?php
} else {
    /* translators: %s: Quantity. */
    $label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'woocommerce'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'woocommerce');
    ?>
    <div class="quantity">
        <?php do_action('woocommerce_before_quantity_input_field'); ?>

        <button class="quantityDown <?php if ($input_value == 1) { ?>quantity-disabled<?php } ?>" type="button"
                onclick="cChangeValue('<?php echo esc_attr($input_id); ?>',1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="2" viewBox="0 0 14 2" fill="none">
                <path d="M1 1H13" stroke="#A9A9A9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>

        <input type="number" id="input-<?php echo esc_attr($input_id); ?>"
               class="<?php echo esc_attr(join(' ', (array) $classes)); ?>" step="<?php echo esc_attr($step); ?>"
               min="<?php echo esc_attr($min_value); ?>" max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
               name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($input_value); ?>"
               title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>" size="4"
               placeholder="<?php echo esc_attr($placeholder); ?>" inputmode="<?php echo esc_attr($inputmode); ?>"
               autocomplete="<?php echo esc_attr(isset($autocomplete) ? $autocomplete : 'on'); ?>"
               productOldPrice="<?php echo $reg_price; ?>" productPrice="<?php echo $price; ?>" />

<!--        <span class="p2 product-amount" id="--><?php //echo esc_attr($input_id); ?><!--">--><?php //echo esc_attr($input_value); ?><!--</span>-->

        <button class="quantityUp" type="button" onclick="cChangeValue('<?php echo esc_attr($input_id); ?>',0);">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7 1V13M1 7H13" stroke="#A9A9A9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <?php do_action('woocommerce_after_quantity_input_field'); ?>
    </div>

    <?php
}
<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$block_title = $args['block_title'] ?? get_field('block_title');
$products = $args['products'] ?? get_field('products');
?>
<?php if ($products) {?>
<div id="products-block" class="block-margin <?=$classes;?> alignwide">
    <?php if ($block_title) {?>
        <h2 class="block-title"><?= $block_title; ?></h2>
    <?php } ?>

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($products as $item) {
                $post_object = get_post( $item );
                setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
                ?>
                <div class="swiper-slide">
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="swiper-additionals">
        <div class="swiper-pagination"></div>

        <div class="swiper-btns">
            <div class="swiper-btn-prev"><?= inline('assets/images/swiper-btn.svg'); ?></div>

            <div class="swiper-btn-next"><?= inline('assets/images/swiper-btn.svg'); ?></div>
        </div>
    </div>
</div>
<?php } ?>
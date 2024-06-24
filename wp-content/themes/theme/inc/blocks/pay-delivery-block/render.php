<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align = (isset($block['align']) && !empty($block['align'])) ? 'align' . $block['align'] : '';

$block_title = get_field('block_title');
$pay = get_field('pay');
$delivery = get_field('delivery');
?>
<div id="pay-delivery-block" class="block-margin <?= $classes; ?> <?= $align; ?>">
    <?php if ($block_title) { ?>
        <h2 class="block-title"><?= $block_title; ?></h2>
    <?php } ?>

    <div class="block__content">
        <?php if ($pay) {
            $text = $pay['text'];
            $images = $pay['images'];
            ?>
            <div class="content">
                <div class="content__text">
                    <h2 class="content__title">Оплата</h2>

                    <?php if ($text) { ?>
                        <div class="p2"><?= $text; ?></div>
                    <?php } ?>
                </div>

                <?php if ($images) { ?>
                    <div class="content__images">
                        <?php foreach ($images as $item) {
                            $image = wp_get_attachment_image_url($item, 'full');
                            ?>
                            <img src="<?= $image; ?>" alt="" class="style-svg">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($delivery) {
            $text = $delivery['text'];
            $images = $delivery['images'];
            ?>
            <div class="content">
                <div class="content__text">
                    <h2 class="content__title">Доставка</h2>

                    <?php if ($text) { ?>
                        <div class="p2"><?= $text; ?></div>
                    <?php } ?>
                </div>

                <?php if ($images) { ?>
                    <div class="content__images">
                        <?php foreach ($images as $item) {
                            $image = wp_get_attachment_image_url($item, 'full');
                            ?>
                            <img src="<?= $image; ?>" alt="" class="style-svg">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
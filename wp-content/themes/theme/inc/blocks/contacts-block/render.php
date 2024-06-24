<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align = (isset($block['align']) && !empty($block['align'])) ? 'align' . $block['align'] : '';

$block_title = get_field('block_title');
$phones = @settings('phones');
$emails = @settings('emails');
$socials = @settings('socials');
$addresses = get_field('addresses');
?>
<div id="contacts-block" class="<?= $classes; ?> <?= $align; ?>">
    <?php if ($block_title) { ?>
        <h2 class="block-title"><?= $block_title; ?></h2>
    <?php } ?>

    <div class="contacts__top">
        <?php if ($phones) { ?>
            <div class="contact">
                <div class="contact__title">
                    Номер телефона
                </div>

                <div class="contact__wrapper">
                    <?php foreach ($phones as $item) {
                        $value = $item['value'];
                        ?>
                        <a href="tel:<?= $value; ?>" class="item phone">
                            <h5>
                                <?= $value; ?>
                            </h5>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($emails) { ?>
            <div class="contact">
                <div class="contact__title">
                    Номер телефона
                </div>

                <div class="contact__wrapper">
                    <?php foreach ($emails as $item) {
                        $value = $item['value'];
                        ?>
                        <a href="mailto:<?= $value; ?>" class="item email">
                            <h5>
                                <?= $value; ?>
                            </h5>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($socials) { ?>
            <div class="socials">
                <div class="socials__title">Свяжитесь с нами в мессенджерах</div>

                <div class="socials__wrapper">
                    <?php foreach ($socials as $item) {
                        $icon = wp_get_attachment_image_url($item['icon'], 'full');
                        $value = $item['value'];
                        ?>
                        <a href="<?= $value; ?>" target="_blank" class="social">
                            <img src="<?= $icon; ?>" alt="" class="style-svg">
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if ($addresses) { ?>
        <div class="contacts__bottom">
            <?php foreach ($addresses as $item) {
                $title = $item['title'];
                $value = $item['value'];
                $image = wp_get_attachment_image_url($item['image'], 'full');
                ?>
                <div class="address">
                    <?php if ($title || $value) { ?>
                        <div class="address__text">
                            <?php if ($title) { ?>
                                <div class="p3 address__title"><?= $title; ?></div>
                            <?php } ?>

                            <?php if ($value) { ?>
                                <div class="p2 address__value"><?= $value; ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($image) { ?>
                        <img src="<?= $image; ?>" data-fancybox='<?= $image; ?>' data-src='<?= $image; ?>' alt="" class="address__image">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
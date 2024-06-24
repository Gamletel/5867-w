<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme
 */

//$logo = wp_get_attachment_image_url(theme('logo'),'full');
//$phones = @settings('phones');
//$emails = @settings('emails');
//$socials = @settings('socials');
$logo_text = theme('logo_text');
$header_additional = theme('header_additional');
$addresses = theme('addresses');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header id="header" class="site-header">
    <div class="header">
        <div class="header__top">
            <div class="container-wide">
                <div class="header__top-wrapper">
                    <?php if ($logo_text) {
                        $title = $logo_text['title'];
                        $subtitle = $logo_text['subtitle'];
                        ?>
                        <a href="/" class="logo-text">
                            <?php if ($title) { ?>
                                <span class="title"><?= $title; ?></span>
                            <?php } ?>

                            <?php if ($subtitle) { ?>
                                <span class="p3 subtitle"><?= $subtitle; ?></span>
                            <?php } ?>
                        </a>
                    <?php } ?>

                    <?php if ($header_additional) {
                        $text = $header_additional['text'];
                        $subtitle = $header_additional['subtitle'];
                        ?>
                        <div class="header__additional">
                            <?php if ($text) { ?>
                                <h5 class="additional__text"><?= $text; ?></h5>
                            <?php } ?>

                            <?php if ($subtitle) { ?>
                                <div class="additional__subtitle">
                                    <?= $subtitle; ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="header__shop">
                        <a href="<?= wc_get_cart_url(); ?>" class="cart-btn wc-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M3 3H3.26835C3.74213 3 3.97922 3 4.17246 3.08548C4.34283 3.16084 4.48871 3.2823 4.59375 3.43616C4.71289 3.61066 4.75578 3.84366 4.8418 4.30957L7.00004 16L17.4195 16C17.8739 16 18.1016 16 18.2896 15.9198C18.4554 15.8491 18.5989 15.7348 18.7051 15.5891C18.8255 15.424 18.8763 15.2025 18.9785 14.7597L20.5477 7.95972C20.7022 7.29025 20.7796 6.95561 20.6946 6.69263C20.6201 6.46207 20.4639 6.26634 20.256 6.14192C20.0189 6 19.6758 6 18.9887 6H5.5M18 21C17.4477 21 17 20.5523 17 20C17 19.4477 17.4477 19 18 19C18.5523 19 19 19.4477 19 20C19 20.5523 18.5523 21 18 21ZM8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20C9 20.5523 8.55228 21 8 21Z"
                                      stroke="#292929" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>

                            <div id="cart-count" class="number"><?= WC()->cart->get_cart_contents_count(); ?></div>
                        </a>

                        <a href="<?= wc_get_favorites_url(); ?>" class="favorite-btn wc-btn">
                            <?php
                            $favCount = WCFAVORITES()->count_items();
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M19.2373 6.23718C20.7839 7.78383 20.8432 10.2725 19.3718 11.891L11.9997 19.9999L4.62812 11.891C3.1568 10.2725 3.21604 7.78385 4.76268 6.23721C6.4896 4.51029 9.33371 4.66789 10.8594 6.57495L12 8.00003L13.1396 6.5749C14.6653 4.66784 17.5104 4.51027 19.2373 6.23718Z"
                                      stroke="#292929" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>

                            <div class="number"><?= WCFAVORITES()->count_items(); ?></div>
                        </a>

                        <div class="burger open_menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header__bottom">
            <div class="container">
                <div class="header__bottom-wrapper">
                    <?php get_search_form() ?>

                    <?php if ($addresses) { ?>
                        <div class="addresses">
                            <?php foreach ($addresses as $item) {
                                $title = $item['title'];
                                $value = $item['value'];
                                ?>
                                <div class="address">
                                    <?php if ($title) { ?>
                                        <div class="p3 address__title"><?= $title; ?></div>
                                    <?php } ?>

                                    <?php if ($value) { ?>
                                        <div class="p2 address__value"><?= $value; ?></div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-mnu">
        <div id="close-mnu">×</div>

        <?php if ($logo_text) {
            $title = $logo_text['title'];
            $subtitle = $logo_text['subtitle'];
            ?>
            <a href="/" class="logo-text">
                <?php if ($title) { ?>
                    <span class="title"><?= $title; ?></span>
                <?php } ?>

                <?php if ($subtitle) { ?>
                    <span class="p3 subtitle"><?= $subtitle; ?></span>
                <?php } ?>
            </a>
        <?php } ?>

        <?php
        wp_nav_menu([
            'theme_location' => 'mobileMenu',
            'container' => false,
            'menu' => 'Главное',
            'menu_class' => 'menuTop',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 2,
        ]);
        ?>

        <?php if ($addresses) { ?>
            <div class="addresses">
                <?php foreach ($addresses as $item) {
                    $title = $item['title'];
                    $value = $item['value'];
                    ?>
                    <div class="address">
                        <?php if ($title) { ?>
                            <div class="p3 address__title"><?= $title; ?></div>
                        <?php } ?>

                        <?php if ($value) { ?>
                            <div class="p2 address__value"><?= $value; ?></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($phones) { ?>
            <div class="phones__holder">
                <?php foreach ($phones as $item) { ?>
                    <a href="tel:<?= $item['value']; ?>" class="phone__item">
                        <?= file_get_contents(TEMPLATEPATH . '/assets/images/phone.svg'); ?>
                        <?= $item['name']; ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (!empty($emails)): ?>
            <div class="email__holder">
                <?php foreach ($emails as $item) { ?>
                    <a href="mailto:<?= $item['value']; ?>" class="email__item">
                        <?= file_get_contents(TEMPLATEPATH . '/assets/images/mail.svg'); ?>
                        <?php echo $item['name']; ?>
                    </a>
                <?php } ?>
            </div>
        <?php endif ?>
        <?php if (!empty($adresses)): ?>
            <div class="adresses__holder">
                <?php foreach ($adresses as $adress) { ?>
                    <?= $adress['value']; ?>
                <?php } ?>
            </div>
        <?php endif ?>
        <?php if (!empty($socials)): ?>
            <div class="soc__holder">
                <?php foreach ($socials as $item) { ?>
                    <a href="<?= $item['value']; ?>" class="soc__item">
                        <?= get_image($item['icon'], [24, 24]); ?>
                    </a>
                <?php } ?>
            </div>
        <?php endif ?>
    </div>
</header><!-- #masthead -->

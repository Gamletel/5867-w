<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Company
 */

//$logo = wp_get_attachment_image_url(theme('logo'),'full');
$phones = @settings('phones');
$emails = @settings('emails');
$socials = @settings('socials');
//$adress = @settings('adresses');
$footer_text = theme('footer_text');
?>

<footer id="footer" class="site-footer">
    <div class="footer">
        <div class="container">
            <div class="footer__top">
                <?php
                wp_nav_menu([
                    'theme_location' => 'mobileMenu',
                    'container' => false,
                    'menu' => 'Главное-футер',
                    'menu_class' => 'menuFooter',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' => 2,
                ]);
                ?>

                <div class="footer__top-content">
                    <div class="contacts">
                        <?php if ($phones) { ?>
                            <div class="contact phones">
                                <?php foreach ($phones as $item) {
                                    $value = $item['value'];
                                    ?>
                                    <a href="tel:<?= $value; ?>" class="item phone">
                                        <?= $value; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if ($emails) { ?>
                            <div class="contact phones">
                                <?php foreach ($emails as $item) {
                                    $value = $item['value'];
                                    ?>
                                    <a href="mailto:<?= $value; ?>" class="item email">
                                        <?= $value; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if ($socials) { ?>
                            <div class="socials">
                                <?php foreach ($socials as $item) {
                                    $value = $item['value'];
                                    $icon = wp_get_attachment_image_url($item['icon'], 'full');
                                    ?>
                                    <a href="<?= $value; ?>" target="_blank" class="social">
                                        <img src="<?= $icon; ?>" alt="" class="style-svg">
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="btn" data-modal="callback">Задать вопрос</div>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="container">
                <div class="footer__bottom-wrapper">
                    <a href="/privacy-policy" target="_blank" class="policy">
                        Политика конфиденциальности
                    </a>

                    <a href="https://grampus-studio.ru/?utm_source=client&utm_keyword=<?= get_site_url(); ?>;"
                       class="grampus p3">
                        Cайт разработан

                        <?= inline('assets/images/GRAMPUS.svg'); ?>
                    </a>
                    
                    <?php if ($footer_text) {?>
                        <div class="p3 footer-text">
                            <?= $footer_text; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="modal-callback" class="theme-modal">
    <div class="close-modal">×</div>
    <div class="form__holder"></div>
</div>

<div id="modal-success" class="theme-modal">
    <div class="close-modal">×</div>

    <h2 class="block-title">
        Спасибо!
    </h2>

    <h3>
        Ваша заявка отправлена
    </h3>
</div>

<div id="modal-error" class="theme-modal">
    <div class="close-modal">×</div>

    <h2 class="block-title">
        Ошибка!
    </h2>

    <h3>
        Во время отправки произошла ошибка, пожалуйста, попробуйте позже!
    </h3>
</div>

<?php wp_footer(); ?>

</body>
</html>
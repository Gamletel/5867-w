<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align = (isset($block['align']) && !empty($block['align'])) ? 'align' . $block['align'] : '';

$block_title = get_field('block_title');
$advantages = get_field('advantages');
?>
<?php if ($advantages) { ?>
    <div id="advantages-block" class="block-margin <?= $classes; ?> <?= $align; ?>">
        <?php if ($block_title) {?>
            <h2 class="block-title"><?= $block_title; ?></h2>
        <?php } ?>
        
        <div class="advantages">
            <?php foreach ($advantages as $advantage) { 
                $icon = wp_get_attachment_image_url($advantage['icon'], 'full');
                $title = $advantage['title'];
                $text = $advantage['text'];
                ?>
                <div class="advantage">
                    <?php if ($icon) {?>
                        <div class="advantage__icon">
                            <img src="<?= $icon; ?>" alt="" class="style-svg">
                        </div>
                    <?php } ?>

                    <?php if ($title) {?>
                        <h5 class="advantage__title"><?= $title; ?></h5>
                    <?php } ?>
                    
                    <?php if ($text) {?>
                        <div class="p2 advantage__text"><?= $text; ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
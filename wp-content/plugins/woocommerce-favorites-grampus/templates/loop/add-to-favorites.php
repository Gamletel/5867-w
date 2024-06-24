<?php
global $product;

$in_favorites = WCFAVORITES()->check_item($product->get_id());
$text = get_option('favorites_category_product_text','В избранные');
?>
<button type="button" data-product_id="<?=$product->get_id()?>" class="favorites ajax_add_to_favorites <?php if($in_favorites) { echo 'added'; } ?>" aria-label="<?=$text?>"><?php echo $text; ?></button>
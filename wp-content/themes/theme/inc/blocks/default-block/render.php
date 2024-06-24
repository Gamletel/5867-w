<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';



?>
<div id="name-block" class="<?=$classes;?> <?=$align;?>">

</div>
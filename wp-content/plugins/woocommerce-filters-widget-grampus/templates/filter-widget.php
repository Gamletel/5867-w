<form class="filters-form" method="get" data-auto="<?= wc_bool_to_string($instance['auto']) ?>"
	action="<?= esc_url($instance['current_url']) ?>">
	<?php
	if (get_query_var('s')) {
		?>
		<input type="hidden" name="s" value="<?= get_query_var('s') ?>">
		<input type="hidden" name="post_type" value="product">
		<?php
	}
	
	foreach ($this->filters as $attr => $data) {
		if ($attr == 'price') {
			if ($data['price_min'] >= 0 and $data['price_max'] > 0 and ($data['price_min'] != $data['price_max'])) {
				?>
				<div class="filter-block filter-block-price opened">
					<div class="filter-block-header">
						<div class="filter-block-title">
							<?= esc_html($data['name']) ?>
						</div>
					</div>
					<div class="filter-block-content">
						<div class="range-slider" data-filter-node="slider" data-min="<?= $data['price_min'] ?>"
							data-max="<?= $data['price_max'] ?>"></div>
						<div class="inputs price range" data-mode="<?= $data['type'] ?>">
							<?php if ($data['type'] != 'ranges') { ?>
								<div class="group">
									<input type="number" data-label="Мин. цена" data-type="min" data-min="<?= $data['price_min'] ?>"
										data-name="min_price" value="<?= $data['current_min_price'] ?>" <?php if ($data['current_min_price'] != $data['price_min'] and $data['current_min_price'] != '') { ?>name="min_price" <?php } ?>>
								</div>
								<div class="group">
									<input type="number" data-label="Макс. цена" data-type="max" data-max="<?= $data['price_max'] ?>"
										data-name="max_price" value="<?= $data['current_max_price'] ?>" <?php if ($data['current_max_price'] != $data['price_max'] and $data['current_max_price'] != '') { ?>name="max_price" <?php } ?>>
								</div>
							<?php } else { ?>
								<input type="hidden" data-type="min" data-min="<?= $data['price_min'] ?>" data-name="min_price"
									value="<?= $data['current_min_price'] ?>" <?php if ($data['current_min_price'] != $data['price_min'] and $data['current_min_price'] != '') { ?>name="min_price" <?php } ?>>
								<input type="hidden" data-type="max" data-max="<?= $data['price_max'] ?>" data-name="max_price"
									value="<?= $data['current_max_price'] ?>" <?php if ($data['current_max_price'] != $data['price_max'] and $data['current_max_price'] != '') { ?>name="max_price" <?php } ?>>
							<?php } ?>
						</div>
						<?php if ($data['type'] != 'slider') { ?>
							<div class="inputs radios" data-filter-node="ranges">
								<?php
								foreach ($data['ranges'] as $index => $params) {
									$vid = esc_attr("filter_{$attr}_{$index}");
									$checked = ($params['active']) ? ' checked="checked"' : '';
									?>
									<div class="group">
										<input type="radio" id="<?= $vid ?>" data-min="<?= $params['min'] ?>"
											data-max="<?= $params['max'] ?>" <?= $checked ?>>
										<label for="<?= $vid ?>"><?= esc_html($params['name']) ?></label>
									</div>
									<?php
								}
								?>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php
			}
		} else {
			$vc = count($data['values']);
			if ($vc > 0) {
				$has_search = $data['search'] && $vc > 1;
				$search_id = '';
				$search_class = '';
				if ($has_search) {
					$search_id = ' id="fl_' . $attr . '"';
					$search_class = 'filterable';
				}
				$opened = ($data['has_active']) ? ' opened' : '';
				?>
				<div class="filter-block <?= $opened ?>">
					<div class="filter-block-header">
						<div class="filter-block-title">
							<?= esc_html($data['name']) ?>
						</div>
						<div class="filter-block-toggler">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9 5L16 12L9 19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>

						</div>
					</div>
					<div <?= $search_id ?> class="filter-block-content <?= $search_class ?>" <?php if (!$opened) {
							 echo 'style="display:none"';
						 } ?>>
						<?php if ($has_search) { ?>
							<div class="local-search" <?php if (!$opened) {
								echo 'style="display:none"';
							} ?>>
								<input class="search" type="text" autocorrect="off" spellcheck="true"
									placeholder="Поиск по <?= esc_attr($data['name']) ?>">
							</div>
						<?php } ?>
						<div class="inputs checkboxes list">
							<?php
							foreach ($data['values'] as $params) {
								$vid = esc_attr("filter_{$attr}_{$params['value']}");
								$checked = ($params['active']) ? ' checked="checked"' : '';
								$pl = ($params['depth'] > 0) ? ' style="padding-left:' . ($params['depth']) . 'em;"' : '';
								?>
								<div class="group" <?= $pl ?>>
									<input type="checkbox" name="f_<?= $attr ?>[]" id="<?= $vid ?>" value="<?= $params['value'] ?>"
										<?= $checked ?>>
									<label class="group-label" for="<?= $vid ?>"><span class="indicator"></span>
										<?= esc_html($params['name']) ?>
									</label>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
	?>

	<?php if (!$instance['auto']) { ?>
		<div class="buttons">
			<button class="button btn" type="submit" value="filter">Применить фильтры</button>
			<button class="button link" type="reset" value="filter">Очистить фильтр</button>
		</div>
	<?php } ?>

	<div class="pay-and-delivery">
		<div class="bodym">
			Оплата и доставка
		</div>

		<div class="images">
			<?php
			$theme_directory = get_template_directory_uri();
			?>
			<img src="<?= get_template_directory_uri() . '/assets/images/masterCard.png' ?>" alt="">
			<img src="<?= get_template_directory_uri() . '/assets/images/maestro.png' ?>" alt="">
			<img src="<?= get_template_directory_uri() . '/assets/images/visa2.png' ?>" alt="">
			<img src="<?= get_template_directory_uri() . '/assets/images/mir2.png' ?>" alt="">
		</div>

		<?php
		$page_slug = 'oplata-i-dostavka';
		$page = get_page_by_path($page_slug);
		$page_link = get_permalink($page->ID);
		?>

		<a href="<?= $page_link; ?>" class="btn invert">
			Подробнее
		</a>
	</div>

</form>
<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__what-we-do';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('what-we-do_background_color');
$header = get_field('header');
$paragraph = get_field('paragraph');
$objectives = get_field('objective');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="col">
        <h2 class="header"><?= esc_html($header) ?></h2>
      </div>
      <div class="col">
        <div class="content">
          <div class="paragraph">
            <?= $paragraph ?>
          </div>
          <div class="legends-repeater">
            <?php if (have_rows('objective')) : ?>
              <?php while (have_rows('objective')) : the_row(); ?>
                <?php
                $icon = get_sub_field('icon');
                $item_header = get_sub_field('header');
                $rich_text = get_sub_field('rich_text');
                ?>
                <div class="item">
                  <div class="marker">
                    <?php if ($icon) : ?>
                      <img src="<?= esc_url($icon['url']) ?>" alt="<?= esc_attr($icon['alt']) ?>">
                    <?php endif; ?>
                  </div>
                  <div class="header">
                    <h3><?= esc_html($item_header) ?></h3>
                  </div>
                  <div class="description">
                    <?= $rich_text ?>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
     </div>
  </div>
</div>

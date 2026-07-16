<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__cta-group-btn';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('cta-group-btn_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <?php if( have_rows('cta_group_button') ): ?>
      <div class="cta-group-buttons">
        <?php while( have_rows('cta_group_button') ): the_row(); 
          $button_link = get_sub_field('button_link');
        ?>
          <a href="<?= esc_url($button_link['url']) ?>" class="btn btn--transparent" <?php echo $button_link['target'] ? 'target="_blank"' : ''; ?>>
            <?= esc_html($button_link['title']) ?>
          </a>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__shareholders';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('shareholders_background_color');
$header = get_field('header');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="section-header-wrapper">
      <?php if ($header) : ?>
      <h2 class="section-header"><?= $header ?></h2>
      <?php endif; ?>
     </div>
     <div class="shareholders-wrapper body-text">
      <p><?php the_field('placeholder_text'); ?></p>
     </div>
  </div>
</div>

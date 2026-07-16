<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__paragraph ';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('paragraph_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <div class="section">
      <?php if ( get_field('paragraph_header') ) : ?>
        <h2 class="section-header"><?= get_field('paragraph_header') ?></h2>
      <?php endif; ?>
      <?php if ( get_field('paragraph_description') ) : ?>
        <div class="body-text"><?= get_field('paragraph_description') ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>

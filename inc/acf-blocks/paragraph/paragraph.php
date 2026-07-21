<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__paragraph';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$bgColor = get_field('paragraph_background_color');
$header = get_field('paragraph_header');
$description = get_field('paragraph_description');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
      <?php if ($header) : ?>
        <div class="header">
          <h2><?= esc_html($header) ?></h2>
        </div>
      <?php endif; ?>

      <?php if ($description) : ?>
        <div class="description">
          <?= $description; ?>
        </div>
      <?php endif; ?>
  </div>
</div>

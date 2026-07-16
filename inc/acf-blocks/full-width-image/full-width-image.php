<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__full-width-image';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('full-width-image_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <?php 
    $image = get_field('full_width_image');
    if ($image) {
      $image_url = $image['url'];
      $image_alt = $image['alt'];
      echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" />';
    }
    ?>
  </div>
</div>

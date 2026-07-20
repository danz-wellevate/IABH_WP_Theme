<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__home-hero';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('home-hero_background_color');
$bgImgDesktop = get_field('background_image__desktop');
$bgImgMobile = get_field('background_image__mobile');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="inner-container">
      <h1>test</h1>
      <div class="sub-paragraph">
        
      </div>
    </div>
  </div>
</div>

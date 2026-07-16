<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__hero-banner';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('hero-banner_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="hero-banner-bg lazyload" data-bg="<?php the_field('hero_banner_background_image'); ?>">
    
      <div class="hero-overlay">
        <div class="container">
          <h2><?php the_field('hero_banner_title'); ?></h2>
        </div>
      </div>
    
  </div>
</div>

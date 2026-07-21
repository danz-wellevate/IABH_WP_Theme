<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__home-hero';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$header = get_field('header');
$subheader = get_field('subheader');
$bg_image_desktop = get_field('background_image__desktop');
$bg_image_mobile = get_field('background_image__mobile');

// Background images, exposed as CSS custom properties so mobile can fall back to desktop.
$hero_style = '';
if ($bg_image_desktop) {
    $hero_style .= '--bg-image-desktop: url(\'' . esc_url($bg_image_desktop['url']) . '\');';
}
if ($bg_image_mobile) {
    $hero_style .= '--bg-image-mobile: url(\'' . esc_url($bg_image_mobile['url']) . '\');';
}
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?><?php if ($hero_style) : ?> style="<?= esc_attr($hero_style) ?>"<?php endif; ?>>

    <!-- Block Content -->
    <div class="inner-container">
      <?php if ($header) : ?>
        <h1><?= esc_html($header) ?></h1>
      <?php endif; ?>

      <?php if ($subheader) : ?>
        <div class="sub-paragraph body-text">
          <?= $subheader ?>
        </div>
      <?php endif; ?>
    </div>

</div>

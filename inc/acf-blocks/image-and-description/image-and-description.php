<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__image-and-description';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor        = get_field('image-and-description_background_color');
$getPos         = get_field('image_position');
$superheader    = get_field('content_superheader');
$header         = get_field('content_header');
$description    = get_field('content_description');
$cta_link       = get_field('content_cta_link');
$original_image = get_field('original_image');
$hovered_image  = get_field('hovered_image');
$fixed_size     = get_field('fixed_image_size'); 
$keep_row = get_field('keep_row_on_tablet');
// Add modifier class when fixed size is enabled
if ( $fixed_size ) {
    $class_name .= ' has-fixed-image-size';
}

$wrapper_classes = 'two-column__wrapper';
if ($keep_row) {
    $wrapper_classes .= ' keep-row-on-tablet';
}

?>


<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="<?php echo esc_attr($wrapper_classes); ?> image-<?= esc_attr($getPos['value']) ?>">
      <?php if ( ! empty( $superheader ) || ! empty( $header ) || ! empty( $description ) || ! empty( $cta_link ) ) : ?>
      <div class="two-column__text-content">
        <?php if ( ! empty( $superheader ) ) : ?>
          <div class="superheader"><?= esc_html($superheader) ?></div>
        <?php endif; ?>
        <?php if ( ! empty( $header ) ) : ?>
          <h2 class="column-title"><?= $header ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $description ) ) : ?>
          <div class="column-text"><?= wp_kses_post($description) ?></div>
        <?php endif; ?>
        <?php if ( ! empty( $cta_link ) ) : ?>
          <a href="<?= esc_url($cta_link['url']) ?>" class="btn btn--transparent"><?= esc_html($cta_link['title']) ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <?php if ( ! empty( $original_image ) || ! empty( $hovered_image ) ) : ?>
      <div class="two-column__image-content">
        <?php if ( ! empty( $original_image ) ) : ?>
          <img src="<?= esc_url($original_image['url']) ?>" alt="<?= esc_attr($original_image['alt']) ?>" class="original-image" />
        <?php endif; ?>
        <?php if ( ! empty( $hovered_image ) ) : ?>
          <img src="<?= esc_url($hovered_image['url']) ?>" alt="<?= esc_attr($hovered_image['alt']) ?>" class="hovered-image" />
        <?php endif; ?>

        
        <?php if ( ! empty( $hovered_image ) ) : ?>
        <div class="preview">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="31" viewBox="0 0 50 31" fill="none">
            <path d="M25 1C33.8726 1 42.0257 5.73133 48.2148 13.6396L48.8076 14.415C49.0637 14.76 49.0635 15.2497 48.8076 15.5947C42.551 23.958 34.1589 29 25 29C16.1274 29 7.97425 24.2687 1.78516 16.3604L1.19238 15.585C0.936292 15.24 0.93646 14.7503 1.19238 14.4053C7.44904 6.04197 15.8411 1 25 1ZM36.4922 15.752C36.9281 8.76493 31.2008 2.99972 24.252 3.43945C18.6864 3.78958 14.1569 8.191 13.5537 13.7109L13.5078 14.248C13.0719 21.2351 18.7992 27.0003 25.748 26.5605H25.75C31.4831 26.1879 36.1228 21.5112 36.4922 15.7539V15.752ZM24.707 10.3037C27.5171 10.127 29.8439 12.4557 29.6582 15.2949V15.2959C29.5061 17.6519 27.6093 19.5412 25.3057 19.6846H25.3047C22.4939 19.8623 20.1657 17.5342 20.3516 14.6943L20.3525 14.6904C20.4957 12.351 22.3873 10.4562 24.707 10.3037Z"/>
          </svg>
        </div>
        <?php endif; ?>
        
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
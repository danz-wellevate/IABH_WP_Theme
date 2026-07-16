<?php
// --------------------------------------------------
// Gutenberg Block Settings
// --------------------------------------------------
$anchor_id = ! empty( $block['anchor'] )
  ? 'id="' . esc_attr( $block['anchor'] ) . '"'
  : '';

$class_name = 'block--custom-layout__news-events';
if ( ! empty( $block['className'] ) ) {
  $class_name .= ' ' . esc_attr( $block['className'] );
}

// --------------------------------------------------
// ACF Fields (block-level)
// --------------------------------------------------
$section_header  = get_field( 'section_header' );
$bg_color        = get_field( 'news-events_background_color' );
$superheader     = get_field( 'content_superheader' );
$header          = get_field( 'content_header' );
$description     = get_field( 'content_description' );
$cta_link        = get_field( 'cta_link' ); // FIX: was missing
$original_image  = get_field( 'original_image' );
?>

<div
  class="block--custom-layout <?php echo $class_name; ?>"
  <?php echo $anchor_id; ?>
  <?php if ( $bg_color ) : ?>
    style="background-color: <?php echo esc_attr( $bg_color ); ?>;"
  <?php endif; ?>
>
  <div class="container">

    <?php if ( $section_header ) : ?>
      <div class="section-header-wrapper">
        <h2 class="section-header"><?php echo esc_html( $section_header ); ?></h2>
      </div>
    <?php endif; ?>

    <div class="two-column__wrapper">

      <?php if ( $superheader || $header || $description || $cta_link ) : ?>
        <div class="two-column__text-content">

          <?php if ( $superheader ) : ?>
            <div class="superheader">
              <?php echo esc_html( $superheader ); ?>
            </div>
          <?php endif; ?>

          <?php if ( $header ) : ?>
            <h2 class="column-title">
              <?php echo esc_html( $header ); ?>
            </h2>
          <?php endif; ?>

          <?php if ( $description ) : ?>
            <div class="column-text">
              <?php echo wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>

          <?php if ( $cta_link && ! empty( $cta_link['url'] ) ) : ?>
            <a
              href="<?php echo esc_url( $cta_link['url'] ); ?>"
              class="btn btn--transparent"
            >
              <?php echo esc_html( $cta_link['title'] ); ?>
            </a>
          <?php endif; ?>

        </div>
      <?php endif; ?>

      <?php if ( $original_image ) : ?>
        <div class="two-column__image-content">
          <img
            src="<?php echo esc_url( $original_image['url'] ); ?>"
            alt="<?php echo esc_attr( $original_image['alt'] ?: $header ); ?>"
            class="original-image"
            loading="lazy"
          >
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

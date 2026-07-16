<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__newsletter';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor  = get_field('newsletter_background_color');
$getPos   = get_field('image_position');

// New ACF radio: "featured_image_in_tablet_&_mobile"
// Choices: "Default" | "Another Position"
$tablet_mobile_pos = get_field('featured_image_in_tablet_&_mobile');
$is_another_position = ( $tablet_mobile_pos === 'Another Position' );
?>

<div class="block--custom-layout <?= $class_name ?><?= $is_another_position ? ' tablet-mobile-image-top' : '' ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="newsletter-wrapper image-<?= esc_attr($getPos['value']) ?>">

      <div class="col nl-details">
        <div class="content">
          <div class="contact-information">
            <?php if ( get_field('title') ) : ?>
              <h2 class="section-header"><?php echo get_field('title'); ?></h2>
            <?php endif; ?>

            <?php if ( get_field('description') ) : ?>
              <div class="details body-text"><?php echo get_field('description'); ?></div>
            <?php endif; ?>

            <div class="forminator-shortcode">
              <?php
              $shortcode = get_field('shortcode');
              if ( ! empty($shortcode) ) : ?>
                <?php echo do_shortcode( $shortcode ); ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col nl-img">
        <?php
        $featured_image = get_field('featured_image');
        if ( ! empty($featured_image) && is_array($featured_image) ) :
        ?>
          <img
            class="img-item"
            src="<?php echo esc_url( $featured_image['url'] ); ?>"
            alt="<?php echo esc_attr( $featured_image['alt'] ?: get_the_title() ); ?>"
            loading="lazy"
          >
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
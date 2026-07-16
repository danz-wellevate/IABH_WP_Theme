<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__carousel-slider';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('carousel-slider_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
  <!-- Block Content -->
  <div class="section-header-wrapper">
    <h2 class="section-header"><?php the_field('section_header'); ?></h2>
  </div>
  <!-- Swiper Container -->
  <?php if ( have_rows('carousel_slider') ) : ?>
    <div class="swiper swiper-benefits">
      <div class="swiper-wrapper">

        <?php while ( have_rows('carousel_slider') ) : the_row(); 
          $background_color = get_sub_field('background_color');
          $image            = get_sub_field('image');
          $content          = get_sub_field('content');
          $textColor        = get_sub_field('text_content_color');
        ?>
          <div class="swiper-slide" style="background-color: <?php echo esc_attr($background_color); ?>;">
            
            <?php if ( $image ) : ?>
              <div class="slide-image lazyload" data-bg="<?php echo esc_url($image['url']); ?>">
                <div class="slide-overlay"></div>
              </div>
            <?php endif; ?>

            <?php if ( $content ) : ?>
              <div class="slide-content" style="color: <?php echo esc_attr($textColor); ?>">
                <?php echo wp_kses_post($content); ?>
              </div>
            <?php endif; ?>

          </div>
        <?php endwhile; ?>

      </div>

      <!-- Navigation -->
      <div class="swiper-nav">
        <button class="swiper-nav-prev" type="button" aria-label="Previous slide"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="swiper-nav-next" type="button" aria-label="Next slide"><i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>
  <?php endif; ?>





  </div>
</div>

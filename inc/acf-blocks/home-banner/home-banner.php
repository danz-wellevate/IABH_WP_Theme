<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__home-banner';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('home-banner_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-image: url('<?php the_field('home_banner_background_image'); ?>'); background-color: <?= esc_attr($bgColor) ?>;" data-bg="<?php the_field('home_banner_background_image'); ?>">

  <div class="content-wrapper">
    <div class="container">
      <!-- Block Content -->
      <div class="main-content">
        <div class="home-banner-bg lazyload">
          <div class="home-banner-overlay">
            <div class="title-group">
              <h2><?php the_field('home_banner_title'); ?></h2>
              <p><?php the_field('home_banner_subtitle'); ?></p>
            </div>

            <div class="cta-group">
              <?php if( have_rows('home_banner_ctas') ): ?>
                <?php while( have_rows('home_banner_ctas') ): the_row();
                  $cta_style = get_sub_field('cta_style');
                  $cta_link  = get_sub_field('cta_link');
                ?>
                  <?php if ($cta_link): ?>
                    <a href="<?= esc_url($cta_link['url']) ?>"
                      class="btn btn--<?= esc_attr($cta_style) ?>"
                      <?= !empty($cta_link['target']) ? 'target="' . esc_attr($cta_link['target']) . '"' : '' ?>>
                      <?= esc_html($cta_link['title']) ?>
                    </a>
                  <?php endif; ?>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>

             <?php 
              $centered_cta_link = get_field('home_banner_centered_cta');
              if ($centered_cta_link): ?>
            <div class="cta-single">
                <a href="<?= esc_url($centered_cta_link['url']) ?>"
                  class="btn--link"
                  <?= !empty($centered_cta_link['target']) ? 'target="' . esc_attr($centered_cta_link['target']) . '"' : '' ?>>
                  <?= esc_html($centered_cta_link['title']) ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12" fill="none">
                    <path d="M9.26802 11.7456C9.26969 11.744 9.27132 11.7423 9.27298 11.7406L14.3944 6.62595C14.4348 6.58531 14.4707 6.5404 14.5015 6.49204L14.5818 6.34477L14.6153 6.24435V6.1707C14.636 6.05785 14.636 5.94215 14.6153 5.82927V5.682L14.5551 5.56818C14.5206 5.50476 14.4778 5.4462 14.4279 5.39411L9.27298 0.259344C8.93187 -0.0844986 8.37658 -0.0867266 8.03274 0.254386C8.03107 0.256018 8.02944 0.257681 8.02778 0.259344C7.69708 0.605949 7.69708 1.15123 8.02778 1.49786L11.0805 4.5573C11.2099 4.68929 11.2079 4.90124 11.0759 5.03066C11.0144 5.09088 10.9322 5.12514 10.8462 5.12634L0.877903 5.12634C0.393536 5.1263 0.000864029 5.51891 0.000832558 6.00328C0.000801086 6.48765 0.39341 6.88029 0.877777 6.88035L10.8462 6.88035C11.031 6.88296 11.1788 7.0349 11.1762 7.21974C11.175 7.30572 11.1408 7.38797 11.0805 7.44939L8.02778 10.4955C7.69282 10.8429 7.69282 11.3932 8.02778 11.7407C8.36889 12.0845 8.92418 12.0867 9.26802 11.7456Z" fill="white"/>
                  </svg>
                </a>
            </div>
            <?php endif; ?>

            <div class="home-slider-group">
              <div class="home-slider-title body-text">
                <h3><?php the_field('home_banner_slider_title'); ?></h3>
              </div>

              <?php if( have_rows('home_banner_slides') ): ?>
              <div class="swiper home-slider">
                <div class="swiper-wrapper">
                  <?php while( have_rows('home_banner_slides') ): the_row();
                      $slide_image = get_sub_field('slide_image');
                      $slide_title = get_sub_field('slide_title');
                  ?>
                    <div class="swiper-slide home-slider-item">
                      <img class="lazyload"
                          data-src="<?= esc_url( is_array($slide_image) ? $slide_image['url'] : $slide_image ); ?>"
                          alt="<?= esc_attr( $slide_title ); ?>">
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
              <?php endif; ?>

              <div class="home-banner-slider-description small-text">
                <p><?php the_field('home_banner_slider_description'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="shadow-overlay"></div>
</div>

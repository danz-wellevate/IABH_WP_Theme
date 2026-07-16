<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__boxed-key-takeaways';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('boxed-key-takeaways_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">

    <div class="inner-container">
      <!-- Block Content -->
      <?php if( get_field('section_header') ): ?>
      <div class="section-header">
        <h2><?php echo get_field('section_header'); ?></h2>
      </div>
      <?php endif; ?>

      <div class="key-pointer">
        <?php if( have_rows('grid_key_takeaways_repeater') ): ?>
          <?php while( have_rows('grid_key_takeaways_repeater') ): the_row(); 
            // Variables
            $key_icon = get_sub_field('svg_icon');
            $key_icon_bg_color = get_sub_field('svg_icon_background_color');
            $takeaway_header = get_sub_field('takeaway_header');
            $takeaway_text = get_sub_field('takeaway_text');
          ?>
            <div class="key-pointer__item">
              <div class="key-pointer__icon" style="background-color: <?php echo esc_attr($key_icon_bg_color); ?>;">
                <?php echo $key_icon; ?>
              </div>
              <div class="key-pointer__text body-text">
                <?php if ($takeaway_header): ?>
                  <h3><?php echo $takeaway_header; ?></h3>
                <?php endif; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="partners__list">
      <?php
      $partners = get_field('grid_partners_logo_repeater');
      if ( $partners ) :
        foreach ( $partners as $partner ) :
          $svg_logo = $partner['partner_logo'];
          $svg_title = $partner['title'];
          ?>
          <div class="partner__item">
            <div class="partner__logo">
              <img src="<?= esc_url($svg_logo['url']) ?>" alt="<?= esc_attr($svg_logo['alt']) ?>">
            </div>
            <div class="partner__title body-title">
              <?php echo $svg_title; ?>
            </div>
            <div class="partner__description body-text">
              <div class="partner__title body-title">
                <?php echo $svg_title; ?>
              </div>
              <?php echo $partner['description']; ?>
            </div>
            <div class="partner__button">
              <button class="reveal-text">
                <div class="icon plus">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M4.875 13.0127V8.17578H0V4.83691H4.875V0H8.125V4.83691H13.0127V8.17578H8.125V13.0127H4.875Z" fill="white"/>
                  </svg>
                </div>
                <div class="icon minus">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="4" viewBox="0 0 14 4" fill="none">
                    <path d="M0 3.33887V0H13.0127V3.33887H0Z" fill="white"/>
                  </svg>
                </div>
              </button>

            </div>
          </div>
          <?php
        endforeach;
      endif;
      ?>
    </div>

  </div>
</div>

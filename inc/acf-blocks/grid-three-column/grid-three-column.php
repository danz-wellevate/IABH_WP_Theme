<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__grid-three-column';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('grid-three-column_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <div class="section-header">
      <?php if ( get_field('grid_takeaways_header') ) : ?>
        <h2 class="section-header"><?= get_field('grid_takeaways_header') ?></h2>
      <?php endif; ?>
      <?php if ( get_field('grid_takeaways_subheader') ) : ?>
        <p class="body-text"><?= get_field('grid_takeaways_subheader') ?></p>
      <?php endif; ?>
    </div>
    <div class="key-pointer">
      <?php if ( have_rows( 'grid_key_takeaways_repeater' ) ) : ?>
        <?php while ( have_rows( 'grid_key_takeaways_repeater' ) ) : the_row();

          $key_icon        = get_sub_field( 'svg_icon' );
          $icon_bg_color   = get_sub_field( 'svg_icon_background_color' );
          $header          = get_sub_field( 'takeaway_header' );
          $text            = get_sub_field( 'takeaway_text' );
        ?>
          <div class="key-pointer__item">

            <?php if ( $key_icon ) : ?>
              <div
                class="key-pointer__icon"
                style="background-color: <?php echo esc_attr( $icon_bg_color ); ?>;"
              >
                <?php echo $key_icon; ?>
              </div>
            <?php endif; ?>

            <div class="key-pointer__text body-text">
              <?php if ( $header ) : ?>
                <h3><?php echo esc_html( $header ); ?></h3>
              <?php endif; ?>
                  
              <?php if ( $text ) : ?>
                <?php echo wp_kses_post( $text ); ?>
              <?php endif; ?>
              
            </div>

          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

      <?php if ( get_field('grid_takeaways_information') ) : ?>
        <div class="information-card">
          <?= get_field('grid_takeaways_information-icon') ?>
          <p class="body-text"><?= get_field('grid_takeaways_information') ?></p>
        </div>
      <?php endif; ?>
  </div>
</div>

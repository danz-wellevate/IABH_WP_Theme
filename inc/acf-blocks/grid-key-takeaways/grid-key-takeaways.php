<?php
// Gutenberg Block Settings
$anchor_id = ! empty( $block['anchor'] )
  ? 'id="' . esc_attr( $block['anchor'] ) . '"'
  : '';

// Create class attribute allowing for custom className values
$class_name = 'block--custom-layout__grid-key-takeaways';
if ( ! empty( $block['className'] ) ) {
  $class_name .= ' ' . esc_attr( $block['className'] );
}

// ACF Fields
$bg_color = get_field( 'grid-key-takeaways_background_color' ) ?: '#FFFFFF';
?>

<div
  class="block--custom-layout <?php echo esc_attr( $class_name ); ?>"
  <?php echo $anchor_id; ?>
  style="background-color: <?php echo esc_attr( $bg_color ); ?>;"
>
  <div class="container">

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

            <div class="key-pointer__text">
              <?php if ( $header ) : ?>
                <h2 class="section-header"><?=  $header ?></h2>
              <?php endif; ?>
              <div class="body-text">
                <?php echo wp_kses_post( $text ); ?>
              </div>
            </div>

          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

  </div>
</div>

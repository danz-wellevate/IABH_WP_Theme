<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__carded-information';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('carded-information_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <div class="section-header">
      <?php if ( get_field('carded-information_header') ) : ?>
        <h2 class="section-header"><?= esc_html( get_field('carded-information_header') ) ?></h2>
      <?php endif; ?>
      <?php if ( get_field('carded-information_subheader') ) : ?>
        <p class="body-text"><?= esc_html( get_field('carded-information_subheader') ) ?></p>
      <?php endif; ?>
    </div>

    <div class="carded-information__cards">
      <?php if ( have_rows( 'carded_information_repeater' ) ) : ?>
        <?php while ( have_rows( 'carded_information_repeater' ) ) : the_row();
          $image  = get_sub_field( 'card_image' );
          $title  = get_sub_field( 'card_title' );
          $header = get_sub_field( 'card_header' );
          $text   = get_sub_field( 'card_text' );
          $button = get_sub_field( 'card_button' );
        ?>
          <div class="carded-information__card">

            <div class="carded-information__card-header">
              <?php if ( $image ) : ?>
                <div class="carded-information__card-image">
                  <img
                    src="<?= esc_url( $image['url'] ) ?>"
                    alt="<?= esc_attr( $image['alt'] ) ?>"
                    width="<?= esc_attr( $image['width'] ) ?>"
                    height="<?= esc_attr( $image['height'] ) ?>"
                  />
                </div>
              <?php endif; ?>
              <?php if ( $title ) : ?>
                <div class="carded-information__card-title-wrapper">
                  <p class="carded-information__card-title inner-title"><?= esc_html( $title ) ?></p>
                </div>
              <?php endif; ?>
            </div>
          
            <div class="carded-information__card-body">
              <?php if ( $header ) : ?>
                <h3 class="carded-information__card-header inner-title"><?= esc_html( $header ) ?></h3>
              <?php endif; ?>

              <?php if ( $text ) : ?>
                <div class="carded-information__card-text body-text"><?=  $text; ?></div>
              <?php endif; ?>

              <?php if ( $button ) : ?>
                <a
                  class="carded-information__card-button btn btn--transparent"
                  href="<?= esc_url( $button['url'] ) ?>"
                  target="<?= esc_attr( $button['target'] ) ?>"
                >
                  <?= esc_html( $button['title'] ) ?>
                </a>
              <?php endif; ?>
            </div>

          </div>

        <?php endwhile; ?>
      <?php endif; ?>
    </div>

  </div>
</div>
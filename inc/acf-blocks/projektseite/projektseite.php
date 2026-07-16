<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

$class_name = 'block--custom-layout__projektseite';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$bgColor = get_field('projektseite_background_color');
$cards   = get_field('projektseite_card_repeater');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">

    <div class="section-header">
      <?php if ( get_field('projektseite_header') ) : ?>
        <h2 class="section-header"><?= get_field('projektseite_header') ?></h2>
      <?php endif; ?>
      <?php if ( get_field('projektseite_subheader') ) : ?>
        <p class="body-text"><?= get_field('projektseite_subheader') ?></p>
      <?php endif; ?>
    </div>

    <?php if ( $cards ) : ?>
      <div class="projektseite__cards">
        <?php foreach ( $cards as $card ) :
          $image    = $card['image'];
          $title    = $card['title'];
          $subtitle = $card['subtitle'];
          $button   = $card['button'];
        ?>
          <div class="projektseite__card">

            <?php if ( $image ) : ?>
              <div class="projektseite__card-image">
                <img
                  src="<?= esc_url( $image['url'] ) ?>"
                  alt="<?= esc_attr( $image['alt'] ) ?>"
                  width="<?= esc_attr( $image['width'] ) ?>"
                  height="<?= esc_attr( $image['height'] ) ?>"
                  loading="lazy"
                />
              </div>
            <?php endif; ?>

            <div class="projektseite__card-body">
              <div>
                <?php if ( $title ) : ?>
                  <h3 class="projektseite__card-title inner-title"><?= esc_html( $title ) ?></h3>
                <?php endif; ?>

                <?php if ( $subtitle ) : ?>
                  <p class="projektseite__card-subtitle body-text"><?= esc_html( $subtitle ) ?></p>
                <?php endif; ?>
              </div>

              <?php if ( $button ) : ?>
                <a
                  class="projektseite__card-btn"
                  href="<?= esc_url( $button['url'] ) ?>"
                  target="<?= esc_attr( $button['target'] ?: '_self' ) ?>"
                >
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <rect width="32" height="32" rx="16" fill="white"/>
                  <path d="M17.531 20.788C17.5324 20.7866 17.5337 20.7852 17.5351 20.7839L21.8029 16.5216C21.8366 16.4878 21.8665 16.4503 21.8922 16.41L21.9591 16.2873L21.987 16.2036V16.1423C22.0043 16.0482 22.0043 15.9518 21.987 15.8577V15.735L21.9368 15.6402C21.9081 15.5873 21.8725 15.5385 21.8308 15.4951L17.5351 11.2161C17.2508 10.9296 16.7881 10.9277 16.5016 11.212C16.5002 11.2133 16.4988 11.2147 16.4974 11.2161C16.2219 11.505 16.2219 11.9594 16.4974 12.2482L19.0414 14.7978C19.1492 14.9077 19.1475 15.0844 19.0375 15.1922C18.9863 15.2424 18.9178 15.271 18.8461 15.2719L10.5392 15.2719C10.1356 15.2719 9.80834 15.5991 9.80831 16.0027C9.80829 16.4064 10.1355 16.7336 10.5391 16.7336L18.8461 16.7336C19.0002 16.7358 19.1233 16.8624 19.1211 17.0164C19.1201 17.0881 19.0916 17.1566 19.0414 17.2078L16.4974 19.7462C16.2183 20.0358 16.2183 20.4943 16.4974 20.7839C16.7817 21.0704 17.2444 21.0723 17.531 20.788Z" fill="#EB574F"/>
                </svg>
                </a>
              <?php endif; ?>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>
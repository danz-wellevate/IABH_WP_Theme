<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$bgColor = get_field('kontakt-overview_background_color');

// Create class attribute
$class_name = 'block--custom-layout__kontakt-overview';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$repeaters = ['overview_repeater', 'overview_repeater_second_row'];
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <div class="section-header">
      <?php if( get_field('overview_superheader') ): ?>
        <div class="superheader"><?= esc_html(get_field('overview_superheader')); ?></div>
      <?php endif; ?>
      <?php if( get_field('overview_header') ): ?>
        <h2><?= esc_html(get_field('overview_header')); ?></h2>
      <?php endif; ?>
      <?php if( get_field('overview_description') ): ?>
        <div class="overview-description"><?= esc_html(get_field('overview_description')); ?></div>
      <?php endif; ?>
      <?php if( get_field('overview_subheader') ): ?>
        <div class="subheader"><?= esc_html(get_field('overview_subheader')); ?></div>
      <?php endif; ?>
    </div>
    
    <?php foreach( $repeaters as $repeater_name ): ?>
      <?php if( have_rows($repeater_name) ): ?>
        <div class="overview-repeater <?= $repeater_name == 'overview_repeater_second_row' ? 'overview-repeater-second-row' : '' ?>">
          <?php while( have_rows($repeater_name) ): the_row(); 
            $card_bgColor = get_sub_field('overview_background_color') ?: '#ffffff';
            $icon_bgColor = get_sub_field('image_background_color') ?: '#00A4C3';
            
            // FIXED: Using the correct field name from image_9ade1e.png
            $icon = get_sub_field('icon_image'); 
            $title = get_sub_field('overview_title');
          ?>
            <div class="overview-item" style="background-color: <?= esc_attr($card_bgColor) ?>;">
              <?php if( $icon ): ?>
                <div class="overview-icon" style="background-color: <?= esc_attr($icon_bgColor) ?>;">
                  <?php 
                  // FIXED: Accessing the 'url' from the Image Array returned by ACF
                  ?>
                  <img src="<?= esc_url($icon['url']); ?>" alt="<?= esc_attr($icon['alt'] ?: 'Icon'); ?>" />
                </div>
              <?php endif; ?>
              <?php if( $title ): ?>
                <h3 class="overview-title body-text"><?= $title ?></h3>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <div class="inquiry__cta">
      <button type="button" class="btn btn--transparent" id="cf-popup-trigger">
        Nachricht senden
      </button>
    </div>
  </div>
</div>

<div class="cf-popup" aria-hidden="true">
  <div class="cf-popup__overlay"></div>
  <div class="cf-popup__content">
      <div class="header-section">
        <?php $form_header = get_field( 'form_header' ); ?>
        <?php if ( $form_header ) : ?>
          <h2><?= esc_html( $form_header ); ?></h2>
        <?php endif; ?>
        <div class="logo">
          <img src="/wp-content/uploads/2026/01/wno-official-color-pallette.webp" alt="WNO Logo" />
        </div>
      </div>

      <?php $form_subheader = get_field( 'form_subheader' ); ?>
      <?php if ( $form_subheader ) : ?>
        <div class="subheader body-text">
          <p><?= esc_html( $form_subheader ); ?></p>
        </div>
      <?php endif; ?>

      <?php
        $form_shortcode = get_field( 'form_shortcode' );
        if ( $form_shortcode ) {
          echo do_shortcode( $form_shortcode );
        }
      ?>

    <button type="button" class="cf-popup__close" aria-label="Close modal">
      Zurück zur Seite
    </button>
  </div>
</div>
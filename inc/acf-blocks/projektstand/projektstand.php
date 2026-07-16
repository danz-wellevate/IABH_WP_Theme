<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__projektstand';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('projektstand_background_color');
$cta_link       = get_field('projektstand_cta_link');
$image       = get_field('projektstand_qr_code_image');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <div class="section">
      <?php if ( get_field('projektstand_header') ) : ?>
        <h2 class="section-header"><?= get_field('projektstand_header') ?></h2>
      <?php endif; ?>
      <?php if ( get_field('projektstand_description') ) : ?>
        <div class="body-text"><?= get_field('projektstand_description') ?></div>
      <?php endif; ?>
    </div>

    <div class="qr-code-container">
      <div class="qr-code-content">
        <?php if ( get_field('projektstand_title') ) : ?>
        <div class="inner-title"><?= get_field('projektstand_title') ?></div>
        <?php endif; ?>

        <?php if ( ! empty( $cta_link ) ) : ?>
          <a href="<?= esc_url($cta_link['url']) ?>" target="_blank" class="btn btn--transparent"><?= esc_html($cta_link['title']) ?></a>
        <?php endif; ?>
        
        <div class="separator">
            <svg xmlns="http://www.w3.org/2000/svg" width="96" height="2" viewBox="0 0 96 2" fill="none">
            <path d="M1 1H95" stroke="#A9AAAC" stroke-width="2" stroke-linecap="round" stroke-dasharray="10 10"/>
          </svg>
            <span class="body-text">oder</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="96" height="2" viewBox="0 0 96 2" fill="none">
              <path d="M1 1H95" stroke="#A9AAAC" stroke-width="2" stroke-linecap="round" stroke-dasharray="10 10"/>
            </svg>
        </div>

        <?php if ( get_field('projektstand_titlelower') ) : ?>
          <div class="inner-title"><?= get_field('projektstand_titlelower') ?></div>
        <?php endif; ?>
      </div>
      
        <div class="qr-code-image">
          <?php if ( get_field('projektstand_qr_code_image') ) : ?>
            <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>">
          <?php endif; ?>
        </div>
    
    </div>
  </div>
</div>

<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';
$description = get_field('pb_description');
$buttonOne = get_field('pb_button_one');
$buttonTwo = get_field('pb_button_two');
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__paragraph-button';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('paragraph-button_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container paragraph-button">
    <!-- Block Content -->
     <div class="inner-title"> 
        <?= $description ?>
     </div>

      <div class="paragraph-button__buttons">
          <?php if ($buttonOne): ?>
            <a href="<?= esc_url($buttonOne['url']) ?>" class="btn btn--solid" target="<?= esc_attr($buttonOne['target'] ?: '_self') ?>">
              <?= esc_html($buttonOne['title']) ?>
            </a>
          <?php endif; ?>
  
          <?php if ($buttonTwo): ?>
            <a href="<?= esc_url($buttonTwo['url']) ?>" class="btn btn--transparent" target="<?= esc_attr($buttonTwo['target'] ?: '_self') ?>">
              <?= esc_html($buttonTwo['title']) ?>
            </a>
          <?php endif; ?>
  </div>
  </div>
</div>

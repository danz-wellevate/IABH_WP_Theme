<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$section_bgColor = get_field('overview_background_color');
$fixed_height = get_field('overview_fixed_height'); // ACF true/false

// Create class attribute
$class_name = 'block--custom-layout__overview';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// Logic to render repeater rows
$repeaters = ['overview_repeater', 'overview_repeater_second_row'];
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($section_bgColor) ?>;">
  <div class="container">
    <div class="section-header">
      <?php if( get_field('overview_superheader') ): ?>
        <div class="superheader"><?= esc_html(get_field('overview_superheader')); ?></div>
      <?php endif; ?>
      <?php if( get_field('overview_header') ): ?>
        <h2><?= esc_html(get_field('overview_header')); ?></h2>
      <?php endif; ?>
      <?php if( get_field('header_title_homepage') ): ?>
        <h3 class="home-header"><?= esc_html(get_field('header_title_homepage')); ?></h3>
      <?php endif; ?>
      <?php if( get_field('overview_description') ): ?>
        <div class="overview-description"><?= esc_html(get_field('overview_description')); ?></div>
      <?php endif; ?>
      <?php if( get_field('overview_subheader') ): ?>
        <div class="subheader"><?= esc_html(get_field('overview_subheader')); ?></div>
      <?php endif; ?>
    </div>

    <div class="overview-repeaters-wrapper">
    <?php foreach( $repeaters as $repeater_name ): ?>
      <?php if( have_rows($repeater_name) ): ?>
        <div class="overview-repeater <?= $repeater_name == 'overview_repeater_second_row' ? 'overview-repeater-second-row' : '' ?> <?= $fixed_height ? 'overview-repeater--fixed-height' : 'overview-repeater--auto-height' ?>">
    <?php while( have_rows($repeater_name) ): the_row(); 
    $card_bgColor = get_sub_field('overview_background_color') ?: '#ffffff';
    $icon_bgColor = get_sub_field('image_background_color') ?: '#00A4C3';
    $title        = get_sub_field('overview_title');
    $description  = get_sub_field('overview_description');

    // overview_icon is a Text Area — could be an SVG string or a URL
    $icon_raw = get_sub_field('overview_icon');

    // Also check icon_image (the Image field)
    $icon_image = get_sub_field('icon_image'); // returns array with 'url' key
    $icon_image_url = is_array($icon_image) ? $icon_image['url'] : $icon_image;

    // Determine what type the text area value is
    $is_svg = $icon_raw && str_starts_with(trim($icon_raw), '<svg');
    $is_url = $icon_raw && !$is_svg && filter_var($icon_raw, FILTER_VALIDATE_URL);
?>
    <div class="overview-item <?= ($title && !$description) ? 'overview-item--title-only' : '' ?>" style="background-color: <?= esc_attr($card_bgColor) ?>;">

        <?php if( $icon_raw || $icon_image_url ): ?>
            <div class="overview-icon" style="background-color: <?= esc_attr($icon_bgColor) ?>;">
                <?php if( $is_svg ): ?>
                    <?= $icon_raw /* Raw SVG markup — safe if editors control input */ ?>
                <?php elseif( $is_url ): ?>
                    <img src="<?= esc_url($icon_raw) ?>" alt="<?= esc_attr($title) ?>">
                <?php elseif( $icon_image_url ): ?>
                    <img src="<?= esc_url($icon_image_url) ?>" alt="<?= esc_attr($title) ?>">
                <?php else: ?>
                    <?= esc_html($icon_raw) /* Fallback: icon class name or plain text */ ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if( $title ): ?>
            <h3 class="overview-title body-text"><?= $title; ?></h3>
        <?php endif; ?>

        <?php if( $description ): ?>
            <p class="overview-description body-text"><?= esc_html($description) ?></p>
        <?php endif; ?>

    </div>

          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
    </div>

    <?php 
      $cta = get_field('overview_cta');
      if( $cta ): 
        $cta_url = $cta['url'];
        $cta_title = $cta['title'];
        $cta_target = $cta['target'] ?: '_self';
      ?>
      <div class="overview-cta-wrapper">
        <div class="overview-cta">
          <a class="btn btn--transparent" href="<?= esc_url($cta_url); ?>" target="<?= esc_attr($cta_target); ?>">
            <?= esc_html($cta_title); ?>
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
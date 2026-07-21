<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__about-section';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('about-section_background_color');
$header = get_field('header');
$paragraph = get_field('paragraph');
$image = get_field('image');
$objectives = get_field('objectives');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="col">
        <div class="header">
          <h2><?= esc_html($header) ?></h2>
        </div>
      </div>
      <div class="col">
        <div class="content">
          <div class="paragraph">
            <?= $paragraph ?>
          </div>
          <div class="illustration">
            <?php if ($image) : ?>
              <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>">
            <?php endif; ?>
          </div>
          <div class="legends-repeater">
            <?php if (have_rows('objectives')) : ?>
              <?php while (have_rows('objectives')) : the_row(); ?>
                <?php
                $marker = get_sub_field('marker');
                $description = get_sub_field('description');
                ?>
                <div class="item">
                  <div class="marker">
                    <?php if ($marker) : ?>
                      <img src="<?= esc_url($marker['url']) ?>" alt="<?= esc_attr($marker['alt']) ?>">
                    <?php endif; ?>
                  </div>
                  <div class="description">
                    <?= esc_html($description) ?>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
     </div>
  </div>
</div>

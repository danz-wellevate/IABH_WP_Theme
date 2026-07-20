<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__partnerships';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('partnerships_background_color');
$header = get_field('header');
$first_column_title = get_field('first_column_title');
$secondary_column_title = get_field('secondary_column_title');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="inner-container">
      <!-- Section header -->
      <h2><?= esc_html($header) ?></h2>
    </div>

     <div class="inner-container">
      <div class="col">
        <div class="header">
          <h3><?= esc_html($first_column_title) ?></h3>
        </div>
        <div class="partner-wrapper">
          <?php if (have_rows('first_column_partnership')) : ?>
            <?php while (have_rows('first_column_partnership')) : the_row(); ?>
              <?php
              $brand_title = get_sub_field('brand_title');
              $brand_logo = get_sub_field('brand_logo');
              ?>
              <div class="box-item">
                <div class="title">
                  <?= esc_html($brand_title) ?>
                </div>
                <div class="image">
                  <?php if ($brand_logo) : ?>
                    <img src="<?= esc_url($brand_logo['url']) ?>" alt="<?= esc_attr($brand_logo['alt']) ?>">
                  <?php endif; ?>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col">
        <div class="header">
          <h3><?= esc_html($secondary_column_title) ?></h3>
        </div>
        <div class="partner-wrapper">
          <?php if (have_rows('secondary_column_partnership')) : ?>
            <?php while (have_rows('secondary_column_partnership')) : the_row(); ?>
              <?php
              $brand_title = get_sub_field('brand_title');
              $brand_logo = get_sub_field('brand_logo');
              ?>
              <div class="box-item">
                <div class="title">
                  <?= esc_html($brand_title) ?>
                </div>
                <div class="image">
                  <?php if ($brand_logo) : ?>
                    <img src="<?= esc_url($brand_logo['url']) ?>" alt="<?= esc_attr($brand_logo['alt']) ?>">
                  <?php endif; ?>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
     </div>
  </div>
</div>

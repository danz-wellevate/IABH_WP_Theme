<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__map-address';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('map-address_background_color');


$embeddedMap = get_field('embedded_map');
$header = get_field('header');
$subheader = get_field('subheader');



?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="map-address-wrapper">
      <div class="col map-area">
        <?php if ($embeddedMap) : ?>
          <?= $embeddedMap ?>
        <?php endif; ?>
      </div>
      <div class="col contact-details">
        <div class="content">

          <?php if ($header) :?>
            <h2 class="section-header"><?= $header ?></h2>
          <?php endif; ?>

          <?php if ($subheader) : ?>
            <h3><?= $subheader ?></h3>
          <?php endif; ?>
          

          <?php if ( have_rows('contact_details') ) : ?>
            <?php while ( have_rows('contact_details') ) : the_row(); ?>
              <div class="contact-information">
                <?php if ( get_sub_field('title') ) : ?>
                  <p class="title body-text"><?php echo  get_sub_field('title') ?></p>
                <?php endif; ?>

                <?php if ( get_sub_field('description') ) : ?>
                  <div class="details body-text"><?php echo get_sub_field('description') ?></div>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>

        </div>
      </div>
     </div>
  </div>
</div>

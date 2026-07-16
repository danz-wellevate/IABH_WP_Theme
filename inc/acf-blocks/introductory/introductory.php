<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__introductory';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('introductory_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <?php
    $introductory_title = get_field('introductory_title');
    $introductory_image = get_field('introductory_image');
    $introductory_content = get_field('introductory_content'); 
    ?>


    <?php if ( $introductory_image ) : ?>
      <div class="introductory-image">
        <img 
          class="img-item"
          src="<?php echo esc_url( $introductory_image['url'] ); ?>"
          alt="<?php echo esc_attr( $introductory_image['alt'] ); ?>"
        />
      </div>
    <?php endif; ?>

    <?php if ( $introductory_title ) : ?>
      <h2 class="section-header"><?php echo esc_html( $introductory_title ); ?></h2>
    <?php endif; ?>
    
    <?php if ( $introductory_content ) : ?>
      <div class="rich-text-content body-text">
        <?php echo wp_kses_post( $introductory_content ); ?>
      </div>
    <?php endif; ?>

      <?php
      $intro_button = get_field('introductory_button');

      if ( $intro_button ) :
      ?>
        <a href="<?php echo esc_url( $intro_button['url'] ); ?>"
          target="<?php echo esc_attr( $intro_button['target'] ?: '_self' ); ?>"
          class="btn btn--transparent">
          <?php echo esc_html( $intro_button['title'] ); ?>
        </a>
      <?php endif; ?>
  </div>
</div>

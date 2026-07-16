<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__news-cta';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('news-cta_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="section-header-wrapper">
      <h2 class="section-header"><?php the_field('fw_title'); ?></h2>
     </div>
     <div class="cta-wrapper">
        <?php
        $fw_cta_link = get_field('fw_cta_link');
        if ( $fw_cta_link ) :
            $url    = esc_url( $fw_cta_link['url'] );
            $title  = esc_html( $fw_cta_link['title'] );
            $target = esc_attr( $fw_cta_link['target'] ?: '_self' );
        ?>
            <a href="<?php echo $url; ?>" 
              target="<?php echo $target; ?>" 
              class="btn btn--transparent">
                <?php echo $title; ?>
            </a>
        <?php endif; ?>
     </div>
  </div>
</div>

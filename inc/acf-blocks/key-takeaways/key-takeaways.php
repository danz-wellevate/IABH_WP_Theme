<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__key-takeaways';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('key-takeaways_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="key-pointer">
      <?php if( have_rows('key_takeaways_repeater') ): ?>
        <?php while( have_rows('key_takeaways_repeater') ): the_row(); 
          // Variables
          $key_icon = get_sub_field('svg_icon');
          $key_icon_bg_color = get_sub_field('svg_icon_background_color');
          $takeaway_header = get_sub_field('takeaway_header');
          $takeaway_text = get_sub_field('takeaway_text');
        ?>
          <div class="key-pointer__item">
            <div class="key-pointer__icon" style="background-color: <?php echo esc_attr($key_icon_bg_color); ?>;">
              <?php echo $key_icon; ?>
            </div>
            <div class="key-pointer__text body-text">
              <?php if ($takeaway_header): ?>
                <h3><?php echo $takeaway_header; ?></h3>
              <?php endif; ?>
              <?php if ($takeaway_text): ?>
                <?php echo $takeaway_text; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
     </div>

    
    <?php
    $cta_link = get_field('key_takeaways_cta_link');
    if ($cta_link) {
      $link_url = $cta_link['url'];
      $link_text = $cta_link['title'];
      $link_target = $cta_link['target'] ?: '_self';
      ?>
      <div class="key-takeaways__cta">
        <a href="<?php echo esc_url($link_url); ?>" class="btn btn--transparent" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_text); ?></a>
      </div>
      <?php
    }
    ?>
    

  </div>
</div>

<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__infographic';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('infograhic_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="fullwidth-content-wrapper">
      <div class="infographic-img">
<?php
$image_url = get_field('ig_background_image');

if ($image_url):
  $image_id = attachment_url_to_postid($image_url);
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
?>
  <img 
    src="<?php echo esc_url($image_url); ?>" 
    alt="<?php echo esc_attr($alt); ?>">
<?php endif; ?>
      </div>
      <div class="content">
        <h2 class="title"><?php the_field('ig_title'); ?></h2>
        <div class="description body-text"><?php the_field('ig_textarea'); ?></div>
        <?php
        $fw_cta_link = get_field('ig_cta_link');
        if ( $fw_cta_link ) :
            $url    = esc_url( $fw_cta_link['url'] );
            $title  = esc_html( $fw_cta_link['title'] );
            $target = esc_attr( $fw_cta_link['target'] ?: '_self' );
        ?>
            <a href="<?php echo $url; ?>" 
              target="<?php echo $target; ?>" 
              class="btn btn--solid">
                <?php echo $title; ?>
            </a>
        <?php endif; ?>
      </div>
     </div>
  </div>
</div>

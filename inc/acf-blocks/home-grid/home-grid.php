<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__home-grid';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('home-grid_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->

    <div class="home-grid-wrapper">
      <?php if ( have_rows('home_grid_repeater') ) : ?>
        <?php while ( have_rows('home_grid_repeater') ) : the_row();

          $bgImg     = get_sub_field('home_grid_background_image');
          $bgColor   = get_sub_field('home_grid_background_color');
          $title     = get_sub_field('home_grid_title');
          $subtitle  = get_sub_field('home_grid_subtitle');
          $link      = get_sub_field('home_grid_permalink');

          $bg_url = is_array($bgImg) ? $bgImg['url'] : '';
        ?>
          <div class="grid-item">

            <?php if ( $bg_url ) : ?>
              <div class="grid-bg lazyload" data-bg="<?php echo esc_url($bg_url); ?>">
                <div class="grid-overlay"></div>
              </div>
            <?php endif; ?>

            <div class="grid-title" style="background-color: <?= esc_attr($bgColor); ?>;">
              <?php if ( $title ) : ?>
                <div class="title"><?php echo esc_html($title); ?></div>
              <?php endif; ?>

              <div class="subtitle-wrap">
                <?php if ( $subtitle ) : ?>
                  <div class="subtitle body-text"><?php echo esc_html($subtitle); ?></div>
                <?php endif; ?>

                <?php if ( $link ) :
                  $link_url    = esc_url( $link['url'] );
                  $link_title  = esc_html( $link['title'] );
                  $link_target = esc_attr( $link['target'] ?: '_self' );
                ?>
                  <a href="<?php echo $link_url; ?>"
                    target="<?php echo $link_target; ?>"
                    class="btn btn--rounded">
                    <i class="fa-solid fa-arrow-right" style="color: <?= esc_attr($bgColor); ?>"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>

          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

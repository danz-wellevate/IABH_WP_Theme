<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__news-three-column';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('news-three-column_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <?php 
    $header = get_field('header');
    if ( ! empty($header) ) : ?>
      <div class="section-header-wrapper">
        <h2 class="section-header"><?php echo esc_html( $header ); ?></h2>
      </div>
    <?php endif; ?>

    <?php if ( have_rows('announcements') ) : ?>
    <div class="news-three-column-wrapper">
      <?php while ( have_rows('announcements') ) : the_row(); 
      
        $date             = get_sub_field('date');
        $title            = get_sub_field('title');
        $description      = get_sub_field('description');
        $linkToMedia      = get_sub_field('link_to_media');
        $bg_color         = get_sub_field('background_color') ?: '#EDEDEE';
        $font_arrow_color = get_sub_field('arrow_color') ?: '#0099AA';

        $style_attr = 'style="background-color:' . esc_attr( $bg_color ) . ';"';
      ?>
      <div class="col">

        <div class="column-inner" <?php echo $style_attr; ?>>

          <div class="date-wrapper">
            <?php if ( $date ) : ?>
              <div class="date"><?php echo esc_html( $date ); ?></div>
            <?php endif; ?>
          </div>

          <?php if ( $title ) : ?>
            <h3 class="inner-title"><?php echo $title; ?></h3>
          <?php endif; ?>

          <?php if ( $description ) : ?>
            <div class="description body-text">
              <?php echo wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>

          <?php if ( $linkToMedia ) :
            $link_url    = esc_url( $linkToMedia['url'] );
            $link_target = esc_attr( $linkToMedia['target'] ?: '_self' );
          ?>
            <a href="<?php echo $link_url; ?>"
              target="<?php echo $link_target; ?>"
              class="btn btn--rounded">
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          <?php endif; ?>

        </div><!-- end column inner -->

      </div>
      <?php endwhile; ?>
    </div>
    <?php endif; ?>
  </div>
</div>
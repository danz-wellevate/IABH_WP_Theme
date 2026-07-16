<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$disable_top    = get_field('disable_padding_top');
$disable_bottom = get_field('disable_padding_bottom');

// Mobile margin bottom field (Radio Button: 'Default' or 'yes')
$mobile_margin_bottom = get_field('mobile_margin_bottom');

// Base class (existing)
$class_name = 'block--custom-layout__full-width-content';

if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// Conditional classes
if ( $disable_top ) {
    $class_name .= ' disabled-padding-top';
}

if ( $disable_bottom ) {
    $class_name .= ' disabled-padding-bottom';
}

if ( $disable_top || $disable_bottom ) {
    $class_name .= ' disabled-padding';
}

// Add mobile margin bottom class when "yes" is selected
if ( $mobile_margin_bottom === 'yes' ) {
    $class_name .= ' mobile-margin-bottom--reduced';
}

// ACF fields
$bgColor = get_field('full-width-content_background_color');

?>

<div class="block--custom-layout <?php echo esc_attr( $class_name ); ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="fullwidth-content-wrapper lazyload" data-bg="<?php the_field('fw_background_image'); ?>";>
      <div class="content">
        <h2 class="title"><?php the_field('fw_title'); ?></h2>
        <div class="description body-text"><?php the_field('fw_textarea'); ?></div>

        <?php if ( have_rows('inline_text') ) : ?>
          <ul class="inline-text">
            <?php while ( have_rows('inline_text') ) : the_row(); 
              $icon = get_sub_field('svg_icon');
              $text = get_sub_field('content');
            ?>
              <li>
                <?php if ( $icon ) : ?>
                  <div class="svg">
                    <?= $icon ?>
                  </div>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                  <div class="text">
                    <?php echo wp_kses_post( $text ); ?>
                  </div>
                <?php endif; ?>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>


        <?php
        $fw_cta_link = get_field('fw_cta_link');
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
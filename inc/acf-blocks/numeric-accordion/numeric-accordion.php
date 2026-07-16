<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__numeric-accordion';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('numeric-accordion_background_color');

$sectionHeader = get_field('accordion_section_header');

?>

<div class="block--custom-layout <?= esc_attr($class_name); ?>" <?= $anchor_id; ?>
     style="background-color: <?= esc_attr($bgColor); ?>;">
  <div class="container">

    <?php if ( $sectionHeader ) : ?>
      <div class="section-header-wrapper">
        <h2 class="section-header"><?= esc_html($sectionHeader); ?></h2>
      </div>
    <?php endif; ?>

    <?php if ( have_rows('numeric_accordion') ) : ?>
      <div class="numeric-accordion">
        <?php
        $i = 1;
        while ( have_rows('numeric_accordion') ) : the_row();
          $itemTitle      = get_sub_field('accordion_header');
          $itemContent    = get_sub_field('accordion_content');
          $itemBackground = get_sub_field('accordion_background_color');
        ?>
          <div class="accordion-item"
               data-accent="<?= esc_attr($itemBackground); ?>">

            <div class="accordion-header">
              <div class="accordion-number"
                   style="background-color: <?= esc_attr($itemBackground); ?>">
                <?= $i; ?>
              </div>

              <div class="accordion-title">
                <?= esc_html($itemTitle); ?>
              </div>

              <svg class="accordion-icon"
                   xmlns="http://www.w3.org/2000/svg"
                   width="19" height="10"
                   viewBox="0 0 19 10" fill="none">
                <path d="M16.9039 0L1.41154 0C0.15541 0 -0.472656 1.51783
                         0.417104 2.4076L7.19502 9.18548
                         C8.28105 10.2715 10.0475 10.2715
                         11.1335 9.18548L17.9114 2.4076
                         C18.7881 1.51783 18.16 0 16.9039 0Z"
                      fill="#A9AAAC"/>
              </svg>
            </div>

            <div class="accordion-content body-text">
              <div class="rich-text">
                <?= wp_kses_post($itemContent); ?>
              </div>
            </div>
          </div>
        <?php
          $i++;
        endwhile;
        ?>
      </div>
    <?php endif; ?>

  </div>
</div>


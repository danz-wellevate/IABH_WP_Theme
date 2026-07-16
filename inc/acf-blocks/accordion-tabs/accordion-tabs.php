<?php
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

$class_name = 'block--custom-layout__accordion-tabs';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$bgColor        = get_field('accordion-tabs_background_color');
$show_count     = get_field('accordion_show_count');
$padding_top    = get_field('paddingtop');
$padding_bottom = get_field('paddingbottom');

$container_class = 'container';
if ($padding_top)    $container_class .= ' padding-top';
if ($padding_bottom) $container_class .= ' padding-bottom';
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="<?= $container_class ?>">
    <div class="accordion-header">
      <?php $header = get_field('accordion_header'); if ($header): ?>
        <h2 class="section-header"><?php echo esc_html($header); ?></h2>
      <?php endif; ?>
    </div>
    <div class="accordion-tabs">
      <?php if( have_rows('accordion') ): ?>
        <?php $count = 1; while( have_rows('accordion') ): the_row();
          $tab_title   = get_sub_field('accordion_title');
          $tab_content = get_sub_field('accordion_content');
        ?>
        <div class="accordion-tabs__item<?= $show_count ? ' accordion-tabs__item--has-count' : '' ?>">
          <div class="accordion-container">
            <?php if ( $show_count ): ?>
              <div class="accordion-tabs__count">
                <span><?= $count; ?></span>
              </div>
            <?php endif; ?>
            <div class="accordion-tabs__body">
              <div class="accordion-tabs__title">
                <h3><?php echo esc_html($tab_title); ?></h3>
                <svg class="accordion-tabs__chevron" xmlns="http://www.w3.org/2000/svg" width="19" height="10" viewBox="0 0 19 10" fill="none">
                  <path d="M16.9039 0L1.41154 0C0.15541 0 -0.472656 1.51783 0.417104 2.4076L7.19502 9.18548C8.28105 10.2715 10.0475 10.2715 11.1335 9.18548L17.9114 2.4076C18.7881 1.51783 18.16 0 16.9039 0Z" fill="#A9AAAC"/>
                </svg>
              </div>
            </div>
          </div>
          <div class="accordion-tabs__content-wrapper">
            <div class="accordion-tabs__content body-text">
              <?php echo $tab_content; ?>
            </div>
          </div>
        </div>
        <?php $count++; endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
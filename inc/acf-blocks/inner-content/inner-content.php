
<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__inner-content';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('inner-content_background_color');
$image = get_field('inner-content_image');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <?php
$breadcrumbs = my_theme_breadcrumbs();
if ( count($breadcrumbs) > 1 ) : // Only show if there's a parent
?>
<div class="block--breadcrumb">
  <nav aria-label="Breadcrumb">
    <ol class="breadcrumb__list">
      <?php foreach ( $breadcrumbs as $index => $crumb ) : 
        $is_last = $index === array_key_last($breadcrumbs);
      ?>
        <li class="breadcrumb__item <?= $is_last ? 'breadcrumb__item--current' : '' ?>">
          <?php if ( $crumb['url'] && ! $is_last ) : ?>
            <a href="<?= esc_url($crumb['url']) ?>" class="breadcrumb__link body-text">
              <?= esc_html($crumb['label']) ?>
            </a>
            <span class="breadcrumb__separator body-text" aria-hidden="true">›</span>
          <?php else : ?>
            <span class="breadcrumb__current body-text" aria-current="page">
              <?= esc_html($crumb['label']) ?>
            </span>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>
  </nav>
</div>
<?php endif; ?>

    <?php if ( get_field('inner-content_header') ) : ?>
      <h2 class="section-header"><?= get_field('inner-content_header') ?></h2>
    <?php endif; ?>
    <div class="section">
      <?php if ( get_field('inner-content_subheader') ) : ?>
        <h2 class="section-subheader body-text"> <strong><?= get_field('inner-content_subheader') ?></strong></h2>
      <?php endif; ?>
      <?php if ( get_field('inner-content_description') ) : ?>
        <div class="body-text"><?= get_field('inner-content_description') ?></div>
      <?php endif; ?>
    </div>

    <?php if ( ! empty( $image ) ) : ?>
    <div>
      <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>" class="inner-content-image" />
      <div class="body-text description-image-text"><?= get_field('inner-content_image_description') ?></div>
    </div>  
    <?php endif; ?>
  </div>
</div>

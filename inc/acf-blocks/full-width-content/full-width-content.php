<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__full-width-content';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$background_image_desktop = get_field('background_image_desktop');
$background_image_mobile = get_field('background_image_mobile');
$header = get_field('header');
$paragraph = get_field('paragraph');
$cta_link = get_field('cta_link');
$has_key_points = have_rows('key_points');

// Card background images, exposed as CSS custom properties so mobile can fall back to desktop.
$card_style = '';
if ($background_image_desktop) {
    $card_style .= '--bg-image-desktop: url(\'' . esc_url($background_image_desktop['url']) . '\');';
}
if ($background_image_mobile) {
    $card_style .= '--bg-image-mobile: url(\'' . esc_url($background_image_mobile['url']) . '\');';
}
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?>>
  <div class="container">
    <!-- Block Content -->
    <div class="inner-container card"<?php if ($card_style) : ?> style="<?= esc_attr($card_style) ?>"<?php endif; ?>>
      <?php if ($header) : ?>
        <h3 class="card-header"><?= esc_html($header) ?></h3>
      <?php endif; ?>

      <?php if ($paragraph) : ?>
        <div class="card-paragraph body-text">
          <?= $paragraph ?>
        </div>
      <?php endif; ?>

      <?php if ($has_key_points) : ?>
        <ul class="key-points">
          <?php while (have_rows('key_points')) : the_row();
            $single_text = get_sub_field('single_text');
            if (!$single_text) continue;
          ?>
            <li class="key-points__item">
              <span class="key-points__icon" aria-hidden="true"></span>
              <span class="key-points__text"><?= esc_html($single_text) ?></span>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>

      <?php if ($cta_link) :
        $link_url = $cta_link['url'];
        $link_title = $cta_link['title'] ?: 'Learn more';
        $link_target = $cta_link['target'] ?: '_self';
      ?>
        <a class="btn btn--stroked-white card-cta" href="<?= esc_url($link_url) ?>" target="<?= esc_attr($link_target) ?>">
          <?= esc_html($link_title) ?>
          <span class="card-cta__icon" aria-hidden="true"></span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

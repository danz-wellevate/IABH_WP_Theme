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
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <path d="M6.2001 8.6001L7.8001 10.2001L11.0001 7.0001M16.6001 8.6001C16.6001 13.0184 13.0184 16.6001 8.6001 16.6001C4.18182 16.6001 0.600098 13.0184 0.600098 8.6001C0.600098 4.18182 4.18182 0.600098 8.6001 0.600098C13.0184 0.600098 16.6001 4.18182 16.6001 8.6001Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
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
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
  <path d="M4.79988 7.59988H4.80688M7.59987 7.59988H7.60687M10.3999 7.59988H10.4069M1.29428 10.6393C1.39721 10.8989 1.42012 11.1834 1.36008 11.4562L0.614581 13.7592C0.59056 13.876 0.596771 13.997 0.632624 14.1107C0.668478 14.2244 0.732785 14.3271 0.819448 14.409C0.906111 14.4909 1.01226 14.5493 1.12782 14.5786C1.24338 14.608 1.36453 14.6074 1.47978 14.5768L3.86888 13.8782C4.12628 13.8271 4.39285 13.8494 4.63818 13.9426C6.13295 14.6406 7.82623 14.7883 9.41928 14.3596C11.0123 13.9308 12.4028 12.9532 13.3453 11.5992C14.2878 10.2452 14.7218 8.60186 14.5707 6.95906C14.4196 5.31626 13.6932 3.77961 12.5195 2.62022C11.3459 1.46083 9.80046 0.75321 8.15594 0.622211C6.51142 0.491212 4.87347 0.94525 3.53109 1.90422C2.1887 2.86319 1.22815 4.26546 0.818906 5.86362C0.40966 7.46179 0.57802 9.15314 1.29428 10.6393Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

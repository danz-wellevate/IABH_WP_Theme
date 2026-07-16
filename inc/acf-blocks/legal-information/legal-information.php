<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__legal-information';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('legal-information_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="section-header-wrapper">
      <?php if( get_field('header') ): ?>
        <h2 class="section-header"><?= esc_html(get_field('header')); ?></h2>
      <?php endif; ?>
     </div>
  </div>


  <div class="container">
    <div class="content-header">
      <div class="col">
        <?php if( get_field('content_header') ): ?>
          <div class="superheader body-text">
            <?= get_field('content_header') ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col">
        <?php
          $getemail = get_field('email');
          $getphone = get_field('phone');
        ?>
        <?php if( $getemail ): ?>
          <a href="<?= esc_url($getemail['url']) ?>" style="text-decoration: underline;" <?php if( !empty($getemail['target']) ) echo 'target="' . esc_attr($getemail['target']) . '"'; ?>>
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M1.52596 0.862583L7.23615 6.68921C8.48156 7.95702 10.5174 7.95811 11.7638 6.68921L17.474 0.862583C17.5315 0.803929 17.5231 0.707338 17.4564 0.659885C16.874 0.245604 16.1654 0 15.4021 0H3.59793C2.83458 0 2.12596 0.245646 1.54355 0.659885C1.47684 0.707338 1.46846 0.803929 1.52596 0.862583ZM0 3.66966C0 3.05744 0.148823 2.47899 0.410967 1.97056C0.45196 1.89102 0.555868 1.87494 0.618163 1.93847L6.25607 7.68884C8.04141 9.51245 10.9575 9.51351 12.7439 7.68884L18.3818 1.93847C18.4441 1.87494 18.548 1.89102 18.589 1.97056C18.8511 2.47899 19 3.05748 19 3.66966V11.3303C19 13.3553 17.385 15 15.4021 15H3.59793C1.61505 15 0 13.3553 0 11.3303V3.66966Z" fill="#24356D"/>
            </svg>
            <?= esc_html($getemail['title']) ?>
          </a>
        <?php endif; ?>
        <?php if( $getphone ): ?>
          <a href="<?= esc_url($getphone['url']) ?>" style="text-decoration: underline;" <?php if( !empty($getphone['target']) ) echo 'target="' . esc_attr($getphone['target']) . '"'; ?>>
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
              <path d="M14.8971 12.5283C13.8097 11.5982 12.7061 11.0349 11.6321 11.9635L10.9908 12.5248C10.5215 12.9322 9.64909 14.8358 6.27593 10.9555C2.90348 7.08008 4.91037 6.47668 5.38031 6.07277L6.02516 5.51081C7.09358 4.58007 6.69038 3.40838 5.91979 2.20228L5.45477 1.47173C4.68067 0.268437 3.83773 -0.521817 2.7665 0.407522L2.18768 0.913285C1.71423 1.25819 0.390819 2.37929 0.0698005 4.50912C-0.316546 7.06463 0.902202 9.99102 3.69443 13.2019C6.48315 16.4142 9.21357 18.0277 11.8 17.9996C13.9495 17.9765 15.2476 16.823 15.6536 16.4037L16.2345 15.8972C17.303 14.9686 16.6392 14.0231 15.5511 13.0909L14.8971 12.5283Z" fill="#24356D"/>
            </svg>
            <?= esc_html($getphone['title']) ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="main-content">
      <?php if( get_field('content_body') ): ?>
        <div class="legal-information-content body-text">
          <?= wp_kses_post(get_field('content_body')); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
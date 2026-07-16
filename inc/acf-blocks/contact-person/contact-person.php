<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__contact-person';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('contact-person_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="section-header-wrapper">
      <?php 
      $section_header = get_field('section_header');
      if( !empty( $section_header ) ): ?>
        <h2 class="section-header"><?= $section_header ?></h2>
      <?php endif; ?>
    </div>

  <?php if( have_rows('contact_person_group') ): ?>
  <div class="cp-wrapper">
    <?php while( have_rows('contact_person_group') ) : the_row(); 
      $bgColor = get_sub_field('background_color');
      $svgIcon = get_sub_field('svg_icon');
      $departmentHead = get_sub_field('department_head');
    ?>
      <div class="cp-item">
        <div class="icon-wrapper" style="background-color: <?= esc_attr( $bgColor ); ?>;">
          <div class="svg">
            <?= $svgIcon ?>
          </div>
          <p><?= $departmentHead ?></p>
        </div>

        <?php if( have_rows('profile') ): ?>
          <div class="cp-profiles-wrapper">
          <?php while( have_rows('profile') ) : the_row(); 
            $profileImg = get_sub_field('image');
            $profileName = get_sub_field('name');
            $profileEmail = get_sub_field('email');
          ?>
          <div class="cp-profiles">
            <?php if( !empty( $profileImg ) ): ?>
                <img src="<?php echo esc_url($profileImg['url']); ?>" alt="<?php echo esc_attr($profileImg['alt']); ?>" />
            <?php endif; ?>
            <div class="details">
              <?php if( !empty( $profileName ) ): ?>
                <h4><?= $profileName ?></h4>
              <?php endif; ?>
              <?php if ( ! empty( $profileEmail ) ) : ?>
                <a href="<?php echo esc_url( 'mailto:' . antispambot( $profileEmail ) ); ?>" class="email-link">
                  <span><?php esc_html_e( 'E-mail senden', 'textdomain' ); ?></span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                  </svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
          <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
  <?php endif; ?>

  </div>
</div>
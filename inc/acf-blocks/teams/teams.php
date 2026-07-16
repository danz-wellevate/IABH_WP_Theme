<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__teams';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('teams_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="teams-header">
      <?php
      $header = get_field('teams_header');
      if ($header):
      ?>
        <h2 class="section-header"><?php echo esc_html($header); ?></h2>
      <?php
      endif;
      ?>
    </div>
    <div class="teams__list">
      <?php if( have_rows('team_profile') ): ?>
        <?php while( have_rows('team_profile') ): the_row(); 
          // Variables
          $photo = get_sub_field('team_photo');
          $tab_title = get_sub_field('team_name');
          $tab_position = get_sub_field('team_position');
          $tab_content = get_sub_field('team_bio');
          $tab_social = get_sub_field('team_social');
          $profileBgColor = get_sub_field('teams_background_color');
        ?>
          <div class="teams__item">
            <!-- FIX: removed background-color from here — it caused the color to bleed below the image -->
            <div class="teams__profile">
              <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" class="teams__photo" />
              
              <!-- FIX: background-color moved here so it only covers the info area, not the full card height -->
              <div class="teams__info" style="background-color: <?= esc_attr($profileBgColor) ?>;">
                <p><?= $tab_title ?></p>
                <span><?= $tab_position ?></span>
                <div class="teams__social">
                  <?php 
                  if ( $tab_social ) :
                    $url    = esc_url( $tab_social['url'] );
                    $title  = esc_attr( $tab_social['title'] );
                    $target = $tab_social['target'] ? esc_attr( $tab_social['target'] ) : '_self';
                  ?>
                    <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" aria-label="<?php echo $title; ?>">
                      <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                  <?php endif; ?>
                  <?php
                  $tab_email = get_sub_field('email');
                  if ( $tab_email ) :
                  ?>
                    <a href="mailto:<?php echo esc_attr( sanitize_email( $tab_email ) ); ?>" aria-label="Email <?php echo esc_attr($tab_position); ?>">
                      <i class="fa-solid fa-envelope"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="teams__content">
              <?php if( have_rows('team_role') ): ?>
                <div class="expertise">
                  <?php while( have_rows('team_role') ): the_row();
                    $expertise_item = get_sub_field('expertise');
                  ?>
                    <span class="expertise__item"><?php echo esc_html($expertise_item); ?></span>
                  <?php endwhile; ?>
                </div>
              <?php endif; ?>
              <div class="body-text">
                <?php echo $tab_content; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
     </div>
  </div>
</div>
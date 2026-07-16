<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__news-who-we-are';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('news-who-we-are_background_color');
$header = get_field('header');
$content = get_field('content_area');

?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <div class="main-content-wrapper">
      <div class="col">
        <div class="section-header-wrapper">
          <h2 class="section-header"><?= $header?></h2>
        </div>
      </div>
      <div class="col">
        <?php if ($content) : ?>
        <div class="rich-text">
          <?= $content ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="grid-content-wrapper">
      <div class="section-header-wrapper">
        <?php 
        $gridHeader = get_field('grid_header'); 
        if ($gridHeader) :
        ?>
          <h2 class="section-header"><?= $gridHeader ?></h2>
        <?php endif; ?>
      </div>
      <?php if ( have_rows('fundamentals') ) : ?>
        <div class="checkbox-wrapper">
          <?php while ( have_rows('fundamentals') ) : the_row();
            $item = get_sub_field('item');
          ?>
            <div class="checkbox-item">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M20.0072 2.51C29.6706 2.51 37.5074 10.3468 37.5074 20.0102C37.5074 29.6736 29.6706 37.5104 20.0072 37.5104C10.3438 37.5104 2.50705 29.6736 2.50705 20.0102C2.50705 10.3468 10.3438 2.51 20.0072 2.51ZM16.3731 25.6944L12.0886 21.4064C11.3587 20.676 11.3586 19.485 12.0886 18.7548C12.8189 18.0247 14.0152 18.0293 14.7401 18.7548L17.7606 21.7777L25.2747 14.2636C26.0049 13.5334 27.196 13.5334 27.9261 14.2636C28.6563 14.9937 28.6553 16.1859 27.9261 16.9151L19.0842 25.757C18.355 26.4862 17.1628 26.4872 16.4327 25.757C16.4122 25.7365 16.3924 25.7156 16.3731 25.6944Z" fill="#00A4C3"/>
                </svg>
              </div>

              <?php if ( $item ) : ?>
                <div class="description">
                  <p class="body-text"><?php echo esc_html( $item ); ?></p>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>

    </div>

  </div>
</div>
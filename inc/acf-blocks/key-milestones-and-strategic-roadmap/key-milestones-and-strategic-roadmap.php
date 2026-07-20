<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__key-milestones-and-strategic-roadmap';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('key-milestones-and-strategic-roadmap_background_color');
$header = get_field('header');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="col">
        <div class="header">
          <h2><?= esc_html($header) ?></h2>
        </div>
      </div>
      <div class="col">
        <div class="content">

          <div class="events-repeater">
            <?php if (have_rows('events')) : ?>
              <?php while (have_rows('events')) : the_row(); ?>
                <?php
                $featured_image = get_sub_field('featured_image');
                $status = get_sub_field('status');
                $status_value = $status[0]['value'] ?? '';
                $status_label = $status[0]['label'] ?? '';
                $date = get_sub_field('date');
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $button_type = get_sub_field('button_type');
                $button_value = $button_type['value'] ?? '';
                $button_label = $button_type['label'] ?? '';
                $link = get_sub_field('link');
                ?>
                <div class="item item--<?= esc_attr($status_value) ?>">
                  <div class="item__image">
                    <?php if ($status_label) : ?>
                      <span class="item__badge"><?= esc_html($status_label) ?></span>
                    <?php endif; ?>
                    <?php if ($featured_image) : ?>
                      <img src="<?= esc_url($featured_image['url']) ?>" alt="<?= esc_attr($featured_image['alt']) ?>">
                    <?php endif; ?>
                  </div>
                  <div class="item__body">
                    <?php if ($date) : ?>
                      <div class="item__date">
                        <span class="item__dot"></span>
                        <?= esc_html($date) ?>
                      </div>
                    <?php endif; ?>

                    <?php if ($title) : ?>
                      <h3 class="item__title"><?= esc_html($title) ?></h3>
                    <?php endif; ?>

                    <?php if ($description) : ?>
                      <div class="item__description"><?= $description ?></div>
                    <?php endif; ?>

                    <?php if ('announcement' === $button_value) : ?>
                      <div class="item__announcement">
                        <svg class="icon icon--send" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M21 3L2 10.5L10.5 13.5M21 3L13.5 21.5L10.5 13.5M21 3L10.5 13.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span><?= esc_html($button_label) ?></span>
                      </div>
                    <?php elseif ($button_value) : ?>
                      <a class="item__button" href="<?= esc_url($link ?: '#') ?>">
                        <?php if ('save-date' === $button_value) : ?>
                          <svg class="icon icon--calendar" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M3 9.5H21" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 3V6.5M16 3V6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M12 13V17M10 15H14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                          </svg>
                        <?php endif; ?>
                        <span><?= esc_html($button_label) ?></span>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
     </div>
  </div>
</div>

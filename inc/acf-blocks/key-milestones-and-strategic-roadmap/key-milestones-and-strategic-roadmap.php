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
$image_overlay = get_field('image_overlay');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class=" container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="col">
        <h2 class="header"><?= $header ?></h2>
      </div>
      <div class="col">
        <div class="content">

          <div class="events-track">
            <div class="events-repeater" tabindex="0">
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
                  $cta_link = get_sub_field('cta_link');
                 
                  ?>
                  <div class="item item--<?= esc_attr($status_value) ?>">
                   <div class="item__image">
  <?php if ($status_label) : ?>
    <span class="item__badge"><?= esc_html($status_label) ?></span>
  <?php endif; ?>

  <?php if ($featured_image) : ?>
    <img
      class="item__image-featured"
      src="<?= esc_url($featured_image['url']) ?>"
      alt="<?= esc_attr($featured_image['alt']) ?>"
    >
  <?php endif; ?>

  <?php if ($image_overlay) : ?>
    <img
      class="item__image-overlay"
      src="<?= esc_url($image_overlay['url']) ?>"
      alt=""
      aria-hidden="true"
    >
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
                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                            <path d="M2.81062 8.70536C2.81062 10.6185 3.43114 12.4801 4.57904 14.0106C4.81355 14.3233 5.16266 14.53 5.54958 14.5853C5.9365 14.6406 6.32952 14.5399 6.6422 14.3054C6.95488 14.0708 7.16159 13.7217 7.21686 13.3348C7.27214 12.9479 7.17144 12.5549 6.93694 12.2422C6.17167 11.2218 5.75799 9.9808 5.75799 8.70536M4.28431 2.81062V8.70536M6.49483 2.81062C8.73585 2.86835 10.9261 2.13826 12.6843 0.747466C12.7938 0.665362 12.9239 0.615364 13.0602 0.603075C13.1965 0.590786 13.3335 0.616692 13.4559 0.677888C13.5783 0.739085 13.6813 0.833156 13.7532 0.949559C13.8251 1.06596 13.8633 1.2001 13.8633 1.33694V10.179C13.8633 10.3159 13.8251 10.45 13.7532 10.5664C13.6813 10.6828 13.5783 10.7769 13.4559 10.8381C13.3335 10.8993 13.1965 10.9252 13.0602 10.9129C12.9239 10.9006 12.7938 10.8506 12.6843 10.7685C10.9261 9.37772 8.73585 8.64763 6.49483 8.70536H2.07378C1.68294 8.70536 1.3081 8.55009 1.03173 8.27373C0.75536 7.99736 0.600098 7.62252 0.600098 7.23167V4.28431C0.600098 3.89346 0.75536 3.51862 1.03173 3.24226C1.3081 2.96589 1.68294 2.81062 2.07378 2.81062H6.49483Z" stroke="#646464" stroke-opacity="0.6" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                          <span><?= esc_html($button_label) ?></span>
                        </div>
                      <?php elseif ($button_value) : ?>
                       <a
                          class="item__button <?= ('save-date' === $button_value) ? 'item__button--save-date' : ''; ?>"
                          href="<?= esc_url($cta_link['url'] ?? '#') ?>"
                          target="<?= esc_attr($cta_link['target'] ?: '_self') ?>"
                        >
                          <?php if ('save-date' === $button_value) : ?>
                            <span class="save-date-label"><?= esc_html($button_label) ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                              <path d="M4 0.5V1.9M4 1.9V3.3M4 1.9H9.6M4 1.9H1.9C1.5287 1.9 1.1726 2.0475 0.91005 2.31005C0.6475 2.5726 0.5 2.9287 0.5 3.3V6.1M9.6 0.5V1.9M9.6 1.9V3.3M9.6 1.9H11.7C12.0713 1.9 12.4274 2.0475 12.6899 2.31005C12.9525 2.5726 13.1 2.9287 13.1 3.3V6.1M13.1 8.9V6.1M13.1 6.1H0.5M0.5 6.1V13.1C0.5 13.4713 0.6475 13.8274 0.91005 14.0899C1.1726 14.3525 1.5287 14.5 1.9 14.5H7.5M9.6 13.1L11 14.5L13.8 11.7" stroke="#4A92A2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                           
                          <?php else : ?>
                            <span><?= esc_html($button_label) ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                              <path d="M0.600098 5.60001H10.6001M5.6001 10.6L10.6001 5.60001L5.6001 0.600006" stroke="#4A92A2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          <?php endif; ?>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>

     
              <div class="events-scrollbar">
                <div class="events-scrollbar__thumb"></div>
              </div>
 

          </div>

        </div>
      </div>
     </div>
  </div>
</div>
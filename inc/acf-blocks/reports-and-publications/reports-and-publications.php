<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__reports-and-publications';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('reports-and-publications_background_color');
$header = get_field('header');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="row">
        <h2 class="header"><?= esc_html($header) ?></h2>
      </div>
      <div class="row">
        <div class="content">
          <div class="report-repeater">
            <?php if (have_rows('reports_and_publications')) : ?>
              <?php while (have_rows('reports_and_publications')) : the_row(); ?>
                <?php
                $year = get_sub_field('year');
                $title = get_sub_field('title');
                $author = get_sub_field('author');
                $cta_link = get_sub_field('cta_link');
                $image = get_sub_field('image');
                ?>
                <div class="item">
                  <div class="details">
                    <?php if ($year) : ?>
                      <div class="date"><?= esc_html($year) ?></div>
                    <?php endif; ?>
                    <?php if ($title) : ?>
                      <div class="title">
                        <h3><?= esc_html($title) ?></h3>
                      </div>
                    <?php endif; ?>
                    <?php if ($author) : ?>
                      <div class="author">
                        <div class="author-icon"></div>
                        <ul class="author-list">
                          <li><?= esc_html($author) ?></li>
                        </ul>
                      </div>
                    <?php endif; ?>
                    <?php if ($cta_link) : ?>
                      <a href="<?= esc_url($cta_link['url']) ?>" class="link-report" target="<?= esc_attr($cta_link['target'] ?: '_self') ?>">
                        <?= esc_html($cta_link['title'] ?: 'Read the report') ?>
                      </a>
                    <?php endif; ?>
                  </div>

                  <div class="image">
                    <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>">
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

<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__news-article';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('news-article_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->

    <div class="section-header-wrapper">
      <?php if( get_field('news_header') ): ?>
        <h2 class="section-header"><?= esc_html(get_field('news_header')); ?></h2>
      <?php endif; ?>
    </div>

    <div class="news-article__repeater">
      <?php
      if( have_rows('featured_news') ):
        while( have_rows('featured_news') ): the_row();
          $news_item = get_sub_field('news_item');
          if( $news_item ):
            $permalink = get_permalink($news_item->ID);
            $featured_image = get_the_post_thumbnail($news_item->ID, 'medium');
            $title = get_the_title($news_item->ID);
            ?>
            <a href="<?= esc_url($permalink) ?>">
            <article class="news-article__item">
              
              <div class="featured-image" style="background-image: url('<?= esc_url(get_the_post_thumbnail_url($news_item->ID, 'medium')) ?>');">
                <div class="image-overlay"></div>
              </div>
              <div class="featured-post-title">
                <h3><?= esc_html($title) ?></h3>
              </div>
              
            </article>
            </a>
            <?php
          endif;
        endwhile;
      endif;
      ?>
    </div>
  </div>
</div>

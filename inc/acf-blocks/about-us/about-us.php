<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__about-us';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('about-us_background_color');

$description = get_field('about_us_description');

?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
    <?php if ( ! empty( $description ) ) : ?>
      <div class="description body-text">
        <?=  $description ?>
      </div>
    <?php endif; ?>

    <div class="partners__list">
      <?php
$partners = get_field('partners');

if ($partners) :
    foreach ($partners as $partner) :

        $svg_logo  = $partner['partner_logo'];
        $svg_title = $partner['title'];
        $svg_link  = $partner['link'];
        ?>

        <a href="<?php echo esc_url($svg_link); ?>" class="partner__item" target="_blank">

            <?php if ($svg_logo) : ?>
                <div class="partner__logo">
                    <img
                        src="<?php echo esc_url($svg_logo['url']); ?>"
                        alt="<?php echo esc_attr($svg_logo['alt']); ?>"
                    >
                </div>
            <?php endif; ?>

            <?php if ($svg_title) : ?>
                <div class="partner__title body-text">
                    <?php echo esc_html($svg_title); ?>
                </div>
            <?php endif; ?>

        </a>

        <?php
    endforeach;
endif;
?>
    </div>
  </div>
</div>

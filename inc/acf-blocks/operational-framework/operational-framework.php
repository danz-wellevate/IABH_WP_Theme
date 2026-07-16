<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__operational-framework';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('operational-framework_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->

    <div class="section-header">
        <h2>Wärmeverbünde für Gemeinden: WNO als Partner für Planung, Finanzierung und Betrieb.</h2>
        <div class="overview-description">Gemeinden stehen im Zentrum der Wärmewende. WNO übernimmt Entwicklung, Finanzierung, Bau und Betrieb eines Wärmeverbunds. Ihre Gemeinde kann damit eine nachhaltige Lösung realisieren, ohne eine eigene Projektorganisation aufzubauen.</div>
    </div>

    <div class="main-content">
      <div class="col">
        <h4 class="content-header">Nutzen:</h4>

        <div class="nutzen-repeater">
          <?php if( have_rows('nutzen_repeater') ): ?>
            <?php while( have_rows('nutzen_repeater') ): the_row(); ?>
              <div class="item">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                  <path d="M15 19C16.1067 19 17.0501 18.6099 17.8304 17.8296C18.6101 17.0499 19 16.1067 19 15C19 13.8933 18.6101 12.9499 17.8304 12.1696C17.0501 11.3899 16.1067 11 15 11C13.8933 11 12.9501 11.3899 12.1704 12.1696C11.3901 12.9499 11 13.8933 11 15C11 16.1067 11.3901 17.0499 12.1704 17.8296C12.9501 18.6099 13.8933 19 15 19ZM15 23C13.8933 23 12.8533 22.7899 11.88 22.3696C10.9067 21.9499 10.06 21.38 9.34 20.66C8.62 19.94 8.05013 19.0933 7.6304 18.12C7.21013 17.1467 7 16.1067 7 15C7 13.8933 7.21013 12.8533 7.6304 11.88C8.05013 10.9067 8.62 10.06 9.34 9.34C10.06 8.62 10.9067 8.04987 11.88 7.6296C12.8533 7.20987 13.8933 7 15 7C16.1067 7 17.1467 7.20987 18.12 7.6296C19.0933 8.04987 19.94 8.62 20.66 9.34C21.38 10.06 21.9499 10.9067 22.3696 11.88C22.7899 12.8533 23 13.8933 23 15C23 16.1067 22.7899 17.1467 22.3696 18.12C21.9499 19.0933 21.38 19.94 20.66 20.66C19.94 21.38 19.0933 21.9499 18.12 22.3696C17.1467 22.7899 16.1067 23 15 23Z" fill="#24356D"/>
                </svg>
                <p class="body-text"><?php echo wp_kses_post(get_sub_field('description')); ?></p>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col">
        <h4 class="content-header">Leistungspaket:</h4>
        <div class="leistungspaket-repeater">
          <?php if( have_rows('leistungspaket_repeater') ): ?>
            <?php while( have_rows('leistungspaket_repeater') ): the_row();
              $icon_bgColor   = get_sub_field('image_background_color') ?: '#00A4C3';
              $description    = get_sub_field('description');
              $icon_image     = get_sub_field('icon_image');
              $icon_image_url = is_array($icon_image) ? $icon_image['url'] : $icon_image;
            ?>
              <div class="item overview-item">
                <div class="overview-icon" style="background-color: <?= esc_attr($icon_bgColor) ?>;">
                    <?php if( $icon_image_url ): ?>
                        <img src="<?= esc_url($icon_image_url) ?>" alt="">
                    <?php endif; ?>
                </div>

                <?php if( $description ): ?>
                    <p class="overview-description body-text"><?= esc_html($description) ?>test</p>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="cta-group">
      <?php if( have_rows('ctas_group_repeater') ): ?>
        <?php while( have_rows('ctas_group_repeater') ): the_row();
          $cta_style = get_sub_field('cta_style');
          $cta_link  = get_sub_field('cta_link');
          $cta_id    = get_sub_field('cta_id');
        ?>
          <?php if ($cta_link): ?>
            <a href="<?= esc_url($cta_link['url']) ?>"
              class="btn btn--<?= esc_attr($cta_style) ?>"
              <?= !empty($cta_id) ? 'id="' . esc_attr($cta_id) . '"' : '' ?>
              <?= !empty($cta_link['target']) ? 'target="' . esc_attr($cta_link['target']) . '"' : '' ?>>
              <?= esc_html($cta_link['title']) ?>
            </a>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>


  </div>
</div>

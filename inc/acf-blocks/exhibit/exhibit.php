<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__exhibit';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('exhibit_background_color');
$cta_link = get_field('cta_link');
$cta_url = $cta_link['url'] ?? '';
$cta_title = $cta_link['title'] ?? '';
$cta_target = $cta_link['target'] ?? '_self';
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->

    <div class="header-content">
        <h3 class="section-header">So kommt die Wärme ins Gebäude</h3>
    </div>

    <div class="exhibit__wrapper">
      <!-- Operations Framework Content -->

      <div class="exhibit__item ">
        <div class="img-wrapper item-1">
          <img src="/wp-content/uploads/2026/06/Energy-savings-leaf.png" alt="Wärmequellen">
        </div>
        <h3 class="exhibit__content-header text-1">Schritt 1<br> Energiezentrale</h3>
        <p class="body-text">Wärme aus erneuerbaren Quellen (z. B. Holz, Abwärme, Umweltwärme).</p>
      </div>

      <div class="divider divider-1">
        <img src="/wp-content/uploads/2026/06/divider-1.png" alt="Trennlinie">
      </div>

      <div class="exhibit__item">
        <div class="img-wrapper item-2">
        <img src="/wp-content/uploads/2026/06/Heat-pump-balance.png" alt="Wärmequellen">
        </div>
        <h3 class="exhibit__content-header text-2">Schritt 2<br> Wärmenetz</h3>
        <p class="body-text">Isolierte Leitungen bringen die Wärme effizient in Quartiere und Ortschaften.</p>
      </div>

      <div class="divider divider-2">
        <img src="/wp-content/uploads/2026/06/divider-2.png" alt="Trennlinie">
      </div>

      <div class="exhibit__item">
        <div class="img-wrapper item-3">
          <img src="/wp-content/uploads/2026/06/Water-heater.png" alt="Wärmequellen">
        </div>
        <h3 class="exhibit__content-header text-3">Schritt 3<br> Hausanschluss</h3>
        <p class="body-text">Wärme wie aus der Leitung: Heizen und Warmwasser ohne eigene Heizanlage.</p>
      </div>

    </div>

    <?php if ( $cta_url && $cta_title ) : ?>
      <div class="exhibit__cta">
        <a class="btn btn--transparent" href="<?php echo esc_url( $cta_url ); ?>" target="<?php echo esc_attr( $cta_target ); ?>">
          <?php echo esc_html( $cta_title ); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</div>

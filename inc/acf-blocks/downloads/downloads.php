<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__downloads';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('downloads_background_color');
$items   = get_field('content_repeater');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">

    <!-- Block Header -->
    <div class="section">
      <?php if ( get_field('downloads_header') ) : ?>
        <h2 class="section-header"><?= get_field('downloads_header') ?></h2>
      <?php endif; ?>
    </div>

    <!-- Cards Grid / Swiper -->
    <?php if ( $items ) : ?>
      
      <!-- Desktop Grid (visible on desktop) -->
      <div class="downloads-grid desktop-grid">
        <?php foreach ( $items as $item ) :
          $tag      = $item['tag']      ?? '';
          $header   = $item['header']   ?? '';
          $date     = $item['date']     ?? '';
          $location = $item['location'] ?? '';
          $button   = $item['button']   ?? null; 
        ?>
          <div class="downloads-card">
            <div class="tag-container">
              <?php if ( $tag ) : ?>
                <span class="downloads-card__tag"><?= esc_html($tag) ?></span>
              <?php endif; ?>
            </div>
              
            <?php if ( $header ) : ?>
              <h3 class="downloads-card__header inner-title"><?= esc_html($header) ?></h3>
            <?php endif; ?>

            <?php if ( $date || $location ) : ?>
              <div class="downloads-card__meta">
                <?php if ( $date ) : ?>
                  <span class="downloads-card__date"><strong><?= esc_html($date) ?></strong></span>
                <?php endif; ?>
                <?php if ( $date && $location ) : ?>
                  <span class="downloads-card__divider">|</span>
                <?php endif; ?>
                <?php if ( $location ) : ?>
                  <span class="downloads-card__location"><?= esc_html($location) ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if ( $button && !empty($button['url']) ) : ?>
              <a
                class="downloads-card__button"
                href="<?= esc_url($button['url']) ?>"
                <?= !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : '' ?>
                aria-label="<?= esc_attr($button['title'] ?: $header) ?>"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                  <rect width="30" height="30" rx="15" fill="#00A4C3"/>
                  <path d="M16.6267 19.788C16.6281 19.7866 16.6294 19.7852 16.6308 19.7839L20.8986 15.5216C20.9323 15.4878 20.9622 15.4503 20.9879 15.41L21.0548 15.2873L21.0827 15.2036V15.1423C21.1 15.0482 21.1 14.9518 21.0827 14.8577V14.735L21.0325 14.6402C21.0038 14.5873 20.9682 14.5385 20.9265 14.4951L16.6308 10.2161C16.3465 9.92958 15.8838 9.92773 15.5973 10.212C15.5959 10.2133 15.5945 10.2147 15.5931 10.2161C15.3176 10.505 15.3176 10.9594 15.5931 11.2482L18.1371 13.7978C18.2449 13.9077 18.2432 14.0844 18.1332 14.1922C18.082 14.2424 18.0135 14.271 17.9418 14.2719L9.63491 14.2719C9.23127 14.2719 8.90404 14.5991 8.90402 15.0027C8.90399 15.4064 9.23116 15.7336 9.6348 15.7336L17.9418 15.7336C18.0959 15.7358 18.219 15.8624 18.2168 16.0164C18.2158 16.0881 18.1873 16.1566 18.1371 16.2078L15.5931 18.7462C15.314 19.0358 15.314 19.4943 15.5931 19.7839C15.8774 20.0704 16.3401 20.0723 16.6267 19.788Z" fill="white"/>
                </svg>
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Tablet & Mobile Swiper -->
      <div class="downloads-swiper">
        <div class="swiper-wrapper">
          <?php foreach ( $items as $item ) :
            $tag      = $item['tag']      ?? '';
            $header   = $item['header']   ?? '';
            $date     = $item['date']     ?? '';
            $location = $item['location'] ?? '';
            $button   = $item['button']   ?? null; 
          ?>
            <div class="swiper-slide">
              <div class="downloads-card">
                <div class="tag-container">
                  <?php if ( $tag ) : ?>
                    <span class="downloads-card__tag"><?= esc_html($tag) ?></span>
                  <?php endif; ?>
                </div>
                  
                <?php if ( $header ) : ?>
                  <h3 class="downloads-card__header inner-title"><?= esc_html($header) ?></h3>
                <?php endif; ?>

                <?php if ( $date || $location ) : ?>
                  <div class="downloads-card__meta">
                    <?php if ( $date ) : ?>
                      <span class="downloads-card__date"><strong><?= esc_html($date) ?></strong></span>
                    <?php endif; ?>
                    <?php if ( $date && $location ) : ?>
                      <span class="downloads-card__divider">|</span>
                    <?php endif; ?>
                    <?php if ( $location ) : ?>
                      <span class="downloads-card__location"><?= esc_html($location) ?></span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

                <?php if ( $button && !empty($button['url']) ) : ?>
                  <a
                    class="downloads-card__button"
                    href="<?= esc_url($button['url']) ?>"
                    <?= !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : '' ?>
                    aria-label="<?= esc_attr($button['title'] ?: $header) ?>"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                      <rect width="30" height="30" rx="15" fill="#00A4C3"/>
                      <path d="M16.6267 19.788C16.6281 19.7866 16.6294 19.7852 16.6308 19.7839L20.8986 15.5216C20.9323 15.4878 20.9622 15.4503 20.9879 15.41L21.0548 15.2873L21.0827 15.2036V15.1423C21.1 15.0482 21.1 14.9518 21.0827 14.8577V14.735L21.0325 14.6402C21.0038 14.5873 20.9682 14.5385 20.9265 14.4951L16.6308 10.2161C16.3465 9.92958 15.8838 9.92773 15.5973 10.212C15.5959 10.2133 15.5945 10.2147 15.5931 10.2161C15.3176 10.505 15.3176 10.9594 15.5931 11.2482L18.1371 13.7978C18.2449 13.9077 18.2432 14.0844 18.1332 14.1922C18.082 14.2424 18.0135 14.271 17.9418 14.2719L9.63491 14.2719C9.23127 14.2719 8.90404 14.5991 8.90402 15.0027C8.90399 15.4064 9.23116 15.7336 9.6348 15.7336L17.9418 15.7336C18.0959 15.7358 18.219 15.8624 18.2168 16.0164C18.2158 16.0881 18.1873 16.1566 18.1371 16.2078L15.5931 18.7462C15.314 19.0358 15.314 19.4943 15.5931 19.7839C15.8774 20.0704 16.3401 20.0723 16.6267 19.788Z" fill="white"/>
                    </svg>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        
        <!-- Custom Navigation -->
        <div class="downloads-navigation">
          <div class="downloads-swiper-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10" viewBox="0 0 13 10" fill="none">
              <path d="M7.72286 9.78799C7.72425 9.78663 7.72561 9.78524 7.727 9.78386L11.9948 5.52162C12.0285 5.48776 12.0584 5.45033 12.0841 5.41004L12.151 5.28731L12.1789 5.20363V5.14225C12.1962 5.04821 12.1962 4.95179 12.1789 4.85773V4.735L12.1287 4.64015C12.1 4.5873 12.0644 4.5385 12.0227 4.49509L7.727 0.21612C7.44274 -0.0704155 6.97999 -0.0722722 6.69346 0.211988C6.69207 0.213348 6.69071 0.214734 6.68933 0.21612C6.41375 0.504957 6.41375 0.959356 6.68933 1.24822L9.23329 3.79775C9.34114 3.90774 9.33941 4.08437 9.22939 4.19221C9.17822 4.2424 9.1097 4.27095 9.03802 4.27195L0.731098 4.27195C0.327458 4.27192 0.000232697 4.59909 0.000206947 5.00273C0.000180244 5.40637 0.327354 5.73357 0.730994 5.73363L9.03802 5.73363C9.19205 5.7358 9.31519 5.86242 9.31302 6.01645C9.312 6.0881 9.28347 6.15664 9.23329 6.20782L6.68933 8.74621C6.41019 9.03578 6.41019 9.49431 6.68933 9.78388C6.97359 10.0704 7.43633 10.0723 7.72286 9.78799Z" fill="black"/>
            </svg>
          </div>

          <div class="downloads-swiper-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="10" viewBox="0 0 13 10" fill="none">
              <path d="M7.72286 9.78799C7.72425 9.78663 7.72561 9.78524 7.727 9.78386L11.9948 5.52162C12.0285 5.48776 12.0584 5.45033 12.0841 5.41004L12.151 5.28731L12.1789 5.20363V5.14225C12.1962 5.04821 12.1962 4.95179 12.1789 4.85773V4.735L12.1287 4.64015C12.1 4.5873 12.0644 4.5385 12.0227 4.49509L7.727 0.21612C7.44274 -0.0704155 6.97999 -0.0722722 6.69346 0.211988C6.69207 0.213348 6.69071 0.214734 6.68933 0.21612C6.41375 0.504957 6.41375 0.959356 6.68933 1.24822L9.23329 3.79775C9.34114 3.90774 9.33941 4.08437 9.22939 4.19221C9.17822 4.2424 9.1097 4.27095 9.03802 4.27195L0.731098 4.27195C0.327458 4.27192 0.000232697 4.59909 0.000206947 5.00273C0.000180244 5.40637 0.327354 5.73357 0.730994 5.73363L9.03802 5.73363C9.19205 5.7358 9.31519 5.86242 9.31302 6.01645C9.312 6.0881 9.28347 6.15664 9.23329 6.20782L6.68933 8.74621C6.41019 9.03578 6.41019 9.49431 6.68933 9.78388C6.97359 10.0704 7.43633 10.0723 7.72286 9.78799Z" fill="black"/>
            </svg>
          </div>
      </div>
      </div>

    <?php endif; ?>

  </div>
</div>